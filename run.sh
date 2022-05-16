#!/bin/bash

range=(
         1          2          3          4          5          6          7          8          9
        10         20         30         40         50         60         70         80         90
       100        200        300        400        500        600        700        800        900
      1000       2000       3000       4000       5000       6000       7000       8000       9000 # 1k
     10000      20000      30000      40000      50000      60000      70000      80000      90000 # 10k
    100000     200000     300000     400000     500000     600000     700000     800000     900000 # 100k
   1000000    2000000    3000000    4000000    5000000    6000000    7000000    8000000    9000000 # 1m
  10000000   20000000   30000000   40000000   50000000   60000000   70000000   80000000   90000000 # 10m
 100000000  200000000  300000000  400000000  500000000  600000000  700000000  800000000  900000000 # 100m
1000000000 2000000000 3000000000 4000000000 5000000000 6000000000 7000000000 8000000000 9000000000 # 1b
)

limit=1000

dirs=$(\ls)

if [[ $1 == "" ]]; then
  echo "missing param. use a directory name or --all"
  exit 1
fi

if [[ $1 == "--all" ]]; then
  dirs=$(\ls)
else
  if [[ -d $1 ]]; then
    dirs=($1)
  else
    echo "directory not found."
    exit 1
  fi
fi

for dir in ${dirs[@]}
do
  if [[ ! -d $dir ]]; then
    continue
  fi

  echo "running performance test in directory: $dir"

  cd $dir

  if [[ ! -f "./run.sh" ]]; then
    echo "run command not found"
    exit 1
  fi

  if [[ -f run.log ]]; then
    rm -rf run.log
  fi

  source ./run.sh

  for i in ${range[@]}
  do
    echo -ne "\r$i"
    ts=$(date +%s%N)
    $cmd $i
    ms=$((($(date +%s%N) - $ts)/1000000))
    echo "$cmd $i $ms ms" >> run.log
    if [[ $ms -gt $limit ]]; then
      echo -e "\nLast run took longer than $((limit / 1000)) seconds. Exiting"
      break;
    fi
  done

  cd ..
done