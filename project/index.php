<?php

require_once __DIR__ . '/src/Book.php';
require_once __DIR__ . '/src/BookCollection.php';

$books = new BookCollection();
$books->addBook(new Book(1, '星の王子さま', 'サン＝テグジュペリ', 1943, '児童文学'));
$books->addBook(new Book(2, '坊っちゃん', '夏目漱石', 1906, '小説'));
$books->addBook(new Book(3, '銀河鉄道の夜', '宮沢賢治', 1934, '小説'));

$foundBook = $books->findById(2);
$missingBook = $books->findById(999);
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Library — Week 1</title>
</head>
<body>
    <h1>Book Library — Week 1</h1>
    <h2>登録した本（<?= $books->count() ?>冊）</h2>
    <pre><?php print_r($books->getAllBooks()); ?></pre>
    <h2>ID 2の検索結果</h2>
    <pre><?php print_r($foundBook?->toArray() ?? '本が見つかりません'); ?></pre>
    <h2>存在しないID 999の検索結果</h2>
    <pre><?php print_r($missingBook?->toArray() ?? '本が見つかりません'); ?></pre>
</body>
</html>
