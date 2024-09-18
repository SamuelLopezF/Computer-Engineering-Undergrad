#define PROGRAM_FILE "square.cl"
#define KERNEL_FUNC "square"

#include "defs.h"
#include <math.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

#include <CL/cl.h>

#include "GL/glew.h"
#include <GL/freeglut_std.h>
#include <GLFW/glfw3.h>
#include <bits/types/clock_t.h>
#include <chrono>
// #include <cstdio>
#include <cstdlib>
#include <ctime>
#include <iostream>
#include <pthread.h>
#include <random>
#include <stdarg.h>
#include <unistd.h>
#include <utility>

#include <math.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
// NOTE: predefined macros :
#define WIDTH 1000
#define HEIGHT 1000
#define HEALTHY 0
#define CANCER 100
#define MEDICINE 2
#define PROPAGATION_FACTOR 6
// NOTE:  OpenCL structures
cl_device_id device;
cl_context context;
cl_program program;
cl_kernel kernel;
cl_command_queue queue;
cl_int i, err;
long long int ARRAY_SIZE = 1000000; // size of arrays
size_t local_size, global_size;
// NOTE:  Data and buffers
//  Host input and output vectors
int *host_cancer_data, *host_medicine_data, *host_cancer_data_output, *host_medicine_data_output;
// Device input and output buffers
cl_mem device_cancer_data_in, device_medicine_data_in, device_cancer_data_out, device_medicine_data_out;

// NOTE: SIMULAITON VARIABLES
struct Cell {
  bool green = true;
  bool red = false;
  bool modified = false;
  int status = 4;
  int xDirection = 0;
  int yDirection = 0;
};

Cell cell_array[1000][1000];

//.exe input parameters
bool COUNT = 0;
bool SPEED = 1;
bool RANDOM = 1;
bool MANUAL = 0;

pthread_t threads[8];
int totalMedicineCells = 0;
int totalCancerCells = 0;
int totalHealthyCells = 0;

float data[WIDTH][HEIGHT][3];
int th_count = 4;

std::uniform_int_distribution<> distrX(0, WIDTH - 1);  // define the range
std::uniform_int_distribution<> distrY(0, HEIGHT - 1); // define the range

// NOTE:  Initialize data
//  Size, in bytes, of each vector
size_t bytes = ARRAY_SIZE * sizeof(int);

// NOTE: OPENCL ENV DEV HOST FUNCTIONS

cl_device_id create_device() {

  cl_platform_id platform;
  cl_device_id dev;
  int err;

  /* Identify a platform */
  err = clGetPlatformIDs(1, &platform, NULL);
  if (err < 0) {
    perror("Couldn't identify a platform");
    exit(1);
  }

  // Access a device
  // GPU
  err = clGetDeviceIDs(platform, CL_DEVICE_TYPE_GPU, 1, &dev, NULL);
  if (err == CL_DEVICE_NOT_FOUND) {
    // CPU
    err = clGetDeviceIDs(platform, CL_DEVICE_TYPE_CPU, 1, &dev, NULL);
  }
  if (err < 0) {
    perror("Couldn't access any devices");
    exit(1);
  }

  return dev;
}

