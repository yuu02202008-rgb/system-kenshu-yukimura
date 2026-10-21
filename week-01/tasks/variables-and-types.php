<?php

// PHPの基本データ型を変数に入れて、値と型を表示します。
$name = 'Yuki';
$age = 20;
$height = 1.72;
$isLearning = true;
$favoriteBooks = ['The Little Prince', 'Botchan'];
$nothing = null;

$values = [
    'string (name)' => $name,
    'integer (age)' => $age,
    'float (height)' => $height,
    'boolean (isLearning)' => $isLearning,
    'array (favoriteBooks)' => $favoriteBooks,
    'null (nothing)' => $nothing,
];

foreach ($values as $label => $value) {
    if (is_array($value)) {
        $display = implode(', ', $value);
    } elseif (is_bool($value)) {
        $display = $value ? 'true' : 'false';
    } elseif ($value === null) {
        $display = 'null';
    } else {
        $display = (string) $value;
    }

    echo $label . ' — echo: ' . $display . PHP_EOL;
    echo $label . ' — var_dump: ';
    var_dump($value);
}
