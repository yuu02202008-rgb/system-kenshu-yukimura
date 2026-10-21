<?php

function formatNameAndAge(string $name, int $age): string
{
    return sprintf('%sさんは%d歳です。', $name, $age);
}

function numbersOverTen(array $numbers): array
{
    return array_values(array_filter(
        $numbers,
        static fn (int $number): bool => $number > 10
    ));
}

$numbers = [3, 8, 10, 11, 15, 21];
$overTen = numbersOverTen($numbers);

echo formatNameAndAge('雪村', 20) . PHP_EOL;
echo '10より大きい数: ' . implode(', ', $overTen) . PHP_EOL;
