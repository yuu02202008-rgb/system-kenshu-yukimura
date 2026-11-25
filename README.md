# Book Library — 第1〜7週

PHP 8.3 / Apache / MySQL 8 と JavaScript ES modules の学習用アプリ。
本の取得・追加・編集・削除をAPI経由でDBへ保存し、タイトル・著者で検索できます。
実装はAI支援を利用。本人の学科学習、実行確認、チームメイトのレビューは区別して記録します。

## 初回起動

Docker Desktop、Gitを用意します。

```sh
git clone https://github.com/yuu02202008-rgb/system-kenshu-yukimura.git
cd system-kenshu-yukimura
git switch feature/docker-setup
cp .env.example .env
```

`.env`の2つのパスワードを自分専用の値へ変更します。DB名は教材SQLに合わせて `training` のままにします。`.env`はGitへ追加しません。

```sh
docker compose up -d --build --wait
docker compose exec -T database sh -c 'mysql --default-character-set=utf8mb4 -uroot -p"$MYSQL_ROOT_PASSWORD" training' < project/sql/schema.sql
docker compose exec -T database sh -c 'mysql --default-character-set=utf8mb4 -uroot -p"$MYSQL_ROOT_PASSWORD" training' < project/sql/seed.sql
```

SQLの投入は初回だけです。既存DBではシードを再投入しないでください。
http://localhost:8000 を開きます。再読み込みしても登録した本が残ります。
`docker compose down`で終了。データはボリュームに残ります。`down -v`はDBも消すので通常は使いません。
ポート変更時は`.env`のWEB_PORTに合わせます。コンテナ同士はホスト名`database`で通信します。
任意の管理画面は `docker compose --profile tools up -d phpmyadmin` → http://localhost:8080 。

## API

| メソッド | URL | 処理・正常時コード |
|---|---|---|
| GET | /api/books | 一覧 200 |
| GET | /api/books?id=1 | 1件取得 200 |
| POST | /api/books | JSONで追加 201 |
| PUT | /api/books | JSONのidと更新項目で変更 200 |
| DELETE | /api/books?id=1 | 削除 200 |

追加はtitle/author/year/genre必須。文字列はtitle・authorが255文字、genreが100文字まで。
yearは0〜9999の整数。更新で省略した項目は現在値を維持します。
不正入力400、該当なし404、許可しないメソッド405、DB障害など500。エラーはJSONで返します。
旧 `/api/books-get.php`、`books-create.php`、`books-update.php`、`books-delete.php` とPostmanコレクションも維持。

## 画面と構成

- `project/frontend/assets/js/api.js`: fetchとHTTPエラー処理。
- `ui.js`: 安全なtextContentでカード・件数・空状態・エラー表示。
- `app.js`: 操作、入力確認、通信中のボタン無効化、追加・編集・削除と検索。
- 検索は取得済みの配列を絞り込み、追加通信しません。
- 通信失敗時はフォーム入力と既存カードを保持。最初の取得失敗は再読み込みボタンで再試行。
- `project/index.php`と`.htaccess`: URLとHTTPメソッドの振り分け。
- `project/config/db.php`: 環境変数からPDO接続。API内のSQLはプリペアドステートメント。
- `week-01`〜`week-06/tasks`: 各週の独立した練習・説明メモ。
- 第1週フォーム: `docker compose exec -d webserver php -S 0.0.0.0:8001 -t /workspace/week-01/tasks` → http://localhost:8001/post-form.php
- 第5週Fetch課題: `week-05/tasks/README.md`参照。
- 第6週コンフリクト: `bash week-06/tasks/conflict-demo.sh`（一時リポジトリ内のみ）。

## 検証

GitHub ActionsでDockerを起動し、PHP構文、HTTP CRUD、Postman/Newman、実APIに接続したjsdomの画面操作、DB停止時500を検証します。
jsdomはブラウザーのレイアウトを描画しません。スマホ幅・デスクトップ幅の見た目は別途確認対象です。第5週教材は模擬HTTPによるDOMテストと、外部APIのGET 200（10件）・POST 201を別々に確認しています。
コンテナの `php -v` / `php -m` / `ls` とコンフリクト実行記録をActionsの `week-06-execution-evidence` artifactに保存します。
ローカルでの同じテストは、初期データ3冊の専用DBで `python3 project/tests/smoke.py` と `npm ci && npm test`（Node 22以降）を実行します。
HTTPテストは第1週フォームの開発サーバーも必要です。利用中のDBではなく検証用環境で実行してください。

提出状況は `training-progress/`。チームメイトのレビュー・mainへのマージは未完了として扱います。
TailwindはCDNを使用するため見た目の読み込みにネット接続が必要です。この学習用アプリに公開サービス用の認証・権限制御はありません。
