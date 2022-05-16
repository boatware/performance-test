result=0
function test() {
  r=$(( ( RANDOM % 1000 )  + 1 ))
  a=$(( ( RANDOM % 1000 )  + 1 ))
  result=$((r * a))
}

function writeToFile() {
  if [[ $1 -ne "" ]]; then
    echo $1 > ./write-test.txt
  fi
}

if [[ $1 == "" ]]; then
  echo "missim param"
  exit 1
fi

case $1 in
    ''|*[!0-9]*) echo "param is not a number"; exit 1 ;;
    *) ;;
esac

for (( i=0 ; $i < $1 ; i++ ))
do
  b=$i
  test
  b=$((i + result))
  writeToFile $b
done
