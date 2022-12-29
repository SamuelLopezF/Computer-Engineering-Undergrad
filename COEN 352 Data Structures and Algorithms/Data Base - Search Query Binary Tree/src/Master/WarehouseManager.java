package Master;
/**
 * Samuel Lopez-Ferrada
 * Student ID : 40112861
 * Computer Engineering
 * Data Structures and Algorithms 352 -Teacher : Yan Liu
 * Assignment 2
 * 
 * For the program to work properly, the file name must be adjusted to the local path. 
 * Unfortunately there is no way for me to guarantee that the path will be the same on 
 * my machine and the one you will be using. I've tried on multiple IDE’s and in the labs 
 * at university and my results varied.  All the functions still work without the file, 
 * but it will be a empty list. 
 * Please insert the absolute file path, on line 170 and line 260.
 */



import SimpleTree.SimpleTree;
import SimpleTree.SimpleTreeNode;

import javax.script.ScriptEngine;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.Arrays;
import java.util.Scanner;

public class WarehouseManager{


    // Data Members :
    ADTDictionary<String, Inventory> list;
    private float total_warehouse_value;
    ADTDictionary sub_dict;
    SimpleTree my_tree;

    static Scanner keyboard_input = new Scanner(System.in);
    static String input;

    //Constructors :
    public WarehouseManager()
    {
        this.list = null;
        this.total_warehouse_value = 0;
    }

    /**
     * this constructor instantiates a list of Array, LL, DL type
     * with a parameterized form of <String,Inventory>. Value is set
     * to zero since, we have not added any objects yet, the list is empty
     * @param list is a generic type of list, this is built to keep
     *             flexibility in the implementation
     */
    public WarehouseManager(ADTDictionary<String, Inventory> list)
    {
        this.list = list;
        total_warehouse_value = 0;
    }

    //Class Functions :
    public Inventory find()
    {
        //Testing find function :
        System.out.println("\n\n======= Testing FIND function ======");
        System.out.println("Please insert a specific key to find an item (ex: IN0001 to IN0024)");
        input = keyboard_input.next();
        Inventory item_found = list.find(input);
        System.out.println("item found " + item_found);
        return item_found;
    }

    public void insert() {
        //Testing insert
        System.out.println("\n\n======= Testing INSERT function =======");
        System.out.println("Inserting test case, please enter a name");
        String name_of_test_case;
        name_of_test_case = keyboard_input.next();
        System.out.println("Please enter a key for the item");
        String key_of_test_case = keyboard_input.next();
        System.out.println("Enter the amount of units");
        int quantity = keyboard_input.nextInt();
        System.out.println("Enter a price for the item");
        float price = keyboard_input.nextFloat();
        Inventory to_be_added = new Inventory(name_of_test_case, quantity, price);
        int old_size = list.size();
        insert(key_of_test_case, to_be_added);
        System.out.println(this);

        if(old_size < list.size())
        {
            System.out.println("Updated Inventory value  = " + this.get_total_warehouse_value());
        }
    }

    public void insert(String key,Inventory record)
    {
        int old_size = list.size();
        list.insert(key, record);
        if (old_size < list.size()) {
            this.total_warehouse_value += record.getInventory_value();
        }
    }

    public Inventory remove() {
        //Testing remove function :
        System.out.println("\n\n======= Testing REMOVE function =======");
        System.out.println("Please insert a specific key to remove (ex : IN0001 to IN0024)");
        System.out.println("if the key can't be found, it will result in a null return");
        String key = keyboard_input.next();
        Inventory item_deleted = list.remove(key);
        if(item_deleted != null){
            total_warehouse_value -= item_deleted.inventory_value;
            System.out.println("item deleted : " + item_deleted);
            System.out.println(this);
            System.out.println("Updated Inventory value  = " + this.get_total_warehouse_value());

        }else{
            System.out.println("no item found to delete");
        }
        return item_deleted;
    }

    public void removeAny()
    {


        System.out.println("removing any");
        Inventory deleted_item = list.removeAny();
        if (deleted_item != null) {
            System.out.println(this);
        	float old_value = total_warehouse_value;
            total_warehouse_value -= deleted_item.inventory_value;
            System.out.println(total_warehouse_value + " = " + old_value + " - " + deleted_item.inventory_value);
        }else {
        	System.out.println("pointing to null");
        }
    }

    public void clear() {


        list.clear();
        System.out.println(this);
        System.out.println("Database length = " + this.length());
        this.total_warehouse_value = 0;
        System.out.println("Total warehouse value " + total_warehouse_value);

    }

    public String length(){
        return "List size " + list.size();
    }

