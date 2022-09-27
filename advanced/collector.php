<?php

function dd(...$var) {
    var_dump($var);
    die;
}

/**
 * Fetch log files.
 * These typically end with .log so we can preg_match for "/\.log$/".
 */
$logFiles = [];
foreach (new \DirectoryIterator(".") as $dir) {
  if ($dir->isFile() || $dir->isDot() || $dir->getFilename() == ".idea" || $dir->getFilename() == ".git") {
    continue;
  }

  $dirname = $dir->getFilename();
  foreach (new \DirectoryIterator("./$dirname/") as $innerDir) {
    if ($innerDir->isDir() || $innerDir->isDot() || $innerDir->getFilename() == ".idea" || $innerDir->getFilename() == ".git") {
        continue;
    }
    
    if (preg_match("/\.log$/", $innerDir->getFileName())) {
        $filename = $innerDir->getFileName();
        $testnum = explode('.', $filename)[0];
        $logFiles[$testnum][$dirname] = __DIR__ . "/$dirname/" . $innerDir->getFileName();
    }
  }
}

/**
 * Fetch data.
 */
$rawData = [];
foreach ($logFiles as $testnum => $file) {
    foreach ($file as $dirname => $path) {
        $data = file_get_contents($path);

        if (empty($data)) {
            continue;
        }

        $rawData[$testnum][$dirname] = $data;
    }
}

if (empty($rawData)) {
  echo "no data found." . PHP_EOL;
  exit(0);
}

foreach ($rawData as $testnum => $data) {
    ksort($data, SORT_STRING);

    foreach ($data as $directory => $result) {
        $rows = explode("\n", $result);
        foreach ($rows as $index => $row) {
            $cols = explode(" ", $row);

            if (!empty($cols[0]) && !empty($cols[1]) && !empty($cols[2]) && !empty($cols[3]) && !empty($cols[4]) && !empty($cols[5])) {
                $type = $cols[0];
                $binary = $cols[1];
                $script = $cols[2];
                $iterations = $cols[3];
                $duration = $cols[4];
                $time_unit = $cols[5];

                $per_iteration = (int) $duration / (int) $iterations;

                echo "$testnum: ($type) #$iterations: $duration$time_unit ($per_iteration per iteration)" . PHP_EOL;
            }
        }
    }
}
