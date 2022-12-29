

/*The Clock class is mainly used to create parallelism in the program. It's main purpose
* is to serve as a time reference by other classes, and it's provides integer values of time
* with a delay of 1s. */
public class Clock implements Runnable {

    /*the clock time is set to 1 at init for reasons provided in the assignment sheet,
    * and was set to static for simplicity of access*/

    static int time = 0;


    /*The run() where the clock waits for 1s and increments the time by 1.
    * A while(true) loop is used, since there is no condition within this class's
    * scope to know when to stop. */
    @Override
    public void run() {

        while (true) {
            try {
                Thread.sleep(1000);
            } catch (InterruptedException e) {
            }
            time++;
//            System.out.print(time +"\t");
        }
    }
}
