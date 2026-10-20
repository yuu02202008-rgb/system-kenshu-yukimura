# Week 2 提出・確認手順

## スキルビルダー

1. `http-notes.txt` にHTTPメソッドとステータスコードを整理済みです。
2. `project/api/status.php` が `message` と `status: ok` を返します。PostmanでGETし、実際の画面をスクリーンショットに保存します。
3. `project/sql/schema.sql` と `seed.sql` でテーブル・サンプル3件を作り、`GET /api/books-get.php` で全件を取得します。
4. `POST /api/books-create.php` にtitle・author・year・genreのJSONを送ります。必須項目不足の400と、正常時の201を両方試します。

## Book Library API

Postmanへ `project/postman/Book-Library.postman_collection.json` をインポートして、status → 一覧 → 作成 → 1件取得 → 更新 → 削除の順で実行します。コレクションには応答から作成IDを保存する処理を入れています。

## 提出用スクリーンショット

実際にDocker上でPostmanを実行し、成功した画面をこのフォルダーへ保存します。まだ実行していない画面を作ったり、結果を偽装したりしないでください。最低4枚（status、GET、POST成功、POST失敗）を保存し、余裕があればPUT・DELETEも追加してください。
