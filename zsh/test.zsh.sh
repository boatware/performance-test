function test() {
  a=$(expr 42 + 17)
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
done
