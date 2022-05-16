<?php

$rawData = [];
foreach (new \DirectoryIterator(".") as $dir) {
  if ($dir->isFile() || $dir->isDot() || $dir->getFilename() == ".idea" || $dir->getFilename() == ".git") {
    continue;
  }

  $dirname = $dir->getFilename();
  $filename = "./$dirname/run.log";
  if (!file_exists($filename)) {
    continue;
  }

  $data = file_get_contents($filename);

  if (empty($data)) {
    continue;
  }
  $rawData[$dirname] = $data;
}

if (empty($rawData)) {
  echo "no data found." . PHP_EOL;
  exit(0);
}

ksort($rawData, SORT_STRING);

function exportCsv($rawData) {
  $cleanData = [];
  foreach ($rawData as $language => $data) {
    $split = explode(PHP_EOL, $data);

    foreach ($split as $measured) {
      if (empty($measured)) {
        continue;
      }

      $exploded = explode(" ", $measured);
      $timeIndex = sizeof($exploded) - 2;
      $iterationsIndex = sizeof($exploded) - 3;

      if (!isset($exploded[$timeIndex]) || !isset($exploded[$iterationsIndex])) {
        continue;
      }

      $time = $exploded[$timeIndex];
      $iterations = $exploded[$iterationsIndex];

      if (!isset($cleanData[$iterations])) {
        $cleanData[$iterations] = [];
      }

      $cleanData[$iterations][$language] = $time;
    }
  }

  $order = array_keys($rawData);
  $csv = "iterations," . implode(",", $order) . PHP_EOL;

  foreach ($cleanData as $iterations => $language) {
    $entry = "$iterations,";

    foreach ($order as $lang) {
      if (isset($language[$lang])) {
        $entry .= $language[$lang];
      }

      if ($lang !== $order[sizeof($order) - 1]) {
        $entry .= ",";
      }
    }

    $entry .= PHP_EOL;
    $csv .= $entry;
  }

  file_put_contents("data.csv", $csv);
}
function exportChartJsData($rawData) {
  $data = [];
  $datasets = [];
  $labels = [];
  $fill = false;
  $colorIndex = 0;
  $borderColor = [
    '#ef4444',
    '#f97316',
    '#f59e0b',
    '#eab308',
    '#84cc16',
    '#22c55e',
    '#10b981',
    '#14b8a6',
    '#06b6d4',
    '#0ea5e9',
    '#3b82f6',
    '#6366f1',
    '#8b5cf6',
    '#a855f7',
    '#d946ef',
    '#ec4899',
    '#f43f5e',
  ];
  $tension = 0;

  foreach ($rawData as $language => $raw) {
    $extracted = [];
    $entries = explode(PHP_EOL, $raw);
    foreach ($entries as $entry) {
      if (empty($entry)) {
        continue;
      }
      $exploded = explode(" ", $entry);
      $timeIndex = sizeof($exploded) - 2;
      $iterationsIndex = sizeof($exploded) - 3;

      if (empty($exploded[$timeIndex]) || !isset($exploded[$iterationsIndex])) {
        continue;
      }

      $iterations = $exploded[$iterationsIndex];
      if (!in_array($iterations, $labels)) {
        $labels[] = $iterations;
      }
      $extracted[] = (int) $exploded[$timeIndex];
    }

    /** @noinspection PhpConditionAlreadyCheckedInspection */
    $toAdd = [
      'label' => $language,
      'data' => $extracted,
      'fill' => $fill,
      'borderColor' => $borderColor[$colorIndex],
      'tension' => $tension,
      'axis' => 'y',
    ];
    $datasets[] = $toAdd;
    $colorIndex++;
  }

  $data['labels'] = $labels;
  $data['datasets'] = $datasets;
  $json = json_encode($data);
  file_put_contents("data.json", $json);
}

exportCsv($rawData);
exportChartJsData($rawData);
