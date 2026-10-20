# Book Library — Week 1 & Week 2

PHP 8.3 / Apache / MySQL 8 の練習用 Book Library です。Week 1 の PHP 基礎課題と、Week 2 の REST API・CRUD 課題を同じリポジトリにまとめています。

## 起動

1. Docker Desktop を起動します。
2. `.env.example` を `.env` にコピーし、2つのパスワードを自分用の値に変更します。
3. リポジトリのルートで `docker compose up -d --build` を実行します。
4. `docker compose ps` で `database` が `healthy` になったら、`project/sql/schema.sql`、続けて `project/sql/seed.sql` を phpMyAdmin（`http://localhost:8080`）から実行します。
5. `http://localhost:8000/api/status.php` を開き、`{"message":"API is running","status":"ok"}` が返ることを確認します。

ポートを変えた場合は `.env` の値に合わせてURLを読み替えてください。DB接続はコンテナ内の `database` ホスト名を使います。`.env` はGitに追加しないでください。

Week 1のCLI課題はDocker内のPHPで実行できます。例: `docker compose exec web php /workspace/week-01/tasks/variables-and-types.php`。フォーム課題は別ポートのPHP開発サーバーを起動し、`http://localhost:8001/post-form.php` を開きます。

```sh
docker compose exec -d web php -S 0.0.0.0:8001 -t /workspace/week-01/tasks
```

## API

| Method | URL | 目的 |
|---|---|---|
| GET | `/api/status.php` | JSON状態確認 |
| GET | `/api/books-get.php` | 全件取得 |
| GET | `/api/books-get.php?id=1` | 1件取得。存在しないIDは404 |
| POST | `/api/books-create.php` | title・author・year・genreをJSONで新規作成。成功は201 |
| PUT | `/api/books-update.php` | JSONの `id` と更新項目で更新 |
| DELETE | `/api/books-delete.php?id=1` | ID指定で削除 |

Postman用の一連のリクエストは `project/postman/Book-Library.postman_collection.json` にあります。コレクションを取り込み、上から順に実行できます。

## 課題ファイル

- `week-01/tasks/`: PHP基礎の4課題
- `week-02/tasks/`: HTTPメモとWeek 2の提出・撮影手順
- `project/src/` と `project/index.php`: Week 1 のBook Library
- `project/api/`, `project/config/`, `project/sql/`: Week 2のAPI・DB
- `project/screenshots/week-02/`: Postman確認画面の保存先

## 提出前チェック

- Docker上で各APIをPostmanから試し、実際のレスポンス画面を `project/screenshots/week-02/` に保存する。
- `.env` やパスワードをGitHubへ上げない。
- GitHubのWeek 1・Week 2シートにチェック、リポジトリURL、学んだ点や質問を記入する。

このリポジトリは学習用です。公開サービスの認証・権限・レート制限などは実装していません。
