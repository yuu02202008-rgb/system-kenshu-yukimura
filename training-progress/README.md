# 第5〜7週 提出チェック・短いコメント

Google Sheets本体は未更新です（こちらのブラウザーはGoogle未ログイン）。以下は検証に基づく記入用データです。本人の独力実装やチームメイトのレビューを示すものではありません。

提出PR: https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2
実行検証: https://github.com/yuu02202008-rgb/system-kenshu-yukimura/actions/runs/45535992814

画面操作テストはjsdom＋実API。実ブラウザーの見た目・レスポンシブ表示は未確認。外部Fetch教材はDOMの模擬通信テストと、外部APIへのGET/POSTの実応答を別々に確認しました。

## 第5週

| 行 | 完了 | コメント | 根拠 |
|---|---|---|---|
| 5 | ✓ | then版とasync/await版を実装し、同じ結果を返すことを確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-05/tasks/api.js) |
| 6 | ✓ | 10件表示・通信中・エラー表示をDOMテストで確認しました。外部APIのGETも200でした。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-05/tasks/) |
| 7 | ✓ | 送信中のボタン無効化と応答表示を確認しました。外部APIのPOSTも201でした。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-05/tasks/) |
| 8 | ✓ | 通信をapi.js、DOM操作をmain.jsに分けました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-05/tasks/) |
| 12 | ✓ | 取得・追加・更新・削除の通信処理をまとめました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/assets/js/api.js) |
| 13 | ✓ | 一覧・エラー・通信中の表示を関数に分けました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/assets/js/ui.js) |
| 14 | ✓ | api.jsとui.jsをimportして操作につなげました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/assets/js/app.js) |
| 15 | ✓ | ページ読込時にDBの本を取得して表示することを確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 16 | ✓ | POST成功後にフォームを空にして、一覧へ反映しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 17 | ✓ | DELETE成功後にカードを削除し、失敗時は残すことを確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 18 | ✓ | 通信失敗時にメッセージを表示するテストが通りました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 19 | ✓ | 第5週の実装をGitHubへ反映しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/) |

## 第6週

| 行 | 完了 | コメント | 根拠 |
|---|---|---|---|
| 5 | ✓ | ブランチ・マージ・pushの説明を用意。マージ練習を実行し、提出はGitHub APIで反映しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-06/tasks/git-notes.txt) |
| 6 | ✓ | 一時リポジトリで同じ行の衝突を再現し、解消しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-06/tasks/conflict-demo.sh) |
| 7 | ✓ | 各サービス・ポート・環境変数・永続化を説明しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-06/tasks/docker-notes.txt) |
| 8 | ✓ | CIでphp -v・php -m・lsを実行。出力をcontainer-info.txtに実行結果を保存しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/week-06/tasks/) |
| 12 | ✓ | feature/docker-setupブランチで第5〜7週の変更を提出しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/) |
| 13 | ✓ | 通常起動はwebserverとdatabaseの2サービスです。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/docker-compose.yml) |
| 14 | ✓ | PHP8.3/Apache・マウント・環境変数・8000番ポートを設定しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/Dockerfile) |
| 15 | ✓ | MySQL8と永続化ボリュームを設定し、起動確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/docker-compose.yml) |
| 16 | ✓ | 必要な変数と用途のコメントを記載しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/.env.example) |
| 17 | ✓ | CIでDockerスタックのビルド・起動が成功しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/actions/runs/45535992814) |
| 18 | ✓ | GET・POST・PUT・DELETEを実DBに接続して確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/actions/runs/45535992814) |
| 19 | ✓ | フロントエンドから実APIへの取得・追加・編集・削除を検証しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 20 | ✓ | clone・env・Compose・DB初期化・アクセス手順を更新しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/README.md) |
| 21 | ✓ | main向けの提出用PR #2を作成しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2) |
| 22 | ✓ | 変更内容・検証方法・未確認事項をPRに記載しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2) |
| 23 | 未完了 | チームメイトによるレビューコメント待ちです。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2) |
| 24 | 未完了 | レビュー対応とmainへのマージは未実施です。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2) |

## 第7週

| 行 | 完了 | コメント | 根拠 |
|---|---|---|---|
| 5 | ✓ | 200・201・400・404と、DB停止時の500を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/actions/runs/45535992814) |
| 6 | ✓ | 必須項目・型・文字数・年・IDを検証し、エラーをJSONで返します。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/api/response.php) |
| 7 | ✓ | API内の全SQLをプリペアドステートメントにしました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/api/) |
| 8 | ✓ | 接続情報は環境変数から取得し、実パスワードは含めていません。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/config/db.php) |
| 9 | ✓ | 初回読込でDBの本一覧を表示するテストが通りました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 10 | ✓ | 入力確認→POST→一覧反映とDB保存を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 11 | ✓ | DELETE成功後のカード削除とDBからの削除を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 12 | ✓ | 通信中表示とボタン無効化を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/assets/js/app.js) |
| 13 | ✓ | 通信失敗時のエラー表示と既存データ保持を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 14 | ✓ | 編集時に既存値を入力し、PUTで更新・保存を確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 15 | ✓ | タイトル・著者を絞り込み、追加API通信がないことを確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/tests/frontend.mjs) |
| 16 | ✓ | 0件時と検索結果0件時のメッセージを確認しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/assets/js/ui.js) |
| 17 | ✓ | ページタイトルとSVGファビコンを設定しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/project/frontend/index.html) |
| 18 | ✓ | DockerでPHP/ApacheとMySQLの起動が成功しました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/actions/runs/45535992814) |
| 19 | 未完了 | PR作成済み。チームメイトのレビューとmainマージは待ちです。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/pull/2) |
| 20 | ✓ | 起動・API・画面機能・テスト・制限を現実装に合わせました。 | [確認](https://github.com/yuu02202008-rgb/system-kenshu-yukimura/tree/feature/docker-setup/README.md) |

## 貼り付け方法

各TSVのファイル名に書かれた範囲（例: 第5週のB5:D8）へ内容を貼り付けます。列は完了・GitHubリンク・コメントの順。メンター欄は変更しません。既に入力がある場合は内容を確認してから反映します。
