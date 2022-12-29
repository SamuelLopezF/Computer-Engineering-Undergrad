import java.util.LinkedList;

/*The User class contains all the processes as a Linked List of ProcessNodes,
* and contains the management function to handle and distribute time to each
* node. The user class is allocated a certain amount of time : given_time_share_of_cpu
*  and distribute the time fairly to each process
*
* This implementation of the Fair Share Scheduler uses two "libraries" of users,
* one that contains all the processes at t=0, and another that contains processes
*  that have arrived, i.e. : processes with arrival time < current time .
* This is further explained in the transferArrivedProcesses() function and the
* Scheduler class*/

public class User {

    /*Data members */

    LinkedList<ProcessNode> p_list;
    Character name;
    int give_time_share_of_cpu;
    int remember_alloc_for_debug;


    /*Constructor for User object, where data members are initialized*/
    public User(Character name)
    {
        this.p_list = new LinkedList<>();
        this.name = name;
        int give_time_share_of_cpu = 0;
    }


    /*This function distributes the allocated time fairly to each process
    * It does so by incrementing each process allocated time by 1.
    *
    * The looping is circular, which allows each process to receive an appropriate aount
    * of time.
    *
    * If all processes are full, meaning that all processes have burst time = alloc time
    * then the function returns the time it didn't use
    *
    * If it runs out of time it returns 0. At the end processes have each been allocated
    * their maximum amount of time.*/
    public int distributeTimeForEachProcess(int carry) {
        int rotating_position = 0;
        int list_size = p_list.size();
        this.give_time_share_of_cpu += carry;
        this.remember_alloc_for_debug = give_time_share_of_cpu;
        while(give_time_share_of_cpu != 0)
        {
            if(checkIfFull())
            {
                return give_time_share_of_cpu;
            }

            rotating_position = rotating_position%list_size;

            ProcessNode current_node = p_list.get(rotating_position);
            if(current_node.burst_time > current_node.allocated_cpu_time)
            {
                current_node.allocated_cpu_time++;
                give_time_share_of_cpu--;
            }
            rotating_position++;
        }
        return 0;
    }


    /*The checkIfFull() function return true if all processes have burst time = alloc time
    * and returns false if any process can use more cpu time*/
    public boolean checkIfFull()
    {
        for(ProcessNode node : p_list)
        {
            if(node.allocated_cpu_time <  node.burst_time)
            {
                return false;
            }
        }

        return true;
    }




    /*The transferArrivedProcesses() is called from one user object and passes
    * processes to another User object. It iterates trough the list and for each
    * processNode checks if it has arrived by comparing the current time with
    * the processes arrival time. It's important to note the processNode
    * is removed from the User calling this function*/
    public void transferArrivedProcesses(User active_users)
    {

        for (int i = 0; i < this.p_list.size(); i++) {

            if(p_list.get(i).arrival_time <= Clock.time)
            {
                active_users.addProcessNode(p_list.remove(i));
                i--;
            }
        }
    }


    /*This function is similar to addProcess() but does not need to create a new
    * processNode, it simply passes a already existing processNode to a User*/
    public void addProcessNode(ProcessNode node)
    {
        p_list.add(node);
    }

    /*The isEmpty function returns true or false if the list of processes belonging
    * to a User object is empty.*/
    public boolean isEmpty()
    {
        return p_list.isEmpty();
    }

    /*The print function is mostly used for debugging purposes and prints out the
    * data members of the processNode object and its corresponding process. */
    public void print()
    {
        System.out.println("\t============ " + this.name +" ============   Group Alloc "  + remember_alloc_for_debug + " Carry out : " + give_time_share_of_cpu);
        for(ProcessNode node : p_list)
        {
            System.out.println(node.toString());
        }
    }


}
