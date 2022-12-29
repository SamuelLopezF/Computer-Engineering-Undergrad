import java.util.Stack;

public class SimpleGraph {
    private int[][] Vertex_Matrix;
    private int Edges;
    private int[] Vertex;

    SimpleGraph()
    {
        this.Vertex_Matrix = null;
        this.Edges = 0;
        this.Vertex = null;
    }

    public void Init(int n )
    {
        Vertex = new int[n];
        Vertex_Matrix = new int[n][n];
        Edges = 0;
    }

    SimpleGraph(int edges)
    {
        this.Vertex_Matrix = new int[edges][edges];
        this.Edges = edges;
        this.Vertex = new int[edges];
    }

    public int[][] getVertex_Matrix() {
        return Vertex_Matrix;
    }

    public void setVertex(int[] vertex) {
        Vertex = vertex;
    }

    public boolean isEdge(int i, int j)
    { return Vertex_Matrix[i][j] != 0; }


    public void setEdge(int i, int j, int wt) {
        assert wt!=0 : "Cannot set weight to 0";
        if (Vertex_Matrix[i][j] == 0) Edges++;
        Vertex_Matrix[i][j] = wt;
    }

    public void delEdge(int i, int j) { // Delete edge (i, j)
        if (Vertex_Matrix[i][j] != 0) {
            Vertex_Matrix[i][j] = 0;
            Edges--;
        }
    }
    // Get and set marks
    public void setMark(int v, int val) { Vertex[v] = val; }
    public int getMark(int v) { return Vertex[v]; }


    public void printMatrix()
    {
        System.out.print("\t\t");
        for(int i = 0 ; i < 34 ; i ++)
        {
            System.out.print("|" + selector2(i) + " ");
        }
        System.out.println();
        for(int i = 0; i < 34; i ++)
        {
            System.out.print(selector(i) + "|");
            for(int j = 0; j < 34; j++)
            {
                if(isEdge(i, j))
                {
                    System.out.print(" X " + " |");
                }else{
                    System.out.print("    |");
                }
            }
            System.out.println();
        }
    }

    public String getPrerequisitePath(String courseCode)
    {
        int course_index = CourseToNumber(courseCode);
        StringBuilder build = new StringBuilder();
        System.out.print(courseCode + ", ");
        if(course_index != -1)
        {
            for( int i =Vertex.length-1 ; i >= 0 ; i --)
            {
                if(Vertex_Matrix[i][course_index] == 1)
                {
                    build.append(selector(i)).append(" , ");
                    course_index = i;
                    i = Vertex.length;
                }
            }
        }else {
            return "course not found";
        }

        return build.toString();
    }


    public String[] getPrerequisites(String courseCode)
    {
        Stack<String> direct_prerequisites = new Stack<>();

        int column_index = CourseToNumber(courseCode);
        for (int i = 0; i < Vertex.length; i++) {
            if(Vertex_Matrix[i][column_index] == 1)
            {
                direct_prerequisites.push(selector(i));
            }
        }

        String[] prereq_string = new String[direct_prerequisites.size()];
        int counter = 0;
        while(!direct_prerequisites.isEmpty())
        {
            prereq_string[counter] = direct_prerequisites.pop();
            counter++;
        }
        return prereq_string;
    }




    public static  String selector(int num)
    {
        return switch (num) {
            case 0 -> "MATH 204";
            case 1 -> "COEN 212";
            case 2 -> "COEN 231";
            case 3 -> "COEN 243";
            case 4 -> "COEN 244";
            case 5 -> "ENGR 290";
            case 6 -> "ENGR 301";
            case 7 -> "COEN 311";
            case 8 -> "ELEC 311";
            case 9 -> "COEN 313";
            case 10 -> "COEN 316";
            case 11 -> "COEN 317";
            case 12 -> "COEN 320";
            case 13 -> "SOEN 341";
            case 14 -> "COEN 346";
            case 15 -> "COEN 352";
            case 16 -> "COEN 366";
            case 17 -> "ELEC 371";
            case 18 -> "ELEC 372";
            case 19 -> "COEN 390";
            case 20 -> "COEN 413";
            case 21 -> "COEN 415";
            case 22 -> "COEN 421";
            case 23 -> "COEN 422";
            case 24 -> "COEN 424";
            case 25 -> "COEN 432";
            case 26 -> "COEN 433";
            case 27 -> "COEN 434";
            case 28 -> "COEN 446";
            case 29 -> "COEN 447";
            case 30 -> "COEN 448";
            case 31 -> "COEN 451";
            case 32 -> "COEN 490";
            case 33 -> "COEN 498";
            default -> "null";
        };

    }


        public static int CourseToNumber(String course_name)
        {
            return switch (course_name) {
                case "COEN 204" -> 0;
                case "COEN 212" -> 1;
                case "COEN 231" -> 2;
                case "COEN 243" -> 3;
                case "COEN 244" -> 4;
                case "ENGR 290" -> 5;
                case "ENGR 301" -> 6;
                case "COEN 311" -> 7;
                case "ELEC 311" -> 8;
                case "COEN 313" -> 9;
                case "COEN 316" -> 10;
                case "COEN 317" -> 11;
                case "COEN 320" -> 12;
                case "SOEN 341" -> 13;
                case "COEN 346" -> 14;
                case "COEN 352" -> 15;
                case "COEN 366" -> 16;
                case "ELEC 371" -> 17;
                case "ELEC 372" -> 18;
                case "COEN 390" -> 19;
                case "COEN 413" -> 20;
                case "COEN 415" -> 21;
                case "COEN 421" -> 22;
                case "COEN 422" -> 23;
                case "COEN 424" -> 24;
                case "COEN 432" -> 25;
                case "COEN 433" -> 26;
                case "COEN 434" -> 27;
                case "COEN 446" -> 28;
                case "COEN 447" -> 29;
                case "COEN 448" -> 30;
                case "COEN 451" -> 31;
                case "COEN 490" -> 32;
                case "COEN 498" -> 33;
                default -> -1;
            };

        }
    public static  String selector2(int num) {
        return switch (num) {
            case 0 -> "204";
            case 1 -> "212";
            case 2 -> "231";
            case 3 -> "243";
            case 4 -> "244";
            case 5 -> "290";
            case 6 -> "301";
            case 7 -> "311";
            case 8 -> "311";
            case 9 -> "313";
            case 10 -> "316";
            case 11 -> "317";
            case 12 -> "320";
            case 13 -> "341";
            case 14 -> "346";
            case 15 -> "352";
            case 16 -> "366";
            case 17 -> "371";
            case 18 -> "372";
            case 19 -> "390";
            case 20 -> "413";
            case 21 -> "415";
            case 22 -> "421";
            case 23 -> "422";
            case 24 -> "424";
            case 25 -> "432";
            case 26 -> "433";
            case 27 -> "434";
            case 28 -> "446";
            case 29 -> "447";
            case 30 -> "448";
            case 31 -> "451";
            case 32 -> "490";
            case 33 -> "498";
            default -> "null";
        };
    }
    }
