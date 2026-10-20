<?php

function formatNameAndAge(string $name, int $age): string
{
    return sprintf('%sさんは%d歳です。', $name, $age);
}

$numbers = [3, 8, 10, 11, 15, 21];
$overTen = array_values(array_filter(
    $numbers,
    static fn (int $number): bool => $number > 10
));

echo formatNameAndAge('雪村', 20) . PHP_EOL;
echo '10より大きい数: ' . implode(', ', $overTen) . PHP_EOL;
