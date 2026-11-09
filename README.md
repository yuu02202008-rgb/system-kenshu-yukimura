# Book Library — Week 1–4

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
- `project/src/` と `project/examples/week-01.php`: Week 1 のBook Library
- `project/api/`, `project/config/`, `project/sql/`: Week 2のAPI・DB
- `project/screenshots/week-02/`: Postman確認画面の保存先

## 提出前チェック

- Docker上で各APIをPostmanから試し、実際のレスポンス画面を `project/screenshots/week-02/` に保存する。
- `.env` やパスワードをGitHubへ上げない。
- GitHubのWeek 1・Week 2シートにチェック、リポジトリURL、学んだ点や質問を記入する。

このリポジトリは学習用です。公開サービスの認証・権限・レート制限などは実装していません。

## 第3・4週で追加した内容

- `/` または `/frontend/index.html`: 本一覧・追加フォーム（第4週、画面内のみ）。
- `/examples/week-01.php`: 第1週のクラス実演を移動して保存。
- `/api/books`: GET / POST / PUT / DELETEをindex.phpで振り分ける。IDはGET/DELETEではクエリ、PUTではJSON本文に指定。
- 旧 `/api/books-*.php` も使用可能。第2週のPostmanコレクションを維持。
- `week-03/tasks/`: リクエストの12段階、Apache設定、環境変数の練習。
- `week-04/tasks/`: HTML構造と実装場所の案内。

既存環境では `docker compose up -d --build` でApache設定を再ビルドします。既存DBの削除は不要です。

### 画面の確認
1. 本が3冊表示されることを確認。
2. 「本を追加」でフォーム表示・非表示を切り替える。
3. 空のまま送信して4項目にエラーが出ることを確認。
4. 全項目を入力して送信。カードと件数が増え、コンソールにオブジェクトとJSON文字列が出る。
5. 削除ボタンでカードが消える。全件削除すると空状態になる。
6. スマホ幅とデスクトップ幅で確認する。

この画面は第4週のDOM練習です。DBへの保存は行いません。画面とAPIの接続は第5週です。
TailwindはCDNから読み込むため、スタイル表示にはインターネット接続が必要です。

### 説明用メモ
- PHP: 入力を確認し、DBを検索・更新する。
- Apache: HTTPリクエストを受け付ける。
- index.php: メソッドとパスで処理先を決める。
- PDO: PHPからDBへSQLを実行する。
- JSON: データの交換形式。APIそのものではない。
- HTML: 構造、Tailwind: 見た目、JavaScript: 画面上の操作。
- `.env`はComposeが読み、environmentでPHPへ渡す。getenvだけでは.envを読まない。
- Git addは変更を選ぶ、commitは履歴を作る、pushはGitHubへ送る。

実装支援にAIを利用しています。コードの用意と本人による理解・実演は別です。
Postmanのスクリーンショットは実際に撮影したものだけを保存してください。
