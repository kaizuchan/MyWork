## 開発環境

XAMMP

PHP 8.1.10

mysql

## 起動手順

config/.env.example を .envに変更

config/app_local.example.php を app_local.phpに変更

.env 内の
DB_HOST
DB_USERNAME
DB_PASSWORD
DB_DATABASE
を使用するDBに合わせて変更

#### xammpを使っている場合

php.ini 内の「;extension=intl」のセミコロンを外す

#### 以下のコマンドを実行

```jsx
    // プラグインのインストール
    composer update
    composer require cakephp/authentication
    composer require cakephp/authorization:^2.0
    composer dump-autoload
    
    // マイグレーション
    bin\cake migrations migrate

    // サーバーの起動
    bin\cake server
```
