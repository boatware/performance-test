#include <stdlib.h>
#include <iostream>

using namespace std;

char* itoa(int val, int base) {
    static char buf[32] = {0};
    int i = 30;
    for(; val && i ; --i, val /= base) {
        buf[i] = "0123456789abcdef"[val % base];
    }

    return &buf[i+1];
}

int test() {
    srand(time(NULL));
    int r = rand() % 1000;
    int a = rand() % 1000;
    return r*a;
}

void writeToFile(int i) {
    FILE *f = fopen("./write-test.txt", "w+");
    char *ii;
    ii = itoa(i, 10);
    fputs(ii, f);
    fclose(f);
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
        b += test();
        writeToFile(b);
    }

    exit(EXIT_SUCCESS);
}
