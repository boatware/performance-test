<?php

function test() {
    $a = 42 + 17;
}

if (!isset($argv[1])) {
    echo "missing param" . PHP_EOL;
    exit(1);
}

if (!is_numeric($argv[1])) {
    echo "param not a number" . PHP_EOL;
    exit(1);
}

$arg = (int) $argv[1];
for ($i = 0; $i < $arg; $i++) {
    $b = $i;
    /** @noinspection PhpExpressionResultUnusedInspection */
    test();
}
