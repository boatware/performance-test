import sys

def test():
    a = 42 + 17

def main():
    try:
        arg = sys.argv[1]

        if arg.isnumeric():
            for i in range(0, int(arg)):
                b = i
                test()

        else:
            print("param not a number")

    except IndexError:
        print("missing param")


if __name__ == "__main__":
    main()