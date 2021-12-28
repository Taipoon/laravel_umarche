## udemy Laravel講座

## ダウンロード方法

- git clone コマンドでダウンロード
>git clone https://github.com/Taipoon/laravel_umarche

- ブランチ名を指定してダウンロード
>git clone -b ブランチ名 https://github.com/Taipoon/laravel_umarche

## インストール方法

- $ cd laravel_umarche
- $ composer install
- $ npm install
- $ npm run dev
- .env.example をコピーして .env ファイルを作成
- .env ファイルでご利用の環境に合わせてデータベース設定を変更

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8890
DB_DATABASE=laravel_umarche
DB_USERNAME=umarche
DB_PASSWORD=pa$$w0rd!

XAMPP/MAMPまたは他の開発環境でDBを起動したあとに
- $ php artisan migrate:fresh --seed
と実行してください。(データベーステーブルとダミーデータが追加されれば成功です。)

最後に、アプリケーションごとのユニークなキーを生成します。
- $ php artisan key:generate
と実行します。

そして、開発用簡易サーバを立ち上げ、表示を確認します。
- $ php artisan serve

表示は以下のアドレスをブラウザで開きます。
- http://127.0.0.1:8000

## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg 〜 sample6.jpg として
保存しています。

php artisan storage:link で
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
(productsフォルダがない場合は作成してください。)

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。