/* Create program from a file and compile it */
cl_program build_program(cl_context ctx, cl_device_id dev, const char *filename) {

  cl_program program;
  FILE *program_handle;
  char *program_buffer, *program_log;
  size_t program_size, log_size;
  int err;

  /* Read program file and place content into buffer */
  program_handle = fopen(filename, "r");
  if (program_handle == NULL) {
    perror("Couldn't find the program file");
    exit(1);
  }
  fseek(program_handle, 0, SEEK_END);
  program_size = ftell(program_handle);
  rewind(program_handle);
  program_buffer = (char *)malloc(program_size + 1);
  program_buffer[program_size] = '\0';
  fread(program_buffer, sizeof(char), program_size, program_handle);
  fclose(program_handle);

  program = clCreateProgramWithSource(ctx, 1, (const char **)&program_buffer, &program_size, &err);
  if (err < 0) {
    perror("Couldn't create the program");
    exit(1);
  }
  free(program_buffer);

  err = clBuildProgram(program, 0, NULL, NULL, NULL, NULL);
  if (err < 0) {

    /* Find size of log and print to std output */
    clGetProgramBuildInfo(program, dev, CL_PROGRAM_BUILD_LOG, 0, NULL, &log_size);
    program_log = (char *)malloc(log_size + 1);
    program_log[log_size] = '\0';
    clGetProgramBuildInfo(program, dev, CL_PROGRAM_BUILD_LOG, log_size + 1, program_log, NULL);
    printf("%s\n", program_log);
    free(program_log);
    exit(1);
  }

  return program;
}
// NOTE: SIMULATION FUNCTIONS :
void checkNeighbhours() {
  for (int i = 0; i < ARRAY_SIZE; i++) {
    host_cancer_data[i] = cell_array[i / 1000][i % 1000].status;
    host_medicine_data[i] = cell_array[i / 1000][i % 1000].status;
  }

  err = clEnqueueWriteBuffer(queue, device_cancer_data_in, CL_TRUE, 0, bytes, host_cancer_data, 0, NULL, NULL);
  err = clEnqueueWriteBuffer(queue, device_medicine_data_in, CL_TRUE, 0, bytes, host_medicine_data, 0, NULL, NULL);

  clEnqueueReadBuffer(queue, device_cancer_data_out, CL_TRUE, 0, bytes, host_cancer_data_output, 0, NULL, NULL);     // <=====GET OUTPUT
  clEnqueueReadBuffer(queue, device_medicine_data_out, CL_TRUE, 0, bytes, host_medicine_data_output, 0, NULL, NULL); // <=====GET OUTPUT

  err = clEnqueueNDRangeKernel(queue, kernel, 1, NULL, &global_size, &local_size, 0, NULL, NULL);
  clFinish(queue);
  for (i = 0; i < ARRAY_SIZE; i++) {
    //   if(host_medicine_data_output[i] ==1 || host_cancer_data_output[i] ==1 )
    // printf ("%i-%i", host_cancer_data_output[i], host_medicine_data_output[i]);
  }
}

// data, 0, nullptr, nullptr)
//  Argument containing bounds for computation function
struct computation_bounds {
  int xStart;
  int xEnd;
  int yStart;
  int yEnd;
};

// Function to validate the next status of a cell. Each
// neihgbour state is compared to the input state. It
// returns true or false depending if the positive
// results is above PROPAGATION_FACTOR

// Function that moves a cell in it's contained
// direction.
void moveMedicine(int x, int y) {

  int directionX = cell_array[x][y].xDirection;
  int directionY = cell_array[x][y].yDirection;
  int neighbourX = x + directionX;
  int neighbourY = y + directionY;

  if (neighbourX >= WIDTH || neighbourX < 0)
    return;
  if (neighbourY >= HEIGHT || neighbourY < 0)
    return;

  if (cell_array[neighbourX][neighbourY].green && !cell_array[neighbourX][neighbourY].red) {
    // Cell is already green from medicine and just
    // need to turn off red.
    cell_array[x][y].red = 0;

    // Neighbhour is already green to accept a medicine
    // moving in as yellowpro just turn on red to make
    // yellow.
    cell_array[neighbourX][neighbourY].red = 1;
    cell_array[neighbourX][neighbourY].xDirection = directionX;
    cell_array[neighbourX][neighbourY].yDirection = directionY;
  }
}

// Self explanatory function that takes care of
// clearing flags
void clearModifyFlags(int xStart, int xEnd, int yStart, int yEnd) {
  for (int x = xStart; x < xEnd; x++) {
    for (int y = yStart; y < yEnd; y++) {
      cell_array[x][y].modified = 0;
    }
  }
}

