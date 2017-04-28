<?php
/**
 * Created by PhpStorm.
 * Date: 2017/01/07
 * Time: 16:31
 */

class formController implements \phpForm\Core\Configure_Interface
{
  private $controllerConf_arr = [

    //Smarty 表示用パラメータ //asaing変数名 => assignする内容
    "renderSetting" => [
      "pageTitle" => "title", // ページタイトルタグ
      "pageDescription" => "description", // ページディスクリプションタグ
      "titleArray" => ["Engineer","Sales","Support","Manager"],
      "titleValueArray" => [0,1,2,3],
    ],
    "mail" => [

      "admin" => [

        // 管理者に送信内容確認メール（自動返信メール）を送る(送る=true, 送らない=false)
        "sendFlag" => true,

        /* 送信設定 */
        // 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください)
        "to"    => "root@php-form.local",
        "errto" => "root@php-form.local", //エラー報告用
        // Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください)
        "bcc" => "",
        //自動返信メールの送信者欄に表示される名前とメールアドレス　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
        "fromName" => "no-reply@php-form.local",
        "from" => "no-reply@php-form.local",
        //replytoメールアドレス
        "replyto" => "no-reply@php-form.local",

        /* 件名 */
        // 管理者宛に送信されるメールのタイトル（件名）
        "subject" => "[管理者用]お問い合わせ（返信不要）",
        "addNum" => false, //件名に連番を (送る=true, 送らない=false)
        "addNumF" => "No.%1$03d ", //件名の頭につく書式。sprintfのフォーマットで指定。%1に数字が入る。

        //使用する本文用テンプレート名
        "mailTemplate" => "adminmail.tpl",

        // メールに送信情報を追記するか？ true=はい false=いいえ
        "addSenderInfoFlag" => true,
      ],

      "confirm" =>[

         // 管理者に送信内容確認メール（自動返信メール）を送る(送る=true, 送らない=false)
        "sendFlag" => true,

        /* 送信設定 */
        // 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください)
        "to"    => "root@php-form.local",
        "errto" => "root@php-form.local", //エラー報告用
        // Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください)
        "bcc" => "",
        //自動返信メールの送信者欄に表示される名前とメールアドレス　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
        "fromName" => "no-reply@php-form.local",
        "from" => "no-reply@php-form.local",
        //replytoメールアドレス
        "replyto" => "no-reply@php-form.local",

        /* 件名 */
        // 管理者宛に送信されるメールのタイトル（件名）
        "subject" => "お問い合わせ（返信不要）",
        "addNum" => false, //件名に連番を (送る=true, 送らない=false)
        "addNumF" => "No.%1$03d ", //件名の頭につく書式。sprintfのフォーマットで指定。%1に数字が入る。

        //使用する本文用テンプレート名
        "mailTemplate" => "remail.tpl",

        // メールに送信情報を追記するか？ true=はい false=いいえ
        "addSenderInfoFlag" => true,
      ],
    ],
    "validation" => [
      "inputCheck" => [
          /* 入力項目設定(入力フォームで指定したnameキーに対する、設定パラメータ値を設定
          must : 必須
          mail : メール形式チェック
          dc : 機種依存文字（machine dependent characters）チェック
          */
        //name => type_type...
        'title' => 'must',
        'comment' => 'must_dc',
        'mail' => 'must_mail_dc',
      ],
      // inputCheckに対するメッセージ設定
      "messages" => [
        // 必須項目に対応するメッセージ
        'errMess' => [
          "must" => "入力必須項目です。",
          "mail" => "正しいメールアドレスを入力してください。",
          "dc" => "機種依存文字が含まれていました。",
          "system" => "エラーが発生しました、本サービス提供元にお問い合わせください。"
        ],
        // 渓谷項目に対応するメッセージ
        'warnMess' => [
          "dc" => "機種依存文字が含まれていました。",
        ],
      ]
    ],
    // selectフォームのoptionリスト
    'option_lists' => [
       // optionのoutput=>value
      'pref_optionlist' => [
        "選択してください" => "",
        "北海道" => "北海道",
        "青森県" => "青森県",
        "岩手県" => "岩手県",
        "宮城県" => "宮城県",
        "秋田県" => "秋田県",
        "山形県" => "山形県",
        "福島県" => "福島県",
        "茨城県" => "茨城県",
        "栃木県" => "栃木県",
        "群馬県" => "群馬県",
        "埼玉県" => "埼玉県",
        "千葉県" => "千葉県",
        "東京都" => "東京都",
        "神奈川県" => "神奈川県",
        "新潟県" => "新潟県",
        "富山県" => "富山県",
        "石川県" => "石川県",
        "福井県" => "福井県",
        "山梨県" => "山梨県",
        "長野県" => "長野県",
        "岐阜県" => "岐阜県",
        "静岡県" => "静岡県",
        "愛知県" => "愛知県",
        "三重県" => "三重県",
        "滋賀県" => "滋賀県",
        "京都府" => "京都府",
        "大阪府" => "大阪府",
        "兵庫県" => "兵庫県",
        "奈良県" => "奈良県",
        "和歌山県" => "和歌山県",
        "鳥取県" => "鳥取県",
        "島根県" => "島根県",
        "岡山県" => "岡山県",
        "広島県" => "広島県",
        "山口県" => "山口県",
        "徳島県" => "徳島県",
        "香川県" => "香川県",
        "愛媛県" => "愛媛県",
        "高知県" => "高知県",
        "福岡県" => "福岡県",
        "佐賀県" => "佐賀県",
        "長崎県" => "長崎県",
        "熊本県" => "熊本県",
        "大分県" => "大分県",
        "宮崎県" => "宮崎県",
        "鹿児島県" => "鹿児島県",
        "沖縄県" => "沖縄県",
        "その他" => "その他",
      ],
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
  public function doHookProc($hookpoint="", $data=[]) {
  
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