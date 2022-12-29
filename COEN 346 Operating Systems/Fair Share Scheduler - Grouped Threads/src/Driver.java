import java.io.File;
import java.io.IOException;
import java.util.Scanner;
import java.util.concurrent.ExecutionException;
import java.io.BufferedWriter;
import java.io.FileWriter;


/*Main Driver class for the project. This contains the required functions and
* object declaration to read the .txt files and write to output files. Mainly
* consists of extracting information from the text file and retriving the right
* parameters to initialize each User and its processes. It also starts the
* Scheduler Thread. */
public class Driver {

    public static void main(String[] args) throws ExecutionException, InterruptedException, IOException {

        int time_quantum = 0;
        Scheduler fair = new Scheduler(0);
        File myFile = new File("C:\\Users\\samue\\OneDrive\\Bureau\\COEN346_lab1_Ravjotdeep_Kaur_Kevin_Phan_Samuel_Lopez-Ferrada1\\A2_COEN346_proto11\\src\\input.txt");
        Scanner reader = new Scanner(myFile);

        final String of_name = "output.txt";

        try{
            String line = reader.nextLine();
            line.trim();
            time_quantum = Integer.valueOf(line);

        }catch(Exception e){
            System.out.println("could not get time quantum");
        }

        while(reader.hasNextLine())
        {

            String line = reader.nextLine();
            char name = line.charAt(0);
            User temp_user = new User(name);
            int nb_processes = Character.getNumericValue(line.charAt(2));

            for (int i = 0; i < nb_processes; i++) {
                line = reader.nextLine();
                int burst_time = Character.getNumericValue(line.charAt(2));
                int arrival_time = Character.getNumericValue(line.charAt(0));
                ProcessNode node = new ProcessNode(arrival_time, burst_time, name);
                temp_user.addProcessNode(node);
            }
            fair.addUser(temp_user);
        }
        fair.time_quantum = time_quantum;

        fair.start();
        fair.join();
        writeFile(of_name, Scheduler.getOutputData());


    }
    // writing data
    private static void writeFile(String of_name, String data) {

        System.out.println("Writing data");
        // writing result
        try {
            // Assume default encoding.
            FileWriter fileWriter =
                    new FileWriter(of_name);

            // Always wrap FileWriter in BufferedWriter.
            BufferedWriter bufferedWriter =
                    new BufferedWriter(fileWriter);

            bufferedWriter.write(data);

            // Always close files
            bufferedWriter.close();
            fileWriter.close();
        }catch (Exception e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
    }


}
