<?php

function test() {
    $r = rand(1, 1000);
    $a = rand(1, 1000);
    return $r * $a;
}

function writeToFile($i) {
    file_put_contents("./write-test.txt", $i);
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
    $b += test();
    writeToFile($b);
}
