<?php

// Init
require_once "classes/core/FormCreator.interfaces.php";

// get initial conf
$phpFormConf_arr = [];
require_once "configs/PhpForm.conf.php";
$controllerName_str = $phpFormConf_arr['controller'];

// get controller obj
require_once "configs/{$controllerName_str}.conf.php";
$controller_obj = new $controllerName_str($phpFormConf_arr);
var_dump($controller_obj->getControllerConf());

// get render obj
require_once "libs/vendor/autoload.php";
$render_obj = new Smarty();

// get function obj
require_once "classes/vendor/autoload.php";
$inputValueController_obj = new phpForm\Core\Functions\InputValueController();
$mailer_obj = new phpForm\Core\Functions\Mailer();

$formCreator_obj = new phpForm\Core\FormCreator($controller_obj,$inputValueController_obj,$render_obj,$mailer_obj);
$formCreator_obj->formCreate();


//// 入力値をsessionに格納




//// 入力値処理。バリデートもしたい


//// 出力


//// 集計


//// メール送信



