import java.io.*;
import java.util.*;



public class Main {
    static final int UNVISITED = 0;
    static final int VISITED = 1;


    //Breath first search
    public void BFS(SimpleGraph G, int start) {
        Queue<Integer> Q  = new LinkedList<Integer>();
            Q.add(start);
            G.setMark(start, VISITED);
            while(Q.size() > 0){
                    int v = Q.poll();

            }

    }



    // Create a graph from file
    static void createGraph(BufferedReader file, SimpleGraph G)
            throws IOException
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

    public static void main(String[] args) throws IOException {

        BufferedReader f;
        f = new BufferedReader(new InputStreamReader(new FileInputStream("testfile-concomp.gph")));
        SimpleGraph G =  new SimpleGraph();
        createGraph(f, G);
        G.printMatrix();
        System.out.println("Path");
        System.out.println(G.getPrerequisitePath("COEN 421"));
        System.out.println("Direct PreReq");
        System.out.println(Arrays.toString(G.getPrerequisites("COEN 352")));
	// write your code here
    }
}
