

/*The ProcessNode class is mostly a container class for the process
* since the process can't know how long it's been attributed  to the cpu,
* the ProcessNode class is used as a node in a linked list of processes
* It also keeps track of who's the owner of this object with a char.*/

public class ProcessNode {

    /*Data members of class*/
    Thread p;
    Character owner;
    int allocated_cpu_time;
    boolean first_iteration;
    int arrival_time;
    int burst_time;

    /*Simple constructor for ProcessNode
    * It takes in an owner (the user's name), and a process*/

    public ProcessNode(int arrival_time, int burst_time, Character user_name)
    {
        this.p = new Thread(new Process(burst_time));
        this.owner = user_name;
        this.allocated_cpu_time = 0;
        p.setDaemon(true);
        this.first_iteration = true;
        this.arrival_time = arrival_time;
        this.burst_time = burst_time;

    }

    /*Simple toString function returning string value of the data members */
    @Override
    public String toString()
    {
        return "User " + owner +  ", Process " + p.getId()  ;
    }


}
