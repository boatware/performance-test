<?php

class A {
    public static function aa($b) {
        $c = $b;
        $c += 1;
    }
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
    A::aa($i);
}