

/*
* This class contains the description for the process thread. It's main purpose
* is to keep track of its own remaining burst time and convey its attribute members
* such as its arrival time, name and burst time to other classes
*/

public class Process implements Runnable {

    /*Data members : */


    String name;
    int burst_time;

    /*Runtime function run(), where the thread sleeps for 1 second
    * and decrements its burst_time by 1. */

    @Override
    public void run()
    {

        while(true){
            try {
                Thread.sleep(1000);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            burst_time--;
        }
    }


    /*Process constructor, name is given by incrementing a static value*/
    public Process( int burst_time)
    {
        this.burst_time = burst_time;
        this.name = String.valueOf((Thread.currentThread().getId()));
    }

}
