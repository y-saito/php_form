Simple PHP Form3
========

Simple PHP Form3 はPHPでWEBアプリケーションをつくる技術を学ぶための、シンプルな投稿型WEBフォームです。

ディレクトリごとに異なる設定、HTMLファイルを置いて、1アプリケーションで複数のWEBフォームを動作させることが可能です。

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
	
動作環境
----
- macOS 10.12.2
- Docker version 1.13.0-rc4, build 88862e7

次やること
----

- もともとできていたことを復活させてリファクタリング完了させる
	- エラーチェック
	- メール処理
	- ファイルカウントアップ
- DockerにDB追加
- フロントを楽しい感じにしたい

ライセンス
----
MIT
