<?php

/* Init */
require_once "./functions/core.php";

global $AppConf;
$AppConf = InitProc();
$dir  = $AppConf['appName'];
$mode = ($AppConf['action'] === "" || !isset($AppConf['action'])) ? $AppConf['defaultAction']:$AppConf['action'];

/* App exist check */
if(!in_array($dir, $AppConf['useApp'])) {
	sessionClear();
	goHome($AppConf['siteUrl']);
}

require_once "./configs/{$dir}/config.php";
define("FILEDIR", $cntFileDir);

session_start();

/* Incorrect access check */
if($_SESSION['appName'] !== $dir) {
	$_SESSION = array();
	sessionClear();
	session_start();
}

$_SESSION['appName'] = $dir;

if(isset($_POST)) {
	foreach($_POST as $key => $value) {
		$_SESSION[$key] = $value;
	}
}

if($mode !== $AppConf['defaultAction'] && !isset($_SESSION['submit'])) {
	sessionClear();
	goHome("{$AppConf['scriptnameInfo']['dirname']}/{$dir}/{$AppConf['defaultAction']}/");
}

if($mode === "proc") {
	/* Proc-line */
	if($esse === 1) {
		if(!validator($eles, $_SESSION)) goHome("{$AppConf['scriptnameInfo']['dirname']}/{$dir}/{$_SESSION['mode']}/");
	}
	goHome("{$AppConf['scriptnameInfo']['dirname']}/{$dir}/{$_SESSION['submit']}");
} else {
	/* Display-line */
	$_SESSION['mode'] = $mode;
}

require('./libs/Smarty.class.php');

$smarty = new Smarty;
//$smarty->escape_html = true;
//テンプレートにjs,cssが書けるように
$smarty->left_delimiter = '<%';
$smarty->right_delimiter = '%>';

$template = "{$dir}/{$mode}.tpl";
if( !$smarty->templateExists($template) ){
	goHome($AppConf['siteUrl']);
}


//$smarty->force_compile = true;
$smarty->debugging = $smartyDebug;
$smarty->caching = $smartyCaching;
$smarty->cache_lifetime = $smartyCacheLifeTime;


/* Smarty assign start */
$smarty->assign("Dir","{$dir}",true);
$smarty->assign("Mode","{$mode}",true);

if(function_exists('hookProc')) hookProc('add_assign_array');
if(isset($AppConf['add_assign_array']) && is_array($AppConf['add_assign_array'])) {
	foreach($AppConf['add_assign_array'] as $key => $value) {
		$smarty->assign($key, $value);
	}
}

foreach($eles as $name => $validatetype) {
	if(isset($_SESSION[$name])) {
		if(function_exists('hookProc')) hookProc('before_assign', array('name'=>$name));
		$smarty->assign($name, $_SESSION[$name], true);
		if(isset($_SESSION["h__{$name}"])) $smarty->assign("h__{$name}", $_SESSION["h__{$name}"], true);
	}
}

if(count($_SESSION['errorArray']) !== 0) {
	foreach($_SESSION['errorArray'] as $key => $value) {
		$smarty->assign("err_{$key}", $value);
	}
}

if(count($_SESSION['warnArray']) !== 0) {
	foreach($_SESSION['warnArray'] as $key => $value) {
		$smarty->assign("warn_{$key}", $value);
	}
}


/* Last proc */
if(count($_SESSION['errorArray']) === 0 && $mode === "thanks") {
	//write > read cntfile
	$maxWriteRetry = $AppConf['maxWriteRetry'];
	$writeWait = $AppConf['writeWait'];
	$flagWriteError = false; //ファイル読み書きチェックフラグ
	$cntFile = FILEDIR . "{$dir}/mailcnt.txt";
	$num = (file_exists($cntFile) ? $num = file_get_contents($cntFile) : 0);
	$num = (int)$num;
	$num++;
	for($i=0;$i<$maxWriteRetry;$i++) {
		if($fp = fopen($cntFile, "w+")) {
				$fileResult = fwrite($fp, $num);
				if(!$fileResult || $fileResult === 0) {
					if(!RetryLimitCheck($i+1, $maxWriteRetry)) { //ファイル書けなければエラー
						$errMess = "### False: {$cntFile} can not write\n";
						sendMail($errto, $from, $fromname, "", $replyto, "エラー {$subject}", $errMess, $addAdminSnderInfo);
						WriteLog($errMess);
						$flagWriteError = true;
						break;
					} else {
						usleep($writeWait);
						continue;
					}
				}
		} else {
			if(!RetryLimitCheck($i+1, $maxWriteRetry)) {
				$errMess = "### False: {$cntFile} can not open\n";
				sendMail($errto, $from, $fromname, "", $replyto, "エラー {$subject}", $errMess, $addAdminSnderInfo);
				WriteLog($errMess);
				$flagWriteError = true;
				break;
			} else {
				usleep($writeWait);
				continue;
			}
		}
	}
	if($flagWriteError) $num = "NNN";

	// sendmail
	if($adminmail === 1) {
		$body = $smarty->fetch("{$dir}/{$adminmailTemp}");
		if($addNum === 0 &&  $flagWriteError) $subject = "{$num} {$subject}";
		if($addNum === 0 && !$flagWriteError) $subject = sprintf($addNumF, $num) . "{$subject}";
		sendMail($to, $from, $fromname, $bcc, $replyto, $subject, $body, $addAdminSnderInfo);
	}
	if($remail === 1) {
		$rebody = $smarty->fetch("{$dir}/{$remailTemp}");
		if($addReNum === 0 &&  $flagWriteError) $subject = "{$num} {$subject}";
		if($addReNum === 0 && !$flagWriteError) $subject = sprintf($addReNumF, $num) . "{$subject}";
		if(isset($_SESSION['email']) && $_SESSION['email'] != "") sendMail($_SESSION['email'], $from, $fromname, $bcc, $replyto, $resubject, $rebody, $addRemailSnderInfo);
	}
	sessionClear();
}

$_SESSION['errorArray'] = array();
$_SESSION['warnArray'] = array();

$smarty->display($template);

