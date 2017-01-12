<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 5:53
 */
 
namespace phpForm\Core;
 
interface Configure_Interface{

  public function getControllerConf();
  
  public function doHookProc($hookpoint="", $data=[]);

}

interface Render_Interface{
  
  public function assign($key="", $value=[]);
  
  public function render($template="");

}
 