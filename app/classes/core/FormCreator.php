<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 14:05
 */

namespace phpForm\Core;


class FormCreator
{
  private $controller_obj;
  private $inputValueController_obj;
  private $render_obj;
  private $mailer_obj;
  
  public function __construct(
    Controller_Interface $controller_obj,
    $inputValueController_obj,
    $render_obj,
    $mailer_obj
  ){
    $this->controller_obj = $controller_obj;
    $this->inputValueController_obj = $inputValueController_obj;
    $this->render_obj = $render_obj;
    $this->mailer_obj = $mailer_obj;
  }
  
  // config & init
  
  // input controlle
  
  // rendering
  public function formCreate(){
    echo "Hello world!";
  }
}