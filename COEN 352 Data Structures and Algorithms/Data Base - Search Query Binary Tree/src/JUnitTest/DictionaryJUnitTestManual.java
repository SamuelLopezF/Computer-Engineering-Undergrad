package JUnitTest;

import static org.junit.jupiter.api.Assertions.*;

import Master.*;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;

public class DictionaryJUnitTestManual {

    private static ADTDictionary<String, Inventory> dict;



    @BeforeAll
    public static void setUp() {
        dict = new DLDictionary<String, Inventory>(100);
        //read_from_text_file_database(dict);
    }

    @Test
    public void testClear() {
        dict.clear();
        assertEquals(0, dict.size(), "clear failed, size is non-zero");
    }

    @Test
    public void testInsert() {
        dict.clear();
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
        assertEquals(3, dict.size(), "insert failed, size is not as expected");
    }

    @Test
    public void testRemove() {
        dict.clear();
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
        Inventory deleted_item = dict.remove("purple");
        assertEquals("test_3", deleted_item.getName());
    }

    @Test
    public void testRemoveAny(){
        dict.clear();
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
        assertEquals("test_1", dict.removeAny().getName());
    }

    @Test
    public void testFind()
    {
        dict.clear();
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
        assertEquals("test_2", dict.find("blue").getName());
    }

    @Test
    public void testSize()
    {
        dict.clear();
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
        assertEquals("test_2", dict.find("blue").getName());
    }

    @Test
    public void testTotalValue()
    {
        dict.insert("red", new Inventory("test_1", 10, 9.9f));
        dict.insert("blue", new Inventory("test_2", 1, 100));
        dict.insert("purple", new Inventory("test_3", 4, 4.0f));
    }


public static void read_from_text_file_database(ADTDictionary test_dict) {
        try {
        	String file_name = "C:\\Users\\samue\\Desktop\\A1_352\\src\\warehouse_data";
            BufferedReader buff_reader = new BufferedReader(new FileReader(file_name));
            WarehouseManager container = new WarehouseManager(test_dict);
            String line;
            while ((line = buff_reader.readLine()) != null) {
//                testing_dictionary.insert(key, info);
                String[] words = line.split("\\s+");
                Inventory record = new Inventory(words);
                container.insert(record.getKey(), record);

            }
        } catch (IOException e) {
            System.out.println("could not read file");
        }
    }
}
