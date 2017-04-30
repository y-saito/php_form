<?php

require_once "classes/core/FormCreator.interfaces.php";

/**
 * get base conf
 */
$phpFormConf_arr = [];
require_once "configs/PhpForm.conf.php";
$controllerName_str = $phpFormConf_arr['controller'];
$controllerConfFileName_str = "configs/{$controllerName_str}.conf.php";
$actionName_str = $phpFormConf_arr['action'];
// 進行キーがPOSTで渡されたら画面遷移判定を実施して指定の画面に進むことになる
$processRouteKey = isset($_POST['process']) ? (int)$_POST['process'] : null;

// 指定されたコントローラーの設定ファイルがなければアプリケーショントップへ遷移
if(!is_file($controllerConfFileName_str) || !is_readable($controllerConfFileName_str))
{
  sessionClear();
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/top.html");
}


/**
 * get application conf obj
 */
require_once "$controllerConfFileName_str";
$conf_obj = new formController($phpFormConf_arr);

/**
 * manage session
 */
// sessoin start
sessionStart($controllerName_str);
if(isset($_POST['form']) && (!isset($_SESSION['_request']) || $_SESSION['_request'] !== ''))
{
  $_SESSION['_request'] = $_POST['form'];
}
elseif(!isset($_SESSION['_request']))
{
  $_SESSION['_request'] = [];
}

try {
  // submitなしでデフォルトページ以外へのアクセスを禁止。token方式におきかえてバックスペース対策もしたい。
  if ($actionName_str !== $conf_obj->getControllerConf()['actionRouting'][0] && !isset($_SESSION['_process'])) throw new \Exception();
  // routing設定されていないアクションを指定されたらやり直し
  if(!in_array($actionName_str, $conf_obj->getControllerConf()['actionRouting'])) throw new \Exception();
}catch (\Exception $e){
  sessionClear();
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/{$controllerName_str}/{$conf_obj->getControllerConf()['actionRouting'][0]}/");
}

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

$inputValueController_obj = new phpForm\Core\Functions\InputValueController($_SESSION["_request"],$conf_obj->getControllerConf()["validation"]);

$renderClassName = 'phpForm\Core\Functions\Render' . $phpFormConf_arr["renderEngine"];
$render_obj = new $renderClassName($renderEngine_obj, $phpFormConf_arr["renderConf"]);

$adminMailer_obj = new phpForm\Core\Functions\Mailer($conf_obj->getControllerConf()["mail"]["admin"], $render_obj);
$confirmMailer_obj = new phpForm\Core\Functions\Mailer($conf_obj->getControllerConf()["mail"]["confirm"], $render_obj);

/**
 * do form create
 */
$formCreator_obj = new phpForm\Core\FormCreator(
  $conf_obj,
  $inputValueController_obj,
  $render_obj,
  $adminMailer_obj,
  $confirmMailer_obj,
  $processRouteKey
);

/**
 * routing
 */
if(!is_null($processRouteKey))
{
  $methodName = "process" . ucfirst($actionName_str);
  if(method_exists($formCreator_obj, $methodName)) $processRouteKey = $formCreator_obj->$methodName();
}else{
  $processRouteKey = 0;
}

// input after process values to session
$_SESSION['_request'] = $formCreator_obj->getInputValue();
$_SESSION['_process'] = $processRouteKey;

if($processRouteKey === 0)
{
  // render
  $result = $formCreator_obj->formCreate();
  echo $result;
}else{
  $currentRoutingKey = array_search($actionName_str, $conf_obj->getControllerConf()['actionRouting']);
  $nextRoutingKey = $currentRoutingKey + $processRouteKey;
  goHome("{$phpFormConf_arr['scriptnameInfo']['dirname']}/{$controllerName_str}/{$conf_obj->getControllerConf()['actionRouting'][$nextRoutingKey]}/");
}

/**
 * finally process
 */
// この処理はprocessThanksに入れるべき。
if($actionName_str === "thanks") sessionClear();


//-- utities
/**
 * @param $controller_str
 */
function sessionStart($controller_str){
  session_start();
  /* Incorrect access check */
  if(isset($_SESSION['controller']) && $_SESSION['controller'] !== $controller_str)
  {
    $_SESSION = [];
    sessionClear();
    session_start();
    $_SESSION['controller'] = $controller_str;
  }
}

function sessionClear() {
  // セッション変数を全て解除する
  $_SESSION = [];
  
  // セッションを切断するにはセッションクッキーも削除する。
  // Note: セッション情報だけでなくセッションを破壊する。
  if (ini_get("session.use_cookies"))
  {
    $params = session_get_cookie_params();
    setcookie(
      session_name(), '', time() - 42000,
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
