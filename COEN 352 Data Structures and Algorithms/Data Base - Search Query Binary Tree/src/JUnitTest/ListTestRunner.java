package JUnitTest;


public class ListTestRunner {
   
	
	public static void main(String[] args) {
	   
	   ListTestRunner.runManualTest();
	   
	   //JUnitTest.ListTestRunner.runJUnit5();
	   
   }
   
   public static void runManualTest() {
	   ListJUnitTest t = new ListJUnitTest();
	   ListJUnitTest.setUp();
	   t.testAppend();
	   t.testFind();
	   t.testListOfObjects();
	   t.testNext();
	   t.testRemove();
	   t.testNext();
   }
   

}