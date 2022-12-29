import java.util.concurrent.Semaphore;

public class Page {

    int value;
    String variable_id;
    Semaphore page_access;
    int last_access;



    public Page()
    {
        value = Integer.MAX_VALUE;
        this.variable_id = "";
        page_access = new Semaphore(1);
        int last_access = Clock.clock_tick;
    }

    public Page(String variable_id, int value) {
        this.variable_id = variable_id;
        this.value = value;
        this.last_access = Clock.clock_tick;
    }

    @Override
    public String toString()
    {
        return "ID : " + variable_id + " \tVALUE : " + value;
    }

}
