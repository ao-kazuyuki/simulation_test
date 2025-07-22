# coachtechフリマ

## 環境構築
<dl>
    <dt>Dockerビルド</dt>
    <dd>1. git clone git@github.com:ao-kazuyuki/simulation_test.git</dd>
    <dd>2. cd simulation_test</dd>
    <dd>3. docker-compose up -d --build</dd>
</dl>

<dl>
    <dt>Laravel環境構築</dt>
    <dd>1. docker-compose exec php bash</dd>
    <dd>2. composer install</dd>
    <dd>3. exit
    <dd>4. cd src</dd>
    <dd>5. cp .env.example .env</dd>
    <dd>6. .envファイル内の下記の項目を以下のように修正</dd>
    <dd>DB_HOST=mysql</dd>
    <dd>DB_DATABASE=laravel_db</dd>
    <dd>DB_USERNAME=laravel_user</dd>
    <dd>DB_PASSWORD=laravel_pass</dd>
    <dd>7. docker-compose exec php bash</dd>
    <dd>8. php artisan key:generate</dd>
    <dd>9. php artisan migrate:fresh</dd>
    <dd>10. php artisan db:seed</dd>
    <dd>11. php artisan storage:link</dd>
    <dd>※ダミー商品の画像は10個と少量のため、環境構築を簡単にするためにstorageフォルダ内のダミーユーザー、ダミー商品のフォルダを共有しました。</dd>
    <dd>12. http://localhost/ にアクセスして動作確認</dd>
    <dd>※Windows環境などでファイルの権限エラーが発生する場合は適宜パーミッションの変更を行って下さい。</dd>
</dl>

<dl>
    <dt>テスト環境構築</dt>
    <dd>docker-compose exec mysql bash</dd>
    <dd>mysql -u root -p</dd>
    <dd>※パスワードはdocker-compose.ymlの「MYSQL_ROOT_PASSWORD」の項を確認して下さい。</dd>
    <dd>CREATE DATABASE demo_test;</dd>
    <dd>exit</dd>
    <dd>exit</dd>
    <dd>cp .env .env.testing</dd>
    <dd>.env.testingファイル内の下記の項目を以下のように修正</dd>
    <dd>APP_ENV=test</dd>
    <dd>APP_KEY=</dd>
    <dd>DB_DATABASE=demo_test</dd>
    <dd>DB_USERNAME=root</dd>
    <dd>DB_PASSWORD=root</dd>
    <dd>docker-compose exec php bash</dd>
    <dd>php artisan key:generate --env=testing</dd>
    <dd>php artisan config:clear</dd>
    <dd>php artisan migrate --env=testing</dd>
    <dd>exit</dd>
</dl>

<dl>
    <dt>テストファイル構成</dt>
    <dd>テストコードはスプレットシートのシート「テストケース一覧」のIDごとにテストファイルを生成し、tests/Featureフォルダ配下にあります。</dd>
    <dd>ID: 1 会員登録機能　MemberRegistrationTest.php</dd>
    <dd>ID: 2 ログイン機能　MemberRoginTest.php</dd>
    <dd>ID: 3 ログアウト機能　MemberRogout.php</dd>
    <dd>ID: 4 商品一覧取得　ItemTest.php</dd>
    <dd>ID: 5 マイリスト一覧取得　MyListTest.php</dd>
    <dd>ID: 6 商品検索機能　KeywordTest.php</dd>
    <dd>ID: 7 商品詳細情報取得　DetailTest.php</dd>
    <dd>ID: 8 いいね機能　LikeTest.php</dd>
    <dd>ID: 9 コメント送信機能　CommentTest.php</dd>
    <dd>ID:10 商品購入機能　BuyTest.php</dd>
    <dd>ID:11 支払い方法選択機能　PayTest.php</dd>
    <dd>ID:12 配送先変更機能　DeliveryTest.php</dd>
    <dd>ID:13 ユーザー情報取得　UserInfoTest.php</dd>
    <dd>ID:14 ユーザー情報変更　UserInfoEditTest.php</dd>
    <dd>ID:15 出品商品情報登録　SellTest.php</dd>
    <dd>※phpコンテナ内で vendor/bin/phpunit tests/Feature/xxxxx.phpのように各テストファイルを指定してテストを実行して下さい。</dd>
</dl>

## 使用技術
* PHP 7.4.9
* Laravel 8.83.29
* MySQL 8.0.26

## ER図
![ER図](./er.png)

## URL
* 開発環境 : http://localhost/
* phpMyAdmin : http://localhost:8080/