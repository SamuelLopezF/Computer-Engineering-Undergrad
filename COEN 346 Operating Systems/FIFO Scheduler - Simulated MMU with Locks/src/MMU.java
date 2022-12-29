import java.io.*;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Scanner;

public class MMU implements Runnable{

    private final LinkedList<String[]> commands;
    private final Page[] pages;
    private final LinkedList<Page> disk_space;



    public MMU(int page_num) throws FileNotFoundException {

        this.pages = new Page[page_num];
        this.commands = new LinkedList<>();
        this.disk_space = new LinkedList<>();



        for (int i = 0; i < pages.length; i++) {
            pages[i] = new Page();
        }
        this.initCommands();



    }

    synchronized void EXECUTE_NEXT_COMMAND() throws InterruptedException, IOException {

        String[] next_command = commands.removeFirst();
        commands.addLast(next_command);
        System.out.println(Arrays.toString(next_command));

        if(next_command[0].charAt(0) == 'S')
        {
            this.STORE(next_command[0], Integer.parseInt(next_command[1]));

        }else if(next_command[0].charAt(0) == 'L') {

            int result = this.LOOKUP(next_command[1]);
            if(result != -1)
            {
                System.out.println(" LOOKUP : no result ");
            }

        }else if(next_command[0].charAt(0) == 'R') {

            this.RELEASE(next_command[1]);

        }else{

            System.out.println("Unrecognized command ");
        }

    }


    synchronized void STORE (String variable_id, int value) throws InterruptedException, IOException {

        boolean stored_in_page = false;

        for(int i = 0 ; i < pages.length ; i ++)
        {
            pages[i].page_access.acquire();
            if(pages[i].value != Integer.MAX_VALUE)
            {

                //here we acquire a page's semaphore and set its variables;

                stored_in_page = true;
                pages[i].variable_id = variable_id;
                pages[i].value = value;

            }
            pages[i].page_access.release();
        }

        if(!stored_in_page)
        {
            disk_space.add(new Page(variable_id, value));
        }


    }



    synchronized void RELEASE (String variable_id) throws InterruptedException, IOException {


        int answer = this.LOOKUP(variable_id);
        if(answer == -1)
        {
            //we know this variable id does not exist in our memory
            System.out.println("Could not erase, did not find");
        }else{
            for(int i = 0; i < pages.length; i ++){

                    pages[i].page_access.acquire();

                // We found the right page to release
                // We reset the value and id of the page, and release the semaphore
                if(variable_id.equalsIgnoreCase(pages[i].variable_id))
                {
                    System.out.print("RELEASING " + variable_id);
                    pages[i].variable_id = "";
                    pages[i].value = Integer.MAX_VALUE;
                    pages[i].page_access.release();

                }
            }
        }
    }



    synchronized int LOOKUP (String variable_id) throws InterruptedException, IOException {


        boolean in_pages = false;
        int position = -1;
        for (int i = 0; i < pages.length; i++) {
            if(pages[i].variable_id.equals(variable_id)){
                System.out.print("\t\tLOOKUP : " + pages[i]);
                pages[i].last_access = Clock.clock_tick;
                in_pages = true;
                position = i;
            }
        }

        if(!in_pages)
        {
            for(int i = 0 ; i < disk_space.size(); i ++)
            {
                if(variable_id.equalsIgnoreCase(disk_space.get(i).variable_id))
                {
                    this.SWAP(disk_space.remove(i));
                }
            }


        }




        return position;
    }


    synchronized void SWAP (Page page) throws InterruptedException, IOException {
        int last_access_dummy = Integer.MAX_VALUE;
        int position = -1;



        // we find the position of the least recently accessed page
        for (int i = 0; i < pages.length; i++) {
            if(pages[i].last_access  < last_access_dummy)
            {
                position = i;
                last_access_dummy = pages[i].last_access;
            }
        }



        pages[position].page_access.acquire();
        System.out.println("Swapping for page "  + position);


        //Saving Page information :
        int temp_value = pages[position].value;
        String temp_variable_id = pages[position].variable_id;

        disk_space.addLast(pages[position]);
        pages[position] = page;

        pages[position].page_access.release();

    }








    public void initCommands() throws FileNotFoundException {
        // doo magic

        File myFile = new File("C:\\Users\\samue\\Documents\\A3_coen346_proto4\\src\\commands.txt");
        Scanner reader = new Scanner(myFile);

        while(reader.hasNextLine())
        {
            String line = reader.nextLine();
            String[] splitted_line = line.split(" ");
            if(splitted_line[0].charAt(0) == 'S')
            {
                this.commands.add(splitted_line);
            }else if(splitted_line[0].charAt(0) =='R'){
                this.commands.add(splitted_line);
            }else{
                this.commands.add(splitted_line);
            }
        }
    }

    public void printPages()
    {
        System.out.println("======== Pages =========");
        for (int i = 0; i < pages.length; i++) {

            System.out.println(pages[i]);
        }
        System.out.println("========================");
    }

    @Override
    public void run() {
        while(true);
    }

}
