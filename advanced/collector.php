<?php

function dd(...$var) {
    var_dump($var);
    die;
}

$languageBasedResults = [];
$testBasedResults = [];

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

$testKeys = array_keys($rawData);
asort($testKeys);
$languageBasedResultsHeader = "iterations," . implode(",", $testKeys);
var_dump($languageBasedResultsHeader);

$languages = [];
foreach ($rawData as $testnum => $data) {
    ksort($data, SORT_STRING);
    foreach ($data as $directory => $result) {
        $languages[$directory] = $directory;
    }
}
$languages = array_values($languages);
asort($languages, SORT_STRING);
$testBasedResultsHeader = "iterations," . implode(",", $languages);
var_dump($testBasedResultsHeader);

ksort($rawData, SORT_STRING);
foreach ($rawData as $testnum => $data) {
    ksort($data, SORT_STRING);

    foreach ($data as $directory => $result) {
        $rows = explode("\n", $result);
        foreach ($rows as $index => $row) {
            $cols = explode(" ", $row);

            if (!empty($cols[0]) && !empty($cols[1]) && !empty($cols[2]) && !empty($cols[3]) && !empty($cols[4]) && !empty($cols[5])) {
                $iterations = $cols[3];
                $duration = $cols[4];

                $testBasedResults[$testnum][$iterations][$directory] = $duration;
                $languageBasedResults[$directory][$iterations][$testnum] = $duration;
            }
        }
    }
}

/****************************************************
 * Generate language based results.
 ****************************************************/
$allLanguages = [];
foreach ($testBasedResults as $testnum => $data) {
    foreach ($data as $iterations => $result) {
        foreach ($result as $language => $duration) {
            $allLanguages[$language] = $language;
        }
    }
}
foreach ($testBasedResults as $testnum => $data) {
    foreach ($data as $iterations => $result) {
        foreach ($allLanguages as $language) {
            if (!isset($testBasedResults[$testnum][$iterations][$language])) {
                $testBasedResults[$testnum][$iterations][$language] = "";
                ksort($testBasedResults[$testnum][$iterations], SORT_STRING);
            }
        }
    }
}

$testBasedResultRows = [];
foreach ($testBasedResults as $testnum => $data) {
    $testBasedResultRows[$testnum][] = $testBasedResultsHeader;
    foreach ($data as $iterations => $result) {
        $testBasedResultRows[$testnum][] = $iterations . "," . implode(",", $result);
    }
}

foreach ($testBasedResultRows as $testnum => $rows) {
    file_put_contents("results/test-$testnum.csv", implode("\n", $rows));
}

/****************************************************
 * Generate test based results.
 ****************************************************/
$allTestNumbers = [];
foreach ($languageBasedResults as $language => $data) {
    foreach ($data as $iterations => $result) {
        foreach ($result as $testnum => $duration) {
            $allTestNumbers[$testnum] = $testnum;
        }
    }
}
foreach ($languageBasedResults as $language => $data) {
    foreach ($data as $iterations => $result) {
        foreach ($allTestNumbers as $testnum) {
            if (!isset($languageBasedResults[$language][$iterations][$testnum])) {
                $languageBasedResults[$language][$iterations][$testnum] = "";
                ksort($languageBasedResults[$language][$iterations], SORT_STRING);
            }
        }
    }
}

$languageBasedResultRows = [];
foreach ($languageBasedResults as $language => $data) {
    $languageBasedResultRows[$language][] = $languageBasedResultsHeader;
    foreach ($data as $iterations => $result) {
        $languageBasedResultRows[$language][] = $iterations . "," . implode(",", $result);
    }
}

foreach ($languageBasedResultRows as $language => $rows) {
    file_put_contents("results/$language.csv", implode("\n", $rows));
}
