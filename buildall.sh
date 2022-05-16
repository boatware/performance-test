#!/bin/bash

dirs=(
"c"
"c++"
"c++11"
"c11"
)

for dir in ${dirs[@]}
do
  [ ! -f "./$dir/build.sh" ] || cd $dir && chmod +x ./build.sh && ./build.sh && cd ..
done