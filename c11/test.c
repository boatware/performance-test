#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

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
        printf("missing param\n");
        exit(1);
    }
    char *p;
    long arg = strtol(argv[1], &p, 10);

    for (long i = 0; i < arg; i++) {
        int b = i;
        b += test();
        writeToFile(b);
    }

    exit(EXIT_SUCCESS);
}
