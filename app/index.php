<?php

/**
 * get base conf
 */
$phpFormConf_arr = [];
require_once "configs/PhpForm.conf.php";
$controllerName_str = $phpFormConf_arr['controller'];
$actionName_str = $phpFormConf_arr['action'];

/**
 * route check
 */
// コントローラーがなければアプリケーショントップへ遷移
$controllerConfFileName_str = "configs/{$controllerName_str}.conf.php";
if(!is_file($controllerConfFileName_str) || !is_readable($controllerConfFileName_str)){
  sessionClear();
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/top.html");
}

// submitなしでデフォルトページ以外へのアクセスを禁止。token方式におきかえてバックスペース対策もしたい。
if($actionName_str !== $phpFormConf_arr['defaultAction'] && !isset($_POST['submit'])) {
  sessionClear();
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/{$controllerName_str}/{$phpFormConf_arr['defaultAction']}/");
}

/**
 * manage session
 */
// sessoin start
sessionStart($controllerName_str);
//入力値をsessionに格納
if(!isset($_SESSION['_request'])) $_SESSION['_request'] = []; 
if(isset($_POST)) {
  foreach($_POST as $key => $value) {
    $_SESSION['_request'][$key] = $value;
  }
}

/**
 * get interfaces
 */
require_once "classes/core/FormCreator.interfaces.php";

/**
 * get appliation conf obj
 */
require_once "$controllerConfFileName_str";
$conf_obj = new $controllerName_str($phpFormConf_arr);
var_dump($conf_obj->getControllerConf());

/**
 * get libs obj
 */
require_once "libs/vendor/autoload.php";
$renderEngine_obj = new $phpFormConf_arr["renderEngine"]();
// TODO:twigとかも使えるようにしたい

/**
 * get functions obj
 */
require_once "classes/vendor/autoload.php";
$inputValueController_obj = new phpForm\Core\Functions\InputValueController($_SESSION["_request"]);
$mailer_obj = new phpForm\Core\Functions\Mailer();
$renderClassName = 'phpForm\Core\Functions\Render' . $phpFormConf_arr["renderEngine"];
$render_obj = new $renderClassName($renderEngine_obj, $phpFormConf_arr["renderConf"]);

/**
 * do form create
 */
$formCreator_obj = new phpForm\Core\FormCreator(
                                                  $conf_obj,
                                                  $inputValueController_obj,
                                                  $render_obj,
                                                  $mailer_obj
                                                );

//// 入力値処理。バリデートもしたい
//// 出力
//// メール送信
//// 集計
/**
 * input after process values to session
 */
if($formCreator_obj->formCreate() === true){
  $_SESSION['_request'] = $formCreator_obj->getInputValue();
  if($actionName_str === "thanks") sessionClear();
}else{
  sessionClear();
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/top.html");
}


//-- utities
/**
 * @param $controller_str
 */
function sessionStart($controller_str){
  session_start();
  var_dump($_SESSION);
  /* Incorrect access check */
  if(isset($_SESSION['controller']) && $_SESSION['controller'] !== $controller_str) {
    $_SESSION = array();
    sessionClear();
    session_start();
    $_SESSION['controller'] = $controller_str;
  }
}

function sessionClear() {
  // セッション変数を全て解除する
  $_SESSION = array();
  
  // セッションを切断するにはセッションクッキーも削除する。
  // Note: セッション情報だけでなくセッションを破壊する。
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  // 最終的に、セッションを破壊する
  session_destroy();
}

function goHome($url) {
  header("Location: {$url}");
  exit;
}
