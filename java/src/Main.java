import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Random;

public class Main {
    public static int test() {
        Random rand = new Random();
        int low = 1;
        int high = 1000;
        int r = rand.nextInt(high-low) + low;
        int a = rand.nextInt(high-low) + low;
        return r*a;
    }

    public static void writeToFile(long i) throws IOException {
        String str = Long.toString(i);
        BufferedWriter writer = new BufferedWriter(new FileWriter("./write-test.txt"));
        writer.write(str);
        writer.close();
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
                b += test();

                writeToFile(b);
            }
        } catch (java.lang.NumberFormatException e) {
            System.out.println("param not a number");
            System.exit(1);
        } catch (IOException e) {
            System.out.println("io exception when trying to write to file");
            System.exit(1);
        }
    }
}