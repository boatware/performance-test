#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>

void test() {
    int a = 42 + 17;
}

int main(int argc, char *argv[]) {
    if (argc < 2) {
        printf("missing param\n");
        exit(1);
    }
    char *p;
    long arg = strtol(argv[1], &p, 10);

    for (int i = 0; i < arg; i++) {
        int b = i;
        test();
    }

    exit(EXIT_SUCCESS);
}
