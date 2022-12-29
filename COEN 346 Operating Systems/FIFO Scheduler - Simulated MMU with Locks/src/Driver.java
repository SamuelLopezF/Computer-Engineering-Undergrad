import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Scanner;

public class Driver {


    public static void main(String[] args) throws IOException, InterruptedException {






        FIFO scheduler_run_obj= new FIFO();

        Thread fifo = new Thread(scheduler_run_obj);
        Thread clk = new Thread(new Clock(false));

        fifo.start();
        clk.start();










    }


}
