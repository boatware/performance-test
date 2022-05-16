# performance-test

A collection of tests in different programming languages which do all the same things:

- Declare a function (or equivalent structure) which calculates and returns the sum of 42 and a random number
- Declare a function (or equivalent structure) which accepts an integer as parameter `i` and writes this parameter to the file `./write-test.txt` (relative to the running executable)
- Check if an argument is given and if this argument is a number and can be converted to an integer, then save that argument as `arg`
- Create a for loop which runs from 0 to `arg`
  - Assign the current iteration `i` to a new variable
  - Call the first function
  - Call the second function

The loop count is always given by an argument.

## Usage

To run the tests, execute the following command:

```shell
$ ./run.sh [[lang1, lang2]|--all]
```

where lang represents a directory name (and thus language name). Pass --all to run all tests
