<?php
$name = '';
$submitted = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($submitted) {
    $submittedName = $_POST['name'] ?? null;
    $name = is_string($submittedName) ? trim($submittedName) : '';
}

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>名前フォーム</title>
</head>
<body>
    <h1>名前フォーム</h1>
    <form method="post">
        <label for="name">名前</label>
        <input id="name" name="name" value="<?= escapeHtml($name) ?>" required>
        <button type="submit">送信</button>
    </form>
    <?php if ($submitted): ?>
        <?php if ($name !== ''): ?>
            <p>こんにちは、<?= escapeHtml($name) ?>さん。</p>
        <?php else: ?>
            <p>名前を入力してください。</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
