#include <stdlib.h>
#include <iostream>

using namespace std;

void test() {
    int a = 42 + 17;
}

int main(int argc, char *argv[]) {
    if (argc < 2) {
        cout << "missing param\n" << endl;
        exit(1);
    }
    char *p;
    long long arg = strtol(argv[1], &p, 10);

    for (long long i = 0; i < arg; i++) {
        int b = i;
        test();
    }

    exit(EXIT_SUCCESS);
}
