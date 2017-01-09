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
  /**
   * @var $conf_obj object 
   * @var $inputValueController_obj object
   * @var $render_obj object
   * @var $mailer_obj object
   * @var $controllerSetting_arr array "Application and Controller Settings."
   */
  private $conf_obj;
  private $inputValueController_obj;
  private $render_obj;
  private $mailer_obj;
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
   * @return void
   */ 
  public function formCreate(){
    // rendering
    $this->render_obj->render($this->makeTemplateName());
    //$this->render_obj->render("debug.tpl");
    //echo "Hello world!";
  }
}