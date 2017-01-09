<?php
/*
useApp : つくるフォームのディレクトリ名
siteUrl : リダイレクト用
defaultAction : 入力画面のテンプレートファイル名(.tplは省きます。
*/
	$phpFormConf_arr = array(
		"useApp" => array(
			//"reply",
			"noreply",
			//"message",
		),
		"siteUrl" => "http://php-form.local/",
    "baseDirName" => "php_form",
		"defaultAction" => "entry",
		"maxWriteRetry" => 5, //ファイル読み書き込みのリトライ回数
		"writeWait"     => 3000000, //ファイル読み書き込みのリトライ回数後の待ち時間(マイクロ秒)
	);
//make routing from uri
$phpFormConf_arr['scriptnameInfo'] = pathinfo($_SERVER['SCRIPT_NAME']);
$appInfoTmp = str_replace($phpFormConf_arr['scriptnameInfo'], '', $_SERVER['REQUEST_URI']);
$appInfoTmp = explode('/', $appInfoTmp);
$phpFormConf_arr['controller'] = $appInfoTmp[1];
$phpFormConf_arr['action']  = $appInfoTmp[2];