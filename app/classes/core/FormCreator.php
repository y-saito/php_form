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
  private $mailer_obj;
  /**
   * @var $controllerSetting_arr array "Application and Controller Settings."
   */
  private $controllerSetting_arr;
  /**
   * @var bool 完了時に投稿者にメールを送る判定フラグ
   * true -> send / false -> no send
   */
  private $sendMailFlag_bool = false;
  /**
   * @var bool 完了時に管理者にメールを送る判定フラグ
   * true -> send / false -> no send
   */
  private $sendReMailFlag_bool = false;
  
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
    Render_Interface $render_obj,
    $mailer_obj
  ){
    $this->conf_obj = $conf_obj;
    $this->inputValueController_obj = $inputValueController_obj;
    $this->render_obj = $render_obj;
    $this->mailer_obj = $mailer_obj;
  
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
   * make template name from controller settingl
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
      if($this->sendMailFlag_bool) {
        //$mailBody = $this->render_obj->fetch($this->makeTemplateName($this->conf_obj->getControllerConf()["adminmailTemp"]));
        //$this->mailer_obj->sendMail($mailBody, //メール送信に必要な引数);
      }
      if($this->sendReMailFlag_bool) {
        //$mailBody = $this->render_obj->fetch($this->makeTemplateName($this->conf_obj->getControllerConf()["adminmailTemp"]));
        //$this->mailer_obj->sendMail($mailBody, //メール送信に必要な引数);
      }
      if ($this->render_obj->render($this->makeTemplateName()) === false) return false;
  
      //$this->render_obj->render("debug.tpl");
      //echo "Hello world!";
      return true;
    }else{
      return false;
    }
  }
  
  private function processEntry()
  {
    return true;
  }
  
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
  
  private function processThanks()
  {
    // sendmail
    if($this->conf_obj->getControllerConf()["adminmail"] === 1){
      $this->sendMailFlag_bool = true;
    }
    if($this->conf_obj->getControllerConf()["remail"] === 1){
      $this->sendReMailFlag_bool = true;
    }
    /*
    if($adminmail === 1) {
      $body = $smarty->fetch("{$dir}/{$adminmailTemp}");
      if($addNum === 0 &&  $flagWriteError) $subject = "{$num} {$subject}";
      if($addNum === 0 && !$flagWriteError) $subject = sprintf($addNumF, $num) . "{$subject}";
      sendMail($to, $from, $fromname, $bcc, $replyto, $subject, $body, $addAdminSnderInfo);
    }
    if($remail === 1) {
      $rebody = $smarty->fetch("{$dir}/{$remailTemp}");
      if($addReNum === 0 &&  $flagWriteError) $subject = "{$num} {$subject}";
      if($addReNum === 0 && !$flagWriteError) $subject = sprintf($addReNumF, $num) . "{$subject}";
      if(isset($_SESSION['email']) && $_SESSION['email'] != "") sendMail($_SESSION['email'], $from, $fromname, $bcc, $replyto, $resubject, $rebody, $addRemailSnderInfo);
    }
    */
    
    // write counterfile
    
    return true;
  }
  
  public function getInputValue()
  {
    return $this->inputValueController_obj->getInputValueArr();
  }
  
  public function getValidateErrorArray(){
    return $this->inputValueController_obj->getErrorArr();
  }
}