public class Clock implements Runnable {

    boolean trace = false;

    static volatile public int clock_tick ;

    @Override
    public void run() {



        while(true)
        {
            try {

                Thread.sleep(10);

            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            clock_tick = clock_tick + 10;
//            System.out.println(clock_tick);

        }
    }

    public Clock(boolean trace)
    {
        this.trace = trace;
        this.clock_tick = 0;
    }
}
