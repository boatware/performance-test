#!/bin/bash

# Define the limit of how long a script run can take maximum in seconds.
limit=30

# Define how many iterations should be tested.
# For example, zeros=2
# Then the script will iterate over
# 1 2 3 4 5 6 7 8 9
# 10 20 30 40 50 60 70 80 90
# 100 200 300 400 500 600 700 800 900
zeros=999

# Set the default mode
# pow = use numbers to the power of 2
# log = calc logarithmic scale
mode="pow"

dirs=()

if [[ $1 == "" ]]; then
  echo "missing param. use a directory name or --all"
  exit 1
fi

while [[ "$1" != "" ]];
do
  case "$1" in
    --no-limit)
      shift
      limit=0
      ;;

    --log|--use-log)
      shift
      mode="log"
      ;;

    --linear|--use-linear)
      shift
      mode="lin"
      ;;

    --pow|--use-power)
      shift
      mode="pow"
      ;;

    --all)
      shift
      dirs=$(\ls)
      ;;

    *)
      if [[ -d $1 ]]; then
        dirs+=($1)
      else
        echo "directory $1 not found"
        exit 1
      fi
      shift
      ;;

  esac
done

for dir in ${dirs[@]}
do
  if [[ ! -d $dir ]]; then
    continue
  fi

  if [[ $dir == "vendor" ]]; then
    continue
  fi

  if [[ $dir == "advanced" ]]; then
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

  j=1
  k=0
  num=1
  index=1
  lin_index=1

  while [[ $num -lt $(( (zeros + 1) * 9 + 1 )) ]];
  do
     mu=$(echo "scale=2;$j*10^$k"|bc)

     if [[ $mode == "log" ]]; then
       arg=$mu
     elif [[ $mode == "lin" ]]; then
       arg=$lin_index
       num=1
     else
       arg=$index
       num=1
     fi

     echo -ne "\r$arg"
     ts=$(date +%s%N)
     $cmd $arg
     ms=$((($(date +%s%N) - $ts)/1000000))
     echo "$cmd $arg $ms ms" >> run.log

     if [[ $limit -gt 0 ]]; then
       if [[ $ms -gt $((limit * 1000)) ]]; then
         echo -e "\nLast run took longer than $limit seconds. Exiting"
         break;
       fi
     fi

     index=$((index*2))
     ((lin_index++))

     [[ j -eq 9 ]] && j=0 && ((k++))
     ((j++))
     ((num++))
  done

  echo ""

  cd ..
done
