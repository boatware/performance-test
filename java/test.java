class test {
    public static void testcalc() {
        int a = 42 + 17;
    }

    public static void main(String[] args) {
        if (args.length < 1) {
            System.out.println("missing param");
            System.exit(1);
        }

        try {
            long arg = Long.parseLong(args[0]);

            if (arg < 1) {
                System.out.println("param not a number");
                System.exit(1);
            }

            for (long i = 0; i < arg; i++) {
                long b = i;
                test.testcalc();
            }
        } catch (java.lang.NumberFormatException e) {
            System.out.println("param not a number");
            System.exit(1);
        }
    }
}