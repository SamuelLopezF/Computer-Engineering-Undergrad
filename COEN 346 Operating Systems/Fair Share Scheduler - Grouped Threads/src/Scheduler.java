
import java.io.*;
import java.util.LinkedList;



/*The Scheduler class contains the functions that allow distribution of time to users,
* manages processes and users, check for process arrival and handles process cpu and
* clock runtime function. This class extends the Thread class since its used as a
* runtime thread ran in parallel with the Clock
*
* Two lists of users are kept, repository is initialized before the scheduler starts and
* contains all the processes of every user that need to be run
* The second contains the active version of those users and removes processes that have
* arrived from the repository, slowing emptying the repository as it runs */
public class Scheduler extends Thread {

    /*Data members for Scheduler object*/
    LinkedList<User> repository;
    LinkedList<User> active_users;
    int active_users_with_running_processes;
    int time_quantum;

    private static String outputData = "";




    /*The runtime function below starts a new clock thread, starts a while loop to
    * begin the scheduling of the users and their processes :
    *
    * 1-  checks if new processes have arrived,
    * 2-  updates how many users are active,
    * 3-  checks if it has any processes to run, if none then it waits a second and repeats the above steps
    * 4-  sets each User's allocated time
    * 5-  each user distributes time to each of their processes passing on unused time to the next user
    * 6-  runs every process for it allocated cpu time.
    * 7-  removes empty users either from repository or active users list
    * 8-  checks its exit condition to know if it's done all processes.
    * */
    @Override
    public void run()
    {

       Thread clk = new Thread(new Clock());
       clk.start();


        do {


            checkForNewProcesses();
            updateSizeOfActiveUsers();
            if(!repository.isEmpty() && active_users_with_running_processes == 0)
            {
                System.out.println("\t NO OPERATION ");
                try {
                    sleep(1000);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
                continue;
            }
            setTimeQuantumForEachUser(time_quantum);
            distributeTimeForEachProcessForEachUser();
            try {
                runUserProcesses();
            } catch (IOException | InterruptedException e) {
                e.printStackTrace();
            }
            removeEmptyUsers();
        } while (!active_users.isEmpty() || !repository.isEmpty());

        clk.stop();
        System.out.println("Stopping clock");
        System.out.println("All processes completed");
    }




    /*The Scheduler constructor takes in a time quantum  and initializes its data members */
    public Scheduler(int time_quantum) throws IOException {
        repository = new LinkedList<>();
        active_users = new LinkedList<>();
        this.time_quantum = time_quantum;
        active_users_with_running_processes = 0;
    }


    // getter
    public static String getOutputData() {return outputData;}



    /*The distributeTimeForEachProcessForEachUser() does as it's title says, it distributes
    * time for each process of each of the active users, mainly trough the user time distribution
    * function explained in the User class.
    *
    * The carry contains any time that a User object did not need for it's processes and passes it on
    * to the next user, this avoids the cpu being idle when a user doesn't exhaust its ressources */

    public void distributeTimeForEachProcessForEachUser()
    {

        int carry = 0;
        for (int i = 0; i < active_users.size(); i++)
        {
            carry = active_users.get(i).distributeTimeForEachProcess(carry);
//            printActiveUsers();
        }


    }


    public void setTimeQuantumForEachUser(int time_quantum)
    /*The setTimeQuantumForEachUser() function distributes time to each user currently having
     * process arrived and in need of cpu time. */
    {
        int share_for_each_user =  time_quantum / active_users_with_running_processes;
        int remainder = time_quantum % active_users_with_running_processes;
        for(int i = 0 ; i < active_users.size(); i ++)
        {
            if(active_users.get(i).p_list.size() > 0)
            {
                if(remainder > 0 )
                {
                    active_users.get(i).give_time_share_of_cpu = share_for_each_user + 1;
                    remainder --;
                }else {
                    active_users.get(i).give_time_share_of_cpu = share_for_each_user;
                }
            }

        }
    }



    /*The runUserProcesses() takes care of iterating trough each User's process list, and running
    * each process according to its allocated cpu time. It prints out wether the process is starting
    * resuming or finishing execution depending on its arrival time and burst time.
    *
    *This function also removes any process with a burst time of 0, as it means it's finished
    * execution, and also ignores starving processes that have had 0 time allocated to them but
    * are still active*/
    public void runUserProcesses() throws IOException, InterruptedException {
        for(User user: active_users)
        {
/*            System.out.println();*/
            for(ProcessNode node: user.p_list)
            {
                //Ignores a process with no time allocated and continues iteration to next process
                if(node.allocated_cpu_time == 0)
                {
                    continue;
                }
                if(node.first_iteration)
                {
                    System.out.println("Time " + Clock.time + ", " + node +  ", Starting ");
                    outputData += String.format("Time %d, %s, Started", Clock.time, node) + "\r\n";

                    node.first_iteration = false;
                    node.p.start();
                    node.burst_time = node.burst_time - node.allocated_cpu_time;
                    Thread.sleep(node.allocated_cpu_time *1000);
                    node.p.stop();

                }else{
                    node.p.run();
                    System.out.println("Time " + Clock.time + ", " + node +  ", Resuming ");
                    outputData += String.format("Time %d, %s, Resuming", Clock.time, node) + "\r\n";

                    Thread.sleep(node.allocated_cpu_time *1000);
                    node.burst_time = node.burst_time - node.allocated_cpu_time;
                    node.p.stop();
                }

                if(node.burst_time != 0 )
                {
                    node.p.stop();
                    System.out.println("Time " + Clock.time + ", " + node +  ", Pausing ");
                    outputData += String.format("Time %d, %s, Paused", Clock.time, node) + "\r\n";
                }else{
                    node.p.interrupt();
                    System.out.println("Time " + Clock.time + ", " + node +  ", Finished ");
                    outputData += String.format("Time %d, %s, Finished", Clock.time, node) + "\r\n";
                }

                node.allocated_cpu_time = 0;
            }

            user.p_list.removeIf(ProcessNode -> ProcessNode.burst_time == 0);
        }

    }





    /*AddUser function adds a user to the repository and add a empty copy of that user
    * to the active user list, for later use to receive processes that have arrived. */
    public void addUser(User u)
    {
        repository.add(u);
        active_users.add(new User(u.name));
    }


    /*The checkForNewProcesses() uses the transferArrivedProcesses for each user*/
    public void checkForNewProcesses()
    {
        for (int i = 0; i < repository.size(); i++) {
            repository.get(i).transferArrivedProcesses(active_users.get(i));
        }
    }


    /*printRepo() function prints out the library of processes for debug purposes mainly*/
    public void printRepo()
    {
        if(repository.size() == 0 )
        {
//            System.out.println("Empty repo");
        }else {
            for (User user : repository) {
                user.print();
            }
        }
    }

    public void printActiveUsers()
    {
        for(User user : active_users)
        {
            user.print();
        }
    }

    /*removeEmptyUsers() takes care of first removing any user in the repository library
    * if their list of processes is empty. This means that the user no longer has processes
    * that have not arrived yet, therefore we have acknowledged all its processes and can be removed
    *
    * If the repository is empty, meaning that all processes for all users have arrived, then we
    * can remove an empty active user since we know there a no new processes coming*/
    public void removeEmptyUsers()
    {
        repository.removeIf(User::isEmpty);
        if (repository.isEmpty()) {
            active_users.removeIf(User::isEmpty);
        }
    }


    /*This function takes care of knowing how many users currently have processes ready and needing
    * the cpu time. Since we have a copy of every user in the active_users list, some might be waiting
    * for processes to arrive but are empty. This information is used ot know how many users take
    * a share of the cpu. */
    public void updateSizeOfActiveUsers()
    {
        active_users_with_running_processes = 0;
        for(User user : active_users)
        {
            if(user.p_list.size() > 0 )
            {
                active_users_with_running_processes++;
            }
        }
    }

}
