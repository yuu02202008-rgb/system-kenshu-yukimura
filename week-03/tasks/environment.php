<?php
$missing = [];
foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'] as $name) {
    $value = getenv($name);
    if ($value === false || $value === '') {
        $missing[] = $name;
    } else {
        echo $name . ": 設定済み\n"; // パスワードの値は表示しない。
    }
}
if ($missing !== []) {
    fwrite(STDERR, '未設定: ' . implode(', ', $missing) . "\n");
    exit(1);
}
