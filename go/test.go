package main

import (
	"fmt"
	"math/rand"
	"os"
	"regexp"
	"strconv"
	"time"
)

func test() int {
	rand.Seed(time.Now().UnixNano())
	r := rand.Intn(1000-2) + 1
	a := rand.Intn(1000-2) + 1
	return r * a
}

func writeToFile(i int) {
	d1 := []byte(strconv.Itoa(i))
	err := os.WriteFile("./write-test.txt", d1, 0644)
	if err != nil {
		panic(err)
	}
}

func main() {
	if os.Args[1] == "" {
		fmt.Println("missing param")
		os.Exit(1)
	}

	match, err := regexp.Match(``, []byte(os.Args[1]))
	if err != nil {
		panic(err)
	}

	if !match {
		fmt.Println("param not a number")
		os.Exit(1)
	}

	arg, err := strconv.Atoi(os.Args[1])
	if err != nil {
		panic(err)
	}

	for i := 0; i < arg; i++ {
		b := i
		b += test()
		writeToFile(b)
	}
}
