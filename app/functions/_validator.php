<?php

function validator($eles=array(), $param=array()) {
	global $AppConf;
	$errorArray = array();
	
	foreach($eles as $key=>$val) {
		$target = $param[$key];
		$validattype = explode("_", $val);
		foreach($validattype as $vval) {
			switch($vval) {
				case "must":
					if($target === "" || is_null($target)) $errorArray[$key][] = $AppConf['Lang']['errMess']['must'];
				break;
				case "h":
					$_SESSION["h__{$key}"] = $target;
					$_SESSION[$key] = h($target);
				break;
				case "email":
					if(!checkMail($target)) $errorArray[$key][] = $AppConf['Lang']['errMess']['email'];
				break;
				case "dc":
					if(!checkDc($target)) $warnArray[$key][] = $AppConf['Lang']['warnMess']['dc'];
				break;
				default:
				break;
			}
		}
		 	//$post_mail = h($val);
	}
	if(count($warnArray) === 0) {
		$_SESSION['warnArray'] = array();
	} else {
		$_SESSION['warnArray'] = $warnArray;
	}

	if(count($errorArray) === 0) {
		$_SESSION['errorArray'] = array();
		return true;
	} else {
		$_SESSION['errorArray'] = $errorArray;
		return false;
	}
}


function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}
	else{
		return false;
	}
}

function checkDc($str) {
	$checkCode = array(
		"EUC-JP",
		"SJIS",
		"eucJP-win",
		"SJIS-win",
		"ISO-2022-JP",
		"ISO-2022-JP-MS",
	);
	for($i=0;$i<sizeof($checkCode);$i++) {
		if(strlen($str) !== strlen(mb_convert_encoding(mb_convert_encoding($str,$checkCode[$i],'UTF-8'),'UTF-8',$checkCode[$i]))) return false;
	}
	return true;
}

function h($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/*
*ファイルの状態チェック
*$return:
*0:読み込みok、書き込みok
*1:読み込みok、書き込みng
*2:読み込みng
*/
function checkFile($filename) {
	$return = 0;
	if(is_readable($filename)) {
		if(!is_writable($filename)) {
			$return = 1;
		}
	} else {
		$return = 2;
	}
	return $return;
}

function WriteLog($logMsg, $To = "") {
	error_log($logMsg); //errorlog
	if($To !== "") error_log($logMsg, 1, $To); //mail
}

function RetryLimitCheck($cnt, $maxcnt) {
	if($cnt === $maxcnt) {
		return false;
	}
	return true;
}