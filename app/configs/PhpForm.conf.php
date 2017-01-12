<?php
/*
useApp : つくるフォームのディレクトリ名
siteUrl : リダイレクト用
defaultAction : 入力画面のテンプレートファイル名(.tplは省きます。
*/
  $phpFormConf_arr = array(
    "siteUrl" => "http://php-form.local/",
    "baseDirName" => "php_form",
    "renderEngine" => "Smarty", //今はこれだけ
    //Smarty パラメータ
    "renderConf" => [
      "force_compile" => false,
      "debugging" => false,
      "caching" => false,
      "cache_lifetime" => 0,
      //テンプレートにjs,cssが書けるように
      "left_delimiter" => '<%',
      "right_delimiter" => '%>',
    ],
    "defaultAction" => "entry",
    "maxWriteRetry" => 5, //ファイル読み書き込みのリトライ回数
    "writeWait"     => 3000000, //ファイル読み書き込みのリトライ回数後の待ち時間(マイクロ秒)
  );
//make routing from uri
$phpFormConf_arr['scriptnameInfo'] = pathinfo($_SERVER['SCRIPT_NAME']);
$appInfoTmp = str_replace($phpFormConf_arr['scriptnameInfo'], '', $_SERVER['REQUEST_URI']);
$appInfoTmp = explode('/', $appInfoTmp);
$phpFormConf_arr['controller'] = $appInfoTmp[1];
$phpFormConf_arr['action']  = (isset($appInfoTmp[2]) ? $appInfoTmp[2] : $phpFormConf_arr["defaultAction"]);
$phpFormConf_arr['submit']  = (isset($_POST["submit"]) ? $_POST["submit"] : $phpFormConf_arr["defaultAction"]);

/*
 * 文言設定
 */
// optionのoutput=>value
$Messages_arr['pref_optionlist'] = array(
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
);

// optionのoutput=>value
$Messages_arr['title_optionlist'] = array(
//  "選択してください" => "",
  "output" => "value",
);

$Messages_arr['errMess'] = array(
  "must" => "入力必須項目です。",
  "mail" => "正しいメールアドレスを入力してください。",
  "dc" => "機種依存文字が含まれていました。",
);

$Messages_arr['warnMess'] = array(
  "dc" => "機種依存文字が含まれていました。",
);


$phpFormConf_arr['messages'] = $Messages_arr;
