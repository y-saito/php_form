<?php
/**
 * Created by PhpStorm.
 * Date: 2017/01/07
 * Time: 16:31
 */

class noreply implements \phpForm\Core\Controller_Interface
{
  private $controllerConf_arr = [

    //Smarty パラメータ
    "smarty" => [
      "debug" => false,
      "caching" => false,
      "cacheLifeTime" => 0,
      "pageTitle" => "title", // ページタイトルタグ
      "pageDescription" => "description" // ページディスクリプションタグ
    ],
    "mail" => [ 
      // 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください)
      "to"    => "info@hoge.local",
      "errto" => "error@hoge.local", //エラー報告用

      // Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください)
      "bcc" => "",

      // 管理者に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
      "adminmail" => 1,
      "addAdminSnderInfo" => true, //メールに送信者情報をつけるか？
      "adminmailTemp" => "adminmail.tpl", //使用するテンプレート名

      // 管理者宛に送信されるメールのタイトル（件名）
      "subject" => "お問い合わせ（返信不要）",
      "addNum" => 0, //件名に連番を 0:付ける 1:付けない
      "addNumF" => "No.%1$03d ", //件名の頭につく書式。sprintfのフォーマットで指定。%1に数字が入る。
      "cntFileDir" => "./__file/", //カウンターファイルの設置場所。指定したディレクトリ配下の/[appname]/mailcnt.txtが使われます。

      // 差出人に送信内容確認メール（自動返信メール）を送る(送る=>1, 送らない=>0)
      "remail" => 0,
      "addRemailSnderInfo" => false, //メールに送信者情報をつけるか？
      "remailTemp" => "remail.tpl", //使用するテンプレート名

      // 差出人宛に送信されるメールのタイトル（件名）
      "resubject" => "",
      "addReNum" => 0, //件名に連番を 0:付ける 1:付けない
      "addReNumF" => "No.%1$03d ", //件名の頭につく書式。sprintfのフォーマットで指定。%1に数字が入る。

      //自動返信メールの送信者欄に表示される名前とメールアドレス　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
      "fromname" => "info@hoge.local",
      "from" => "info@hoge.local",

      //replytoメールアドレス
      "replyto" => "info@hoge.local",

      // 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
      "re_subject" => ""
    ],
    "inputCheck" => [
      // 入力チェックをする(する=1, しない=0)
      "enable" => 1,
        
        /* 入力項目設定(入力フォームで指定したnameキーに対する、設定パラメータ値を設定
        must : 必須
        h : htmlエスケープ対象（オリジナルはh__[name]キーに格納）
        mail : メール形式チェック
        dc : 機種依存文字（machine dependent characters）チェック（警告のみ）。
        */
      //name => type_type...
      "items" => [
        'title' => 'must_h_dc',
        'comment' => 'must_h_dc',
      ]
    ]
 ];

  public function __construct($phpFormConf_arr)
  {
    $this->controllerConf_arr["appConf"] = $phpFormConf_arr;
  }
  
  public function getControllerConf(){
    return $this->controllerConf_arr;
  }
  
  //hook定義==========
  public function doHookProc($hookpoint, $data=array()) {
    //global $AppConf;
    switch($hookpoint) {
      //Smartyにassignする直前に実行
      case 'before_assign':
        if(key($data) === "name" ) {
          $name = $data['name'];
          if($name === "comment") $_SESSION[$name] = mb_convert_kana($_SESSION[$name], "KV");
        }
        break;
      //Smartyにassignする項目を作成する際に実行
      //case 'add_assign_array':
      //  $AppConf['add_assign_array']['title_output'] = array_keys($AppConf['Lang']['title_optionlist']);
      //  $AppConf['add_assign_array']['title_values'] = array_values($AppConf['Lang']['title_optionlist']);
      //  break;
      default:
        break;
    }
  }

}