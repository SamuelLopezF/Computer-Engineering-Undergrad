
import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;
import static org.junit.Assert.*;
import static org.junit.jupiter.api.Assertions.assertEquals;

import java.io.*;
import java.util.Arrays;


public class JUnit_test_cases {
    static SimpleGraph G =  new SimpleGraph();


    @BeforeAll
    static void set_up() throws IOException {
        BufferedReader f;
        f = new BufferedReader(new InputStreamReader(new FileInputStream("testfile-concomp.gph")));
        createGraph(f, G);
        G.printMatrix();

    }
    static void createGraph(BufferedReader file, SimpleGraph G) throws IOException
    {
        int edges;
        String[] words;
        words = file.readLine().split(" ");
        words = file.readLine().split(" ");
        System.out.println(Arrays.toString(words));
        edges = Integer.parseInt(words[0]);
        G.Init(edges);
        words = file.readLine().split(" ");
        System.out.println(Arrays.toString(words));
        System.out.println(Arrays.toString(words));
        for(int a = 0 ; a <= 42; a++)
        {
            words = file.readLine().split(" ");
            int i = Integer.parseInt(words[0]);
            int j = Integer.parseInt(words[1]);
            G.setEdge(i, j, 1);
        }
    }

@Test
void test_getPrerequisite()
{
    String[] pre_req_arr = G.getPrerequisites("COEN 421");
    System.out.println(Arrays.toString(pre_req_arr));
    String[] answers= {"SOEN 341", "COEN 320", "COEN 317" };
    assertEquals(Arrays.toString(pre_req_arr), Arrays.toString(answers), "is not equal" );
}

@Test
void test_getPrerequisitePath()
{
    String path = G.getPrerequisitePath("COEN 352");
    System.out.println(path);
    assertEquals(path, "COEN 244 , COEN 243 , MATH 204 , ", "is not equal");

}



}
