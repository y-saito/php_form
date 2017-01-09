<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 14:05
 */

namespace phpForm\Core\Functions;


use phpForm\Core\Render_Interface;

class RenderSmarty implements Render_Interface
{
  public $engine;
  
  public function __construct($smarty, $smartyConf_arr){
    $this->engine = $smarty;
    $this->engine->force_compile = $smartyConf_arr["force_compile"];
    $this->engine->debugging = $smartyConf_arr["debugging"];
    $this->engine->caching = $smartyConf_arr["caching"];
    $this->engine->cache_lifetime = $smartyConf_arr["cache_lifetime"];
    $this->engine->left_delimiter = $smartyConf_arr["left_delimiter"];
    $this->engine->right_delimiter = $smartyConf_arr["right_delimiter"];
  }
  
  public function assign($assign_arr = []){
    foreach($assign_arr as $name_str => $value_mixed) {
      $this->engine->assign($name_str, $value_mixed);
    }
  }
  
  public function render($template_str = ""){
    $this->engine->display($template_str);
  }
}