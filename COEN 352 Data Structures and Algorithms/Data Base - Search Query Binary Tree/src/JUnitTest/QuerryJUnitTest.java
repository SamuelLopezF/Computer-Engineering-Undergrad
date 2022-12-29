package JUnitTest;

import Master.ADTDictionary;
import Master.DLDictionary;
import Master.Inventory;
import Master.KVpair;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;

import java.util.Arrays;

import static org.junit.jupiter.api.Assertions.assertEquals;

public class QuerryJUnitTest {
    private static ADTDictionary<String, Inventory> dict;
    private static KVpair[] positions;

    @BeforeAll
    public static void setUp() {
        dict = new DLDictionary<>(100);
        dict.clear();
        dict.insert("apple", new Inventory("test_0", 222, 999.9f));         //most expensive
        dict.insert("orange", new Inventory("test_1", 333, 111.1f));
        dict.insert("kiwi", new Inventory("test_2", 665, 444.4f));
        dict.insert("pineapple", new Inventory("test_3", 111, 777.7f));     // least quantity
        dict.insert("watermelon", new Inventory("test_4", 888, 222.2f));
        dict.insert("mango", new Inventory("test_5", 777, 66.6f));
        dict.insert("grape", new Inventory("test_6", 1001, 33.33f));        // most quantity
        dict.insert("grapefruit", new Inventory("test_7", 555, 888.8f));
        dict.insert("blueberry", new Inventory("test_8", 444, 1.0f));      //cheapest ,
        dict.insert("strawberry", new Inventory("test_9", 999, 222.2f));
    }

    @Test
    public void Query()
    {
        dict.moveToStart();
        int last_position = dict.size() -1;

        positions = dict.createIndex("Quantity");


        /* In this test we know that the item we have the least quantity of is located
        int position 0 and if our array was properly
        sorted then it should be located in the first position.
         */
        assertEquals(111, positions[0].getValue());

        /* Here we expect that the element we have the most amount of is located at the end of our
        list if it was sorted properly. In the above
         */

        assertEquals(1001, positions[last_position].getValue());


        positions = dict.createIndex("UnitPrice");


        /* In this test we know that the cheapest item is worth 1.0f and if our array was properly
        sorted then it should be located in the first position.
         */

        assertEquals(1.0f, positions[0].getValue());

        /* In this part of the code we expect the most expensive  value to be located at the end of the sorted
            KVpair list. The most expensive element is the apples for 999.9$.
            Must be delicious apples for that price.

            first we get the position at the end of the list. This position is where in the original dictionary the
            apples are located. So it contains a int, this int tells us where the element is located.
         */
            int position_of_last_element_in_original_database = positions[last_position].getPosition();


            /* Next we move the pointer of the dictionary to the position of where the apples are located
             */
            dict.moveToPos(position_of_last_element_in_original_database);

            /*Last, we get the name of the apples which is the KEY component of the dictionary.
             */
            String last_item_key = dict.getKey();
        assertEquals("apple", last_item_key);

        /* Here we compare the price of the last item, which should be the most expensive again.
         */
        assertEquals(999.9f, positions[last_position].getValue());
    }


}
