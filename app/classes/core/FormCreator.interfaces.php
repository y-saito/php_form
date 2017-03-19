<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 5:53
 */
 
namespace phpForm\Core {

  /**
   * フォーム設定オブジェクト用
   * Interface Configure_Interface
   * @package phpForm\Core
   */
  interface Configure_Interface
  {

    public function getControllerConf();

    public function doHookProc($hookpoint = "", $data = []);

  }

}


namespace phpForm\Core\Functions {

  /**
   * レンダリングエンジンオブジェクト用
   * Interface Render_Interface
   * @package phpForm\Core
   */
  interface Render_Interface
  {

    public function assign($key = "", $value = []);

    public function fetch($template="");
  
    public function render($template = "");

  }

  /**
   * メール送信オブジェクト用
   * Interface Mailer_interface
   * @package phpForm\Core
   */
  interface Mailer_interface
  {
    public function sendMail($form_arr = []);
  }
}
 