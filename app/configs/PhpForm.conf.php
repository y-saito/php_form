<?php
/*
siteUrl : リダイレクト用
*/
  $phpFormConf_arr = [
    "siteUrl" => "http://localhost/",
    "baseDirName" => "php_form",
    "renderEngine" => "Smarty", //今はこれだけ
    //Smarty パラメータ
    "renderConf" => [
      "force_compile" => false,
      "debugging" => false,
      "caching" => false,
      "cache_lifetime" => 0,
      //テンプレートにjs,cssが書けるように
      "left_delimiter" => '<%',
      "right_delimiter" => '%>',
    ],
    "maxWriteRetry" => 5, //ファイル読み書き込みのリトライ回数
    "writeWait"     => 3000000, //ファイル読み書き込みのリトライ回数後の待ち時間(マイクロ秒)
  ];
//make routing from uri
$phpFormConf_arr['scriptnameInfo'] = pathinfo($_SERVER['SCRIPT_NAME']);
$appInfoTmp = str_replace($phpFormConf_arr['scriptnameInfo'], '', $_SERVER['REQUEST_URI']);
$appInfoTmp = explode('/', $appInfoTmp);
$phpFormConf_arr['controller'] = $appInfoTmp[1];
$phpFormConf_arr['action']  = (isset($appInfoTmp[2]) ? $appInfoTmp[2] : '');


