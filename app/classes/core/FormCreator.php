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

  private $processRouteKey;

  /**
   * FormCreator constructor.
   * @param Configure_Interface $conf_obj
   * @param Functions\InputValueController_interface $inputValueController_obj
   * @param Functions\Render_Interface $render_obj
   * @param Functions\Mailer_interface $adminMailer_obj
   * @param Functions\Mailer_interface $confirmMailer_obj
   */
  public function __construct
  (
    Configure_Interface $conf_obj,
    Functions\InputValueController_interface $inputValueController_obj,
    Functions\Render_Interface $render_obj,
    Functions\Mailer_interface $adminMailer_obj,
    Functions\Mailer_interface $confirmMailer_obj,
    $processRouteKey
  ){
    $this->conf_obj = $conf_obj;
    $this->inputValueController_obj = $inputValueController_obj;
    $this->render_obj = $render_obj;
    $this->adminMailer_obj = $adminMailer_obj;
    $this->confirmMailer_obj = $confirmMailer_obj;

    $this->controllerSetting_arr = $conf_obj->getControllerConf();

    $this->processRouteKey = $processRouteKey;

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
    // rendering
    $this->render_obj->assign("appConf", $this->controllerSetting_arr["appConf"]);
    $this->render_obj->assign("controllerConf", $this->controllerSetting_arr["renderSetting"]);
    $this->render_obj->assign("inputValue", $this->getInputValue());
    $this->render_obj->assign("errorArr", $this->getErrors());
    $this->render_obj->assign("sendUri", $_SERVER['REQUEST_URI']);

    return $this->render_obj->fetch($this->makeTemplateName());

  }

  /**
   * 入力画面から次の画面へ遷移するときの処理
   */
  public function processConfirm()
  {
      $this->inputValueController_obj->validate($this->controllerSetting_arr['validation']);
      return (count($this->getErrors()) > 0) ? 0 : $this->processRouteKey;
  }

  /**
   * 確認画面から次の画面へ遷移するときの処理
   */
  public function processThanks()
  {
    /*
     * TODO:ファイル描き込み
     */

    /*
     * メール送信
     */
    if(!$this->adminMailer_obj->sendMail($this->getInputValue())){
      error_log("App Error:Can't send adminMail");
    }
    if(!$this->confirmMailer_obj->sendMail($this->getInputValue())){
      error_log("App Error:Can't send confirmMail");
    }
    return $this->processRouteKey;
  }

  /**
   * form入力値取得
   * @return mixed
   */
  public function getInputValue() {
    return $this->inputValueController_obj->getInputValueArr();
  }
  public function getErrors() {
    return $this->inputValueController_obj->getErrorArr();
  }
}
