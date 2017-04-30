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

  const d = '_###_';

  
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
  
  /**
   * @param array $validation_arr
   * @return array
   * @throws \Exception
   */
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
        $e = null;
        if(!isset($this->inputValue_arr[$name]) || is_null($this->inputValue_arr[$name])) throw new \Exception($validation_arr["messages"]["errMess"]["system"]);
        $item = $this->inputValue_arr[$name];
        $validateType_arr = explode("_", $validatePattern);
        // 設定されたヴァリデーションパターンを順番にチェック
        foreach ($validateType_arr as $validateType_str) {
          switch ($validateType_str) {
            case "must":
              if($this->checkMust($item) === false){
                $e = new \Exception($name. self::d . $validation_arr["messages"]["errMess"]["must"], 0, $e);
              }
              break;
            case "mail":
              if($this->checkMail($item) === false) {
                $e = new \Exception($name . self::d . $validation_arr["messages"]["errMess"]["mail"], 0, $e);
              }
              break;
            case "dc":
              if($this->checkDc($item) === false) {
                $e = new \Exception($name . self::d . $validation_arr["messages"]["errMess"]["dc"], 0, $e);
              }
              break;
            default:
              break;
          }
        }
        if($e) throw $e;
      }catch(\Exception $e){
        do {
          $catchMess_arr = explode(self::d, $e->getMessage());
          $this->error_arr[$catchMess_arr[0]] = $catchMess_arr[1];
        } while ($e = $e->getPrevious());
      }
    }
    return;
  }

  /**
   * @param $str
   * @return bool
   */
  private function checkMust($str){
    if($str === "" || is_null($str)) return false;
  }

  /**
   * @param $str
   * @return bool
   */
  private function checkMail($str){
    return filter_var($str, FILTER_VALIDATE_EMAIL);
  }

  /**
   * @param $str
   * @return bool
   */
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
