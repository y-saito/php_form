<?php
/**
 * Created by PhpStorm.
 * User: yu-saito
 * Date: 2017/01/09
 * Time: 14:05
 */

namespace phpForm\Core\Functions;


class Mailer implements Mailer_interface
{
  /**
   * @var object render-engine
   */
  private $render_obj;
  /**
   * @var array メール設定パラメータ
   */
  private $mailConf_arr = [
    'sendFlag_bool' => false,
    'template_str' => '',
    'address_arr' => [
      'to_str' => '',
      'errTo_str' => '',
      'bcc_str' => '',
      'from_str' => '',
      'fromAddress_str' => '',
      'replyTo_str' => '',
    ],
    'subject_arr' => [
      'subject_str' => '',
      'addNumFlag_bool' => false,
      'addNumFormat_str' => 'No.%1$03d',
    ],
    'addSenderInfoFlag_bool' => false,
  ];
  /**
   * @var string 送信者情報
   *
   * ex:
   * spritf($this->addSenderInfoBody_str, date('Y/m/d (D) H:i:s', time()), $_SERVER['REMOTE_ADDR'],gethostbyaddr(getenv('REMOTE_ADDR')));
   *
   */
  private $addSenderInfoBody_str = "
    \n\n\n
    +++++送信者情報+++++
    送信された日時：%s
    送信者のIPアドレス：%s
    送信者のホスト名：%s
  ";
  /**
   * @var mixed|string カウントファイル格納ディレクトリ
   */
  private $cntFileDir_str = "/tmp";

  /**
   * Mailer constructor.
   * @param array $mailConf
   */
  public function __construct($mailConf = [], Render_Interface $render_obj)
  {
    // render object
    $this->render_obj = $render_obj;
    // mailConf
    $this->mailConf_arr = [
      'sendFlag_bool' => $mailConf['sendFlag'],
      'template_str' => $mailConf['mailTemplate'],
      'address_arr' => [
        'to_str' => $mailConf['to'],
        'errTo_str' => $mailConf['errto'],
        'bcc_str' => $mailConf['bcc'],
        'from_str' => $mailConf['fromName'],
        'fromAddress_str' => $mailConf['from'],
        'replyTo_str' => $mailConf['replyto'],
      ],
      'subject_arr' => [
        'subject_str' => $mailConf['subject'],
        'addNumFlag_bool' => $mailConf['addNum'],
        'addNumFormat_str' => $mailConf['addNumF'],
      ],
      'addSenderInfoFlag_bool' => $mailConf['addSenderInfoFlag']
    ];
  }
  /**
   * メール送信
   *
   * @param array $form_arr メールフォームの入力値
   * @return bool
   */
  ////public function sendMail($to, $from, $fromname, $bcc = '', $replyto, $subject, $body, $addSnderInfo = false)
  public function sendMail($form_arr=[], $dirName='')
  {

    // メール送信フラグが立ってなければ処理しないで成功ステータスを返す
    if($this->mailConf_arr['sendFlag_bool'] !== true) return true;

    $default_internal_encode = mb_internal_encoding();
    if ($default_internal_encode != 'utf-8') {
      mb_internal_encoding('utf-8');
    }

    // メールヘッダ設定
    // return-path
    $header = 'Return-Path: ' . $this->mailConf_arr['address_arr']['errTo_str'] . "\n";
    // from
    $header .= 'From: ' . mb_encode_mimeheader($this->mailConf_arr['address_arr']['from_str']) . ' <' . $this->mailConf_arr['address_arr']['from_str'] . ">\n";
    // bcc
    if ($this->mailConf_arr['address_arr']['bcc_str'] !== '') {
      $header .= 'Bcc: '.$this->mailConf_arr['address_arr']['bcc_str']."\n";
    }
    // reply-to
    $header .= 'Reply-To: ' . $this->mailConf_arr['address_arr']['replyTo_str'] . "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/" . phpversion();

    // bodyはレンダリングエンジンとテンプレートで
    foreach ($form_arr as $name => $value) {
      $this->render_obj->assign($name, $value);
    }
    $body = $this->render_obj->fetch($dirName.'/'.$this->mailConf_arr['template_str']);
    // senderflag判定して送信者情報追加
    if($this->mailConf_arr['addSenderInfoFlag_bool'] === true) {
      $body .= sprintf($this->addSenderInfoBody_str, date('Y/m/d (D) H:i:s', time()), $_SERVER['REMOTE_ADDR'], gethostbyaddr(getenv('REMOTE_ADDR')));
    }
    $body = mb_convert_encoding($body,'JIS','utf-8');

    $subject = $this->mailConf_arr['subject_arr']['subject_str'];
    // addNumFlag判定をして件名にカウント情報追加
    if($this->mailConf_arr['subject_arr']['addNumFlag_bool'] === true){
      // TODO counterをファイルから取得
      $counter = 0;
      $subject .= "[{sprintf($this->mailConf_arr['subject_arr']['addNumFormat_str'],$counter)}]" . $subject;
    }
    $subject = '=?iso-2022-jp?B?'.base64_encode(mb_convert_encoding($subject,'JIS','utf-8')).'?=';

    return mb_send_mail($this->mailConf_arr['address_arr']['to_str'], $subject, $body, $header);

  }
}