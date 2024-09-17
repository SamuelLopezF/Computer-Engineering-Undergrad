/*
 * Cancer Growth Cell Simulation
 * Author: Samuel Lopez-Ferrada
 * Course : COMP 426 - Multicore Programming Fall 2023
 *
 *	This program simulates the growth of cancer cell and the absorbtion of
 *mecidine cells. The rendering is done using openGL and the computation is done
 *using posix threads. There is one control thread and one control function
 *which takes care of distributing the load onto 10 computation threads. Each
 *computation threads executes functions to validate the change is state of a
 *subset of the cell matrix. The cell matrix is represented as a 3 int (RGB) 2-D
 *set of pixels interpreted by the drawPixels function from the openGL api.
 *
 */

#include "GL/glew.h"
#include <GL/freeglut_std.h>
#include <bits/types/clock_t.h>
#include <chrono>
#include <cstdio>
#include <cstdlib>
#include <ctime>
#include <iostream>
#include <pthread.h>
#include <random>
#include <stdarg.h>
#include <unistd.h>
#include <utility>

// predefined macros :
#define WIDTH 1000
#define HEIGHT 1000
#define HEALTHY 0
#define CANCER 1
#define MEDICINE 2
#define PROPAGATION_FACTOR 5

//.exe input parameters
bool COUNT = 0;
bool SPEED = 0;
bool RANDOM = 0;
bool MANUAL = 0;

pthread_t threads[8];
int totalMedicineCells = 0;
int totalCancerCells = 0;
int totalHealthyCells = 0;
float data[WIDTH][HEIGHT][3];
int th_count = 4;

std::uniform_int_distribution<> distrX(0, WIDTH - 1);  // define the range
std::uniform_int_distribution<> distrY(0, HEIGHT - 1); // define the range

// Structure containing the values of a cell.
struct Cell {
  bool green = true;
  bool red = false;
  bool modified;
  int status;
  int xDirection;
  int yDirection;
};

// 2-D array of cells
Cell cell_array[WIDTH][HEIGHT];

// Argument containing bounds for computation function
struct computation_bounds {
  int xStart;
  int xEnd;
  int yStart;
  int yEnd;
};

// Function to validate the next status of a cell. Each neihgbour state is
// compared to the input state. It returns true or false depending if the
// positive results is above PROPAGATION_FACTOR
int checkNeighbours(int x, int y, int status) {

  int status_counter = 0;
  [[__unlikely__]] if (x == 0 || x == WIDTH)
    return 0;
  [[__unlikely__]] if (y == 0 || y == HEIGHT)
    return 0;

  if (cell_array[x - 1][y].status == status)
    status_counter++;
  if (cell_array[x + 1][y].status == status)
    status_counter++;
  if (cell_array[x - 1][y - 1].status == status)
    status_counter++;
  if (cell_array[x + 1][y - 1].status == status)
    status_counter++;
  if (cell_array[x][y - 1].status == status)
    status_counter++;
  if (cell_array[x][y + 1].status == status)
    status_counter++;
  if (cell_array[x - 1][y + 1].status == status)
    status_counter++;
  if (cell_array[x + 1][y + 1].status == status)
    status_counter++;

  return (status_counter >= PROPAGATION_FACTOR);
}

// Function that moves a cell in it's contained direction.
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
    // Cell is already green from medicine and just need to turn off red.
    cell_array[x][y].red = 0;

    // Neighbhour is already green to accept a medicine moving in as yellowpro
    // just turn on red to make yellow.
    cell_array[neighbourX][neighbourY].red = 1;
    cell_array[neighbourX][neighbourY].xDirection = directionX;
    cell_array[neighbourX][neighbourY].xDirection = directionY;
  }
}

// Self explanatory function that takes care of clearing flags
void clearModifyFlags(int xStart, int xEnd, int yStart, int yEnd) {
  for (int x = xStart; x < xEnd; x++) {
    for (int y = yStart; y < yEnd; y++) {
      cell_array[x][y].modified = 0;
    }
  }
}

