<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 14:05
 */

namespace phpForm\Core\Functions;


class InputValueController implements InputValueController_interface
{
  /**
   * @var $inputValue_arr array '= $_REQUEST'
   */
  private $inputValue_arr;
  /**
   * @var
   */
  private $error_arr;
  
  /**
   * InputValueController constructor.
   * @param $inputValue_arr
   */
  public function __construct($inputValue_arr=[]){
    $this->inputValue_arr = $inputValue_arr;
  }
  
  /**
   * @return array
   */
  public function getInputValueArr()
  {
    return $this->inputValue_arr;
  }
  
  /**
   * @return mixed
   */
  public function getErrorArr()
  {
    return $this->error_arr;
  }
  
  public function validate(
    $validation_arr=[
      'inputCheck'=>[],
      'messages'=>[
        'errMess'=>[],
        'warnMess'=>[]
      ]
    ]
  )
  {
    $this->error_arr = [];
    
    foreach($validation_arr['inputCheck'] as $name=>$validatePattern) {
      try {
        if(!isset($this->inputValue_arr[$name]) || is_null($this->inputValue_arr[$name])) throw new \Exception($validation_arr["messages"]["errMess"]["system"]);
        $item = $this->inputValue_arr[$name];
        $validateType_arr = explode("_", $validatePattern);
        foreach ($validateType_arr as $validateType_str) {
          switch ($validateType_str) {
            case "must":
              $this->checkMust($item, $name, $validation_arr["messages"]["errMess"]["must"]);
              break;
            case "mail":
              if (!$this->checkMail($item)) $this->error_arr[$name][] = $errorMessages_arr["errMess"]["mail"];
              break;
            case "dc":
              if (!$this->checkDc($item)) $this->error_arr[$name][] = $errorMessages_arr["errMess"]["dc"];
              break;
            default:
              break;
          }
        }
      }catch ($exception){
        $this->error_arr['system'][] = $errorMessages_arr["errMess"]["system"];
      }
    }

    // 最後にエラーメッセージ配列を_でimplodeしてフォームnameごとに分割する。
    return $this->error_arr;
    
  }
 
  private function checkMust($str, $name, $errMess){
    if($str === "" || is_null($str)) throw new \Exception($name."_".$errMess);
  }
  
  private function checkMail($str){
    $mailaddress_array = explode('@',$str);
    if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) === 2){
      return true;
    }
    else{
      return false;
    }
  }

  private function checkDc($str) {
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

  private function h($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }



  /*
  *ファイルの状態チェック
  *$return:
  *0:読み込みok、書き込みok
  *1:読み込みok、書き込みng
  *2:読み込みng
  */
  private function checkFile($filename) {
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

  private function WriteLog($logMsg, $To = "") {
    error_log($logMsg); //errorlog
    if($To !== "") error_log($logMsg, 1, $To); //mail
  }

  private function RetryLimitCheck($cnt, $maxcnt) {
    if($cnt === $maxcnt) {
      return false;
    }
    return true;
  }
  
}
