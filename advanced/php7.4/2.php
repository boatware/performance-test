<?php

if (!isset($argv[1])) {
    echo "missing param" . PHP_EOL;
    exit(1);
}

if (!is_numeric($argv[1])) {
    echo "param not a number" . PHP_EOL;
    exit(1);
}

$argument = (int) $argv[1];
for ($iteration = 0; $iteration < $argument; $iteration++) {
    $someExtraOrdinary = $iteration;
}