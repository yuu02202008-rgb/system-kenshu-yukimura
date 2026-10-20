<?php

// 奇数・偶数の判定例です。
$checkNumber = 7;
if ($checkNumber % 2 === 0) {
    echo $checkNumber . "は偶数です。\n";
} else {
    echo $checkNumber . "は奇数です。\n";
}

// 1〜20のFizzBuzz。3と5の両方で割り切れる数を先に判定します。
for ($number = 1; $number <= 20; $number++) {
    if ($number % 15 === 0) {
        echo "FizzBuzz\n";
    } elseif ($number % 3 === 0) {
        echo "Fizz\n";
    } elseif ($number % 5 === 0) {
        echo "Buzz\n";
    } else {
        echo $number . "\n";
    }
}
