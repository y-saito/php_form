<?php

function sendMail($to, $from, $fromname, $bcc="", $replyto, $subject, $body, $addSnderInfo = false) {
	if($addSnderInfo) {
		$body.="\n+++++送信者情報+++++\n";
		$body.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
		$body.="送信者のIPアドレス：".$_SERVER["REMOTE_ADDR"]."\n";
		$body.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	}
		
	$default_internal_encode = mb_internal_encoding();
	if($default_internal_encode != 'utf-8'){
	  mb_internal_encoding('utf-8');
	}
	$header = "From: ".mb_encode_mimeheader($fromname)." <".$from.">\n";
	if($bcc != '') {
		$header .= "Bcc: $bcc\n";
	}
	$header .= "Reply-To: ".$replyto."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		
	//$body=mb_convert_encoding($body,"JIS","utf-8");
	//$subject="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS","utf-8"))."?=";
	  
	mb_send_mail($to,$subject,$body,$header);
}