// Function that is the start iterates over each cell and verifies if it should
// change using the checkNeihgbour cell.
void compute_cell_change(int xStart, int xEnd, int yStart, int yEnd) {

  for (int x = xStart; x < xEnd; x++) {
    for (int y = yStart; y < yEnd; y++) {
      if (x == 999)
        continue;
      if (y == 999)
        continue;
      if (!cell_array[x][y].red && !cell_array[x][y].modified && checkNeighbours(x, y, CANCER)) {
        cell_array[x][y].status = CANCER;
        cell_array[x][y].red = 1;
        cell_array[x][y].green = 0;
        cell_array[x][y].modified = 1;
        totalCancerCells++;
      }

      else if (!cell_array[x][y].green && cell_array[x][y].red && !cell_array[x][y].modified && checkNeighbours(x, y, MEDICINE)) {

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

// Computation is mostly a wrapper function for the compute cell change
// function. It also contains the code for pushing medicine manually or
// randomly.

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
    for (int i = 0; i < 10; i++) {

      for (int x = -1; x <= 1; x++) {

        if (x + ranX >= WIDTH || x + ranX < 0)
          continue;

        for (int y = -1; y <= 1; y++) {

          if (y + ranY >= HEIGHT || y + ranY < 0)
            continue;

          cell_array[x + ranX][y + ranY].status = MEDICINE;
          cell_array[x + ranX][y + ranY].green = 1;
          cell_array[x + ranX][y + ranY].red = 1;
          cell_array[x + ranX][y + ranY].modified = 1;
          cell_array[x + ranX][y + ranY].xDirection = x;
          cell_array[x + ranX][y + ranY].yDirection = y;
          totalMedicineCells++;
        }
      }
    }
  }
  return NULL;
}

float average = 0;
int clk = 0;
// Control function takes care of generating the computation threads and takes
// care of the timer to display the computation time.
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

  if (clk > 100) {
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

    if (clk > 100)
      exit(0);

    if (COUNT) {
      printf("MED :\t %u", totalMedicineCells);
      printf("\tHLTY:\t %u", totalHealthyCells);
      printf("\tCANCER:\t %u \n", totalCancerCells);
    }

    if (once)
      manual_input_start = clock();
    once = false;
    if (MANUAL) {

      if (manual_input_start + 1 < (float)clock()) {
        once = true;
        manual_input_start = clock();
        // if(x == 0 || x == WIDTH) return NULL;
        // if(y == 0 || y == HEIGHT) return NULL;
        int x, y;
        printf(" enter X ");
        std::cin >> x;
        printf("\n enter Y ");
        std::cin >> y;
        for (int x = -1; x <= 1; x++) {
          for (int y = -1; y <= 1; y++) {
            cell_array[x][y].status = MEDICINE;
            cell_array[x][y].xDirection = x;
            cell_array[x][y].yDirection = y;
            totalMedicineCells++;
          }
        }
      }
    }
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

  if (argc > 2) {
    std::string arg1(argv[1]);
    std::string arg2(argv[2]);
    if (!arg1.compare("-s"))
      SPEED = 1;
    if (!arg1.compare("-c"))
      COUNT = 1;
    if (!arg2.compare("-r"))
      RANDOM = 1;
    if (!arg2.compare("-m"))
      MANUAL = 1;
  }

  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_RGBA);
  glutInitWindowSize(HEIGHT, WIDTH);
  glutCreateWindow("Cell Simulator");

  // glutFullScreen();

  glClearColor(0, 0, 0, 1);
  glClear(GL_COLOR_BUFFER_BIT);
  glutDisplayFunc(display);

  totalHealthyCells = WIDTH * HEIGHT;
  initCancerCell();

  glutMainLoop();

  return 0;
}
