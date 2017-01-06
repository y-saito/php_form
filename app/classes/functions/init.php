<?php
/**
 * Created by PhpStorm.
 * Date: 2017/01/07
 * Time: 16:31
 */

namespace Functions;


class init
{
  private $appInfo_arr;
  
  public function __construct()
  {
    //make routing
    $appInfoTmp = pathinfo($_SERVER['SCRIPT_NAME']);
    $appInfoTmp = str_replace($appInfoTmp['dirname'], '', $_SERVER['REQUEST_URI']);
    $this->appInfo_arr = explode('/', $appInfoTmp);
  }
  
  public function getAppInfo(){
    return $this->appInfo_arr;
  }
}