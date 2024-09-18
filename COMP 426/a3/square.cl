__kernel void square(__global int* input1,__global int* input2, __global int * output1, __global int * output2 ,int n) {
	
  int i = get_global_id(0);
	
	int left	= i -1;
	int right	= i + 1;
	
	int up_left	=  i - 1001;
	int up		= i -1000;
	int up_right	=  i - 999;
  
	int down_left	= i + 999;
	int down	= i + 1000;
	int down_right	= i + 1001;
  if(((i % 1000) != 0) &&  (i > 1001) && (i < 998999))
  {
          int total = 0;
          
          total += input1[left];
          total += input1[right];
          total += input1[up_left];
          total += input1[up];
          total += input1[up_right];
          total += input1[down_left];
          total += input1[down];
          total += input1[down_right];
          
          if((total / 100) >= 5)
            {
              output1[i] = 1; 
            }
          else
            {
              output1[i] = 0;
            }
          if((total % 10) >= 5)
          {
              output2[i] =  1;
          }
          else
          {
              output2[i] = 0;  
          }    
  }
}
