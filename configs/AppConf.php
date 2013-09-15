<?php
/*
useApp : つくるフォームのディレクトリ名
siteUrl : リダイレクト用
defaultAction : 入力画面のテンプレートファイル名(.tplは省きます。
*/
	$AppConf = array(
		"useApp" => array(
			//"reply",
			"noreply",
			//"message",
		),
		"siteUrl" => "http://hoge.local/",
		"defaultAction" => "entry",
		"maxWriteRetry" => 5, //ファイル読み書き込みのリトライ回数
		"writeWait"     => 3000000, //ファイル読み書き込みのリトライ回数後の待ち時間(マイクロ秒)
	);
