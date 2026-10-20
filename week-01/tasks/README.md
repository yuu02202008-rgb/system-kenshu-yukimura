# Week 1 Skill Builder

Docker Desktopを起動し、リポジトリのルートで `docker compose up -d --build` を実行した後、各CLI課題を実行します。

```sh
docker compose exec web php /workspace/week-01/tasks/variables-and-types.php
docker compose exec web php /workspace/week-01/tasks/conditionals-loops.php
docker compose exec web php /workspace/week-01/tasks/functions-arrays.php
```

フォーム課題は、次のコマンドで開発サーバーを起動してから `http://localhost:8001/post-form.php` をブラウザーで開きます。

```sh
docker compose exec -d web php -S 0.0.0.0:8001 -t /workspace/week-01/tasks
```
