<?php
/**
 * アプリケーションで使うクラスメソッドをここで定義する
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
   * @package phpForm\Core\Functions
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
   * @package phpForm\Core\Functions
   */
  interface Mailer_interface
  {
    public function sendMail($form_arr = []);
  }

  /**
   * 入力値コントローラーオブジェクト用
   * Interface InputValueController
   * @package phpForm\Core\Functions
   */
  interface InputValueController_interface
  {
    public function getInputValueArr();

    public function getErrorArr();

    public function validate(
      $inputCheckPattern_arr = [
        'inputCheck' => [],
        'messages' => [
          'errMess' => [],
          'warnMess' => []
        ]
      ]
    );

  }
}
 