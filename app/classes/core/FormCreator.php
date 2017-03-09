<?php

namespace phpForm\Core;

/**
 * Create Form Controller.
 * 
 * Controller class that display, input value control, postprocessing.
 * 
 */

class FormCreator
{
  private $conf_obj;
  private $inputValueController_obj;
  private $render_obj;
  private $adminMailer_obj;
  private $confirmMailer_obj;
  /**
   * @var $controllerSetting_arr array "Application and Controller Settings."
   */
  private $controllerSetting_arr;
  
 /**
   * FormCreator constructor.
   * 
   * Dependency Injection.
   * 
   * @param Configure_Interface $conf_obj
   * @param $inputValueController_obj
   * @param Render_Interface $render_obj
   * @param $mailer_obj
   */
  public function __construct(
    Configure_Interface $conf_obj,
    $inputValueController_obj,
    Functions\Render_Interface $render_obj,
    Functions\Mailer_interface $adminMailer_obj,
    Functions\Mailer_interface $confirmMailer_obj
  ){
    $this->conf_obj = $conf_obj;
    $this->inputValueController_obj = $inputValueController_obj;
    $this->render_obj = $render_obj;
    $this->adminMailer_obj = $adminMailer_obj;
    $this->confirmMailer_obj = $confirmMailer_obj;

    $this->controllerSetting_arr = $conf_obj->getControllerConf();
  }
  
   /**
   * @return array
   */
  public function getControllerSettingArr()
  {
    return $this->controllerSetting_arr;
  }
  
  /**
   * 
   * make template name from controller setting
   * 
   * @return string "template file name."
   */
  private function makeTemplateName(){
    // config & init
    $dirName = $this->controllerSetting_arr["appConf"]["controller"];
    $fileName = ($this->controllerSetting_arr["appConf"]["action"] !== "" ? 
                  $this->controllerSetting_arr["appConf"]["action"] : $this->controllerSetting_arr["appConf"]["defaultAction"]);
    
    return "{$dirName}/{$fileName}.tpl";
  }
  
  // input controlle
  /**
   * 
   * main process of form creation.
   * 
   * @return bool
   */ 
  public function formCreate(){
  
    // process
    $methodName = "process".ucfirst($this->controllerSetting_arr["appConf"]["action"]);
    if($this->$methodName() === true) {
  
      // rendering
      $this->render_obj->assign("appConf", $this->controllerSetting_arr["appConf"]);
      $this->render_obj->assign("controllerConf", $this->controllerSetting_arr["renderSetting"]);
      $this->render_obj->assign("inputValue", $this->inputValueController_obj->getInputValueArr());
      $this->render_obj->assign("errorArr", $this->inputValueController_obj->getErrorArr());
      if ($this->render_obj->render($this->makeTemplateName()) === false) return false;
  
      //$this->render_obj->render("debug.tpl");
      //echo "Hello world!";
      return true;
    }else{
      return false;
    }
  }

  /**
   * @return bool 入力画面を表示するときの処理
   */
  private function processEntry()
  {
    return true;
  }

  /**
   * @return bool 確認画面を表示するときの処理
   */
  private function processConfirm()
  {
    // errorcheck
    // もしエラーがあったら前の画面に戻る
    $renderError_arr = $this->inputValueController_obj->validate($this->controllerSetting_arr["inputCheck"], $this->controllerSetting_arr["appConf"]["messages"]);
    if(count($renderError_arr) > 0) {
      $this->controllerSetting_arr["appConf"]["action"] = "entry";
      return false;
    }
    return true;
  }

  /**
   * @return bool 完了画面を表示するときの処理
   */
  private function processThanks()
  {
    /*
     * ファイル描き込み
     */

      /*
       * メール送信
       */
      $this->adminMailer_obj->sendMail($this->inputValueController_obj->getInputValueArr());
      $this->confirmMailer_obj->sendMail($this->inputValueController_obj->getInputValueArr());

      return true;
  }

  /**
   * form入力値取得
   * @return mixed
   */
  public function getInputValue()
  {
    return $this->inputValueController_obj->getInputValueArr();
  }
}