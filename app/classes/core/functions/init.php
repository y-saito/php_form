<?php
/**
 * Created by PhpStorm.
 * Date: 2017/01/07
 * Time: 16:31
 */

namespace phpForm\Core;

class init
{
  private $appConf_arr=[
    "useController" => [
      //"reply",
      "noreply",
      //"message",
    ],
    "siteUrl" => "http://php-form.local/",
    "baseDirName" => "php_form",
    "defaultAction" => "entry",
    "maxWriteRetry" => 5, //ファイル読み書き込みのリトライ回数
    "writeWait"     => 3000000, //ファイル読み書き込みのリトライ回数後の待ち時間(マイクロ秒)
  ];
  
  public function __construct()
  {
    //make routing from uri
    $this->appConf_arr['scriptnameInfo'] = pathinfo($_SERVER['SCRIPT_NAME']);
    $appInfoTmp = str_replace($this->appConf_arr['scriptnameInfo'], '', $_SERVER['REQUEST_URI']);
    $appInfoTmp = explode('/', $appInfoTmp);
    $this->appConf_arr['controller'] = $appInfoTmp[1];
    $this->appConf_arr['action']  = $appInfoTmp[2];
  
  }
  
  public function getAppConfArr(){
    return $this->appConf_arr;
  }
  public function getAppConfArrByKey($key){
    return $this->appConf_arr[$key];
  }
}