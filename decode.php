<?php
$subject="
メールヘッダのsubject:以降の文字列を貼り付けてください。
";

echo mb_decode_mimeheader(mb_decode_mimeheader($subject));


$body="base64化されたメール本文を貼り付けてください。";

echo mb_convert_encoding(base64_decode($body), 'UTF-8', 'JIS');
