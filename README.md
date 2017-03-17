Simple PHP Form3
========

Simple PHP Form3 はPHPでWEBアプリケーションをつくる技術を学ぶための、シンプルな投稿型WEBフォームです。

ディレクトリごとに異なる設定、HTMLファイルを置いて、1アプリケーションで複数のWEBフォームを動作させることが可能です。

対象
----
- wordpressのセットアップをしたことがあればとりあえず使えると思います。
- 画面表示のカスタマイズにはSmartyの知識が必要です。


導入
----

dockerの定義ファイルとセットになっているため、dockerがインストールされているマシンであれば、以下のコマンドを順番に実行するだけですぐに動作させることが可能です。

	cd [YOUR WORK SPACE]
	git clone https://github.com/y-saito/php_form.git
	cd php_form/app/
	cd libs/
	./composer.phar install
	cd ../classes/
	./composer.phar install
	cd ../../
	docker build --no-cache -t php_form .
	docker run -i -t -v $(pwd):/tmp/share -p 50080:80 --name php_form_container php_form /bin/bash

ブラウザで **http://localhost:50080/php_form/noreply/** にアクセスしてみてください。

WEBフォームを追加する
---
では、次に別のフォームを追加してみましょう。
これも以下の操作で簡単にできます。(導入の最後の操作のあと、dockerコンテナにログインしている状態で始める想定です。）


	cd /var/www/html/php_form/configs/
	cp noreply.conf.php alt.conf.php
	cd ../templates/
	cp -pr noreply/ alt

これだけです！ **http://localhost:50080/php_form/alt/** にアクセスできますよね？

あとは **/var/www/html/php_form/configs/alt.conf.php** の設定値や、**/var/www/html/php_form/templates/alt/** 以下のテンプレートを変更するだけで新しいWEBフォームを追加することができます！簡単でしょう？



開発している環境
----
- macOS 10.12.2
- Docker version 1.13.0-rc4, build 88862e7

次やること
----

- もともとできていたことを復活させてリファクタリングを完了させる
	- エラーチェック
	- メール処理
	- ファイルカウントアップ
- DockerにDB追加
- フロントを楽しい感じにしたい
- フォームの設定ファイルを使いやすくしたい。yaml形式とかの方がいい？
- フォームの設定ファイルやテンプレートに関するドキュメントを充実させたい。

ライセンス
----
MIT
