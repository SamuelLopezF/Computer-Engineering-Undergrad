import java.io.IOException;

public class Process implements Runnable {


    volatile int burst_time;
    int arrival_time;
    volatile String name = "";
    MMU pointer_to_MMU;

    @Override
    public void run()
    {

        this.name = String.valueOf(Thread.currentThread().getId());

        try {
            FIFO.CPU_CORES.acquire();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        System.out.println(name + " CPU CORE ACQUIRED");

        while(true)
        {
            int start = Clock.clock_tick;
            if (burst_time < 1000) {

                try {
                    FIFO.memory_manager.EXECUTE_NEXT_COMMAND();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }


                System.out.println(name  + "\t TIME : " + Clock.clock_tick+ "\tLAST RUN \t" + "BURST : " + burst_time);
                while (Clock.clock_tick < start + burst_time) ;
                burst_time = 0;
                System.out.println(name + "\t TIME : " + Clock.clock_tick+ "\tDONE \t\t" + "BURST : " + burst_time);
                FIFO.CPU_CORES.release();
                System.out.println(name + " CPU CORE RELEASING");
                return;
            } else {


                try {
                    FIFO.memory_manager.EXECUTE_NEXT_COMMAND();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }

                int rand = (int) (Math.random() * 98);      // generate rand ~10 ms
                rand = (rand * 10 ) + 10;
                System.out.println(name + "\t TIME : " + Clock.clock_tick + "\tSTARTING \t" + "\tBURST : " + burst_time);

                while (Clock.clock_tick  < (start + rand)) ;

                burst_time = burst_time - rand;

                System.out.println(name + "\t TIME : " + Clock.clock_tick  + "\tRAN FOR : " + rand  + "\tBURST : " + burst_time);
            }

        }



    }

    public Process(int arrival_time,  int burst_time, MMU pointer_to_MMU)
    {
        this.burst_time = burst_time * 1000;
        this.arrival_time = arrival_time * 1000;
        this.pointer_to_MMU = pointer_to_MMU;
    }

    @Override
    public String toString()
    {
        return  name + "\t BURST : " + burst_time + " \t ARRIVAL  : " +  arrival_time ;
    }


}