// Function that is the start iterates over each cell
// and verifies if it should change using the array procesed by the gpu
void compute_cell_change(int xStart, int xEnd, int yStart, int yEnd) {
  for (int x = xStart; x < xEnd; x++) {
    for (int y = yStart; y < yEnd; y++) {
      if (x == 999)
        // continue;
        if (y == 999)
          continue;
      if (!cell_array[x][y].red && !cell_array[x][y].modified && (host_cancer_data_output[(x * 1000) + (y)] == 1)) {
        cell_array[x][y].status = CANCER;
        cell_array[x][y].red = 1;
        cell_array[x][y].green = 0;
        cell_array[x][y].modified = 1;
        totalCancerCells++;
      }

      else if (!cell_array[x][y].green && cell_array[x][y].red && !cell_array[x][y].modified && (host_medicine_data_output[(x * 1000) + (y)] == 1)) {
        for (int i = -1; i <= 1; i++) {
          for (int j = -1; j <= 1; j++) {
            cell_array[x + i][y + j].status = HEALTHY;
            cell_array[x + i][y + j].red = 0;
            cell_array[x + i][y + j].green = 1;
            cell_array[x + i][y + j].modified = 1;
            totalHealthyCells++;
            totalCancerCells--;
          }
        }
        totalMedicineCells--;
      }
      if (!cell_array[x][y].modified && cell_array[x][y].green && cell_array[x][y].red) {
        moveMedicine(x, y);
      }
    }
  }
  clearModifyFlags(xStart, xEnd, yStart, yEnd);
}

// Computation is mostly a wrapper function for the
// compute cell change function. It also contains the
// code for pushing medicine manually or randomly.

clock_t manual_input_start;
clock_t manual_input_end;

void *computation_function(void *args) {

  computation_bounds *bounds = (struct computation_bounds *)args;

  compute_cell_change(bounds->xStart, bounds->xEnd, bounds->yStart, bounds->yEnd);

  if (RANDOM) {
    std::random_device rd;  // obtain a random number from hardware
    std::mt19937 gen(rd()); // seed the generator
    int ranX = distrX(gen);
    int ranY = distrY(gen);

    for (int x = -10; x <= 10; x++) {

      if (x + ranX >= WIDTH || x + ranX < 0)
        continue;

      for (int y = -10; y <= 10; y++) {

        if (y + ranY >= HEIGHT || y + ranY < 0)
          continue;
        if (x == 0 || y == 0)
          continue;
        cell_array[x + ranX][y + ranY].status = MEDICINE;
        cell_array[x + ranX][y + ranY].green = 1;
        cell_array[x + ranX][y + ranY].red = 1;
        cell_array[x + ranX][y + ranY].modified = 1;
        cell_array[x + ranX][y + ranY].xDirection = x / abs(x);
        cell_array[x + ranX][y + ranY].yDirection = y / abs(y);
        totalMedicineCells++;
      }
    }
  }
  return NULL;
}

float average = 0;
int clk = 0;
// Control function takes care of generating the
// computation threads and takes care of the timer to
// display the computation time.
void *control_function(void *args) {
  void **status;

  computation_bounds bounds[16];
  int limit = 250;
  clock_t start = clock();

  for (int i = 0; i < th_count; i++) {

    bounds[i].xStart = (i * limit);
    bounds[i].xEnd = (i * limit) + limit;
    bounds[i].yStart = 0;
    bounds[i].yEnd = 1000;
    pthread_create(&threads[i], NULL, computation_function, &bounds[i]);
  }

  for (int i = 0; i < th_count; i++)
    pthread_join(threads[i], status);

  if (clk > 200) {
    exit(0);
  }
  if (SPEED) {
    clock_t total = clock() - start;
    average += (float)total / CLOCKS_PER_SEC;
    printf(" EXEC TIME %f \t AVERAGE %f  \n", (float)total / CLOCKS_PER_SEC, (float)average / clk);
  }
  return NULL;
}

bool once = true;
void display() {

  while (1) {

    checkNeighbhours();

    for (size_t y = 0; y < HEIGHT; y += 1) {
      for (size_t x = 0; x < WIDTH; x += 1) {
        data[x][y][0] = (float)cell_array[x][y].red;
        data[x][y][1] = (float)cell_array[x][y].green;
        data[x][y][2] = (float)0;
      }
    }

    glDrawPixels(WIDTH, HEIGHT, GL_RGB, GL_FLOAT, data);
    glutSwapBuffers();
    void **thread_status;
    pthread_t test_thread;
    pthread_create(&test_thread, NULL, control_function, NULL);
    pthread_join(test_thread, thread_status);
    clk++;

    if (clk > 10000)
      exit(0);

    if (COUNT) {
      printf("MED :\t %u", totalMedicineCells);
      printf("\tHLTY:\t %u", totalHealthyCells);
      printf("\tCANCER:\t %u \n", totalCancerCells);
    }

    if (once)
      manual_input_start = clock();
    once = false;
  }
}

