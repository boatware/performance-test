import sys
import random


def test():
    a = [*range(1, 1000)]
    b = [*range(1, 1000)]
    return random.choice(a) * random.choice(b)


def write_to_file(i):
    file = open("write-test.txt", "w")
    file.write(format(i))
    file.close()


def main():
    try:
        arg = sys.argv[1]

        if arg.isnumeric():
            for i in range(0, int(arg)):
                b = i
                test()
                write_to_file(b)

        else:
            print("param not a number")

    except IndexError:
        print("missing param")


if __name__ == "__main__":
    main()