    public float get_total_warehouse_value() {
        return total_warehouse_value;
    }

    @Override
    public String toString()
    {
        return list.toString();
    }

    public void move_cursor()
    {
        input = "";
        while(!input.equalsIgnoreCase("Q"))
        {
            System.out.println("P - Previous \t N - Next \t Q - Quit ");
            input = keyboard_input.next();
            if (input.equalsIgnoreCase("P")) {
                list.previous();
                System.out.println(list.getCurrent());
            } else if (input.equalsIgnoreCase("N")) {
                list.next();
                System.out.println(list.getCurrent());
            }
        }
    }

    public void start_menu()
    {
        String input = "";
        while(!input.equalsIgnoreCase("Q")) {
            System.out.println("Menu of warehouse manager");
            System.out.println("1 - Find \t\t 2 - Insert \t 3 - Remove \t 4 - Length");
            System.out.println("5 - Total value \t 6 - RemoveAny \t 7 - Clear \t 8 - Move Cursor");
            System.out.println("P - Print warehouse \t Q - MergeSort Query \t B - Tree Query");
            System.out.println("E - Exit");
            input = keyboard_input.next();
            if (input.equalsIgnoreCase("1")) {
                this.find();
            } else if (input.equals("2")) {
                this.insert();
            } else if (input.equals("3")) {
                this.remove();
            } else if (input.equals("4")) {
                System.out.println(this.length());
            } else if (input.equals("5")) {
                System.out.println(this.get_total_warehouse_value());
            } else if (input.equals("6")) {
                this.removeAny();
            } else if (input.equals("7")) {
                //Testing clear function :
                System.out.println("\n\n ======= Testing CLEAR function =======");
                this.clear();
            } else if (input.equals("8")) {
                this.move_cursor();
            } else if (input.equalsIgnoreCase("P")) {
                System.out.println(this);
            } else if (input.equalsIgnoreCase("Q")) {
                System.out.println("Merge sort query");
                System.out.println("Please select attribute \n Q - Quantity \t U - UnitPrice");
                input = keyboard_input.next();
                if (input.equalsIgnoreCase("Q")) {
                    this.query("Quantity");

                } else if (input.equalsIgnoreCase("U")) {
                    this.query("UnitPrice");
                }
                start_menu();
            } else if (input.equalsIgnoreCase("B")) {
                System.out.println("Tree query");
                System.out.println("Please select attribute \n Q - Quantity \t U - UnitPrice");
                input = keyboard_input.next();
                if (input.equalsIgnoreCase("Q")) {
                    BSTQuerry("Quantity");

                } else if (input.equalsIgnoreCase("U")) {
                    BSTQuerry("UnitPrice");
                }
                start_menu();

            }else{
            	System.out.print("system exiting ");
            	System.exit(0);
            }
        }
    }

    // PART TWO //
    public void query(String attribute)
    {
        KVpair[] positions = list.createIndex(attribute);
        for(int i = 0; i < list.size(); i ++)
        {
            list.moveToPos(positions[i].getPosition());
            System.out.print(list.getKey() + " \t " +  positions[i] + " " );
        }
    }

    public void BSTQuerry(String attribute)
    {
        SimpleTreeNode root = list.createIndexBTS(attribute);
        System.out.println();
        System.out.println("Values sorted (inOrder Traversing)");
        root.traverseInOrderValues(root);
        System.out.println();
        System.out.println("POSITIONS");
        root.traverseInOrder(root);

        System.out.println();
    }

    //Start of main :
    public static void main(String[] args){

        //ALDictionary<String, Inventory> array_test = new ALDictionary<>(100);
        //WarehouseManager inventory_records_container = new WarehouseManager(array_test);

        DLDictionary<String,Inventory> dl_test = new DLDictionary<>(100);
        WarehouseManager inventory_records_container = new WarehouseManager(dl_test);



        //Reading from a database text file included in the project named "warehouse_data"
        try {
        	//Note for TA, you might have to change the path file to the full path file for the text to read. 
        	String file_name = "C:\\Users\\samue\\Desktop\\A2_casting\\src\\warehouse_data";
            BufferedReader buff_reader = new BufferedReader(new FileReader(file_name));
            String line;
            while ((line = buff_reader.readLine()) != null) {
                String[] words = line.split("\\s+");
                Inventory record = new Inventory(words);
                inventory_records_container.insert(record.getKey(), record);
            }
            buff_reader.close();
        } catch (IOException e) {
            System.out.println("could not read file!");
        }

        System.out.println("At this point the database has been initialized with the corresponding .txt file");

        //Entering menu :
        inventory_records_container.start_menu();


    }
}
