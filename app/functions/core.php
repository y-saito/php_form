<?php

requireAllFuncs("./functions/");

function InitProc() {
	//can't browser cache
	header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time()-1 ) . ' GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', false );
	header( 'Pragma: no-cache' );

	//make routing
	$scriptnameInfo = pathinfo($_SERVER['SCRIPT_NAME']);
	$appInfoTmp = str_replace($scriptnameInfo['dirname'], '', $_SERVER['REQUEST_URI']);
	$appInfo = explode('/', $appInfoTmp);

	require_once "./configs/AppConf.php";
	require_once "./configs/Languages.php";
	$AppConf['appName'] = $appInfo[1];
	$AppConf['action']  = $appInfo[2];
	$AppConf['scriptnameInfo']  = $scriptnameInfo;
	$AppConf['Lang']    = $Lang;
	return $AppConf;
}

function requireAllFuncs($dir){
	$dir_last = substr($dir, -1);
	if($dir_last !== '/'){
		$dir .= '/';
	}
		
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(preg_match("/^_.*\.php$/", $file)){
					require_once($dir.$file);
				}
			}
			closedir($dh);
		}
	}
}

function sessionClear() {
	// セッション変数を全て解除する
	$_SESSION = array();

	// セッションを切断するにはセッションクッキーも削除する。
	// Note: セッション情報だけでなくセッションを破壊する。
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	    );
	}
	// 最終的に、セッションを破壊する
	session_destroy();
}

function goHome($url) {
	header("Location: {$url}");
	exit;
}

