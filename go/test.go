package main

import (
	"fmt"
	"os"
	"regexp"
	"strconv"
)

func test() {
	_ = 42 + 17
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
		_ = i
		test()
	}
}