void initCancerCell() {

  std::random_device rd;  // obtain a random number from hardware
  std::mt19937 gen(rd()); // seed the generator
  // generate cancer cells randomnly for 25% of the map
  for (int i = 0; i < 400000; i++) {

    int ranX = distrX(gen);
    int ranY = distrY(gen);

    cell_array[ranX][ranY].red = 1;
    cell_array[ranX][ranY].green = 0;
    cell_array[ranX][ranY].status = CANCER;
    totalCancerCells++;
    totalHealthyCells--;
  }
  clearModifyFlags(0, 1000, 0, 1000);
  for (size_t y = 0; y < HEIGHT; y += 1) {
    for (size_t x = 0; x < WIDTH; x += 1) {
      data[x][y][0] = (float)cell_array[x][y].red;
      data[x][y][1] = (float)cell_array[x][y].green;
      data[x][y][2] = (float)0;
    }
  }
}
int main(int argc, char *argv[]) {

  // Allocate host arrays
  host_cancer_data = (int *)malloc(bytes);
  host_medicine_data = (int *)malloc(bytes);
  host_cancer_data_output = (int *)malloc(bytes);
  host_medicine_data_output = (int *)malloc(bytes);

  device = create_device();
  context = clCreateContext(NULL, 1, &device, NULL, NULL, &err);

  /* Build program */
  program = build_program(context, device, PROGRAM_FILE);

  /* Create a command queue */
  queue = clCreateCommandQueue(context, device, 0, &err);

  /* Create data buffer
  Create the input and output arrays in device memory
  for our calculation. 'd' below stands for 'device'.
  */
  device_cancer_data_in = clCreateBuffer(context, CL_MEM_READ_ONLY, bytes, NULL, NULL);
  device_medicine_data_in = clCreateBuffer(context, CL_MEM_READ_ONLY, bytes, NULL, NULL);
  device_cancer_data_out = clCreateBuffer(context, CL_MEM_WRITE_ONLY, bytes, NULL, NULL);
  device_medicine_data_out = clCreateBuffer(context, CL_MEM_WRITE_ONLY, bytes, NULL, NULL);

  // Write our data set into the input array in device
  // memory

  /* Create a kernel */
  kernel = clCreateKernel(program, KERNEL_FUNC, &err);
  err = clSetKernelArg(kernel, 0, sizeof(cl_mem),
                       &device_cancer_data_in); // <=====INPUT1
  err |= clSetKernelArg(kernel, 1, sizeof(cl_mem),
                        &device_medicine_data_in); // <=====INPUT2
  err |= clSetKernelArg(kernel, 2, sizeof(cl_mem),
                        &device_cancer_data_out); // <=====OUTPUT1
  err |= clSetKernelArg(kernel, 3, sizeof(cl_mem),
                        &device_medicine_data_out); // <=====OUTPUT2
  err |= clSetKernelArg(kernel, 4, sizeof(unsigned int), &ARRAY_SIZE);

  err = clGetKernelWorkGroupInfo(kernel, device, CL_KERNEL_WORK_GROUP_SIZE, sizeof(local_size), &local_size, NULL);
  // Number of total work items - localSize must be
  // devisor
  global_size = ceil(ARRAY_SIZE / (int)local_size) * local_size;
  printf("global=%u, local=%u\n", global_size, local_size);

  totalHealthyCells = WIDTH * HEIGHT;
  initCancerCell();

  // NOTE: OPENGL DISPLAY FUNCTIONS:
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_RGBA);
  glutInitWindowSize(1000, 1000);
  glutCreateWindow("Cell Simulator");

  glClearColor(0, 0, 0, 1);
  glClear(GL_COLOR_BUFFER_BIT);
  glutDisplayFunc(display);

  totalHealthyCells = WIDTH * HEIGHT;
  initCancerCell();

  glutMainLoop();

  /* Deallocate resources */
  clReleaseKernel(kernel);
  clReleaseMemObject(device_cancer_data_in);
  clReleaseMemObject(device_medicine_data_in);
  clReleaseMemObject(device_cancer_data_out);
  clReleaseMemObject(device_medicine_data_out);
  clReleaseCommandQueue(queue);
  clReleaseProgram(program);
  clReleaseContext(context);
  return 0;
}
