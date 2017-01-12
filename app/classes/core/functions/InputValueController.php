<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 14:05
 */

namespace phpForm\Core\Functions;


class InputValueController
{
  /**
   * @var $inputValue_arr array '= $_REQUEST'
   */
  private $inputValue_arr;
  
  /**
   * InputValueController constructor.
   * @param $inputValue_arr
   */
  public function __construct($inputValue_arr){
    $this->inputValue_arr = $inputValue_arr;
  }
  
  /**
   * @return array
   */
  public function getInputValueArr()
  {
    return $this->inputValue_arr;
  }
  
  public function validate()
  {
    /*
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
*/    
    }
}