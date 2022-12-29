import java.io.File;
import java.io.FileNotFoundException;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Scanner;
import java.util.concurrent.Semaphore;

public class FIFO implements Runnable{


    volatile static Semaphore CPU_CORES;

    LinkedList<Process> repository = new LinkedList<>();
    static MMU memory_manager;

    static {
        try {
            memory_manager = memoryInit();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }
    }

    public FIFO() throws FileNotFoundException {

        int cpu_cores = readProcessFile();
        CPU_CORES = new Semaphore(cpu_cores, true);

        Thread running_mmu = new Thread(memory_manager);

    }


    public static MMU memoryInit() throws FileNotFoundException {
        File mem_config = new File("C:\\Users\\samue\\Documents\\A3_coen346_proto4\\src\\processes.txt");
        Scanner reader = new Scanner(mem_config);

        int pages = Integer.parseInt(reader.nextLine());
        return new MMU(pages);
    }




    @Override
    public void run() {

        while(true){

            int start = Clock.clock_tick;

            while(start + 1000 >  Clock.clock_tick );

            transferArrivedProcesses();
        }

    }

    public int readProcessFile() throws FileNotFoundException {

        File myFile = new File("C:\\Users\\samue\\Documents\\A3_coen346_proto4\\src\\processes.txt");
        Scanner reader = new Scanner(myFile);

        int cpu_cores = Integer.parseInt(reader.nextLine());
        int number_of_processes = Integer.parseInt(reader.nextLine());

        for (int i = 0; i < number_of_processes; i++) {

            String[] line = reader.nextLine().split(" ");
            System.out.println(Arrays.toString(line));
            int arrival_time = Integer.parseInt(line[0]);
            int burst_time = Integer.parseInt(line[1]);
            this.repository.add(new Process(arrival_time, burst_time, this.memory_manager));

        }

        return cpu_cores;
    }



    public void transferArrivedProcesses() {
        for (int i = 0; i < repository.size(); i++) {
            if(repository.get(i).arrival_time <= Clock.clock_tick)
            {
                System.out.println("Time : " + Clock.clock_tick + " \tARRIVED ->" + repository.get(i));
                Thread dummy =  new Thread (repository.get(i));
                dummy.start();
                repository.remove(i);
            }
        }

    }






}
