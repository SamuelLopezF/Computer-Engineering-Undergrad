cmake_minimum_required(VERSION 2.8 FATAL_ERROR)

project(CellSimulator)

add_executable(CellSimulator 

	main.cpp)

find_package(OpenGL REQUIRED)
find_package(OpenCL REQUIRED)
find_package(GLUT REQUIRED)

include_directories( ${OPENGL_INCLUDE_DIRS} ${GLUT_INCLUDE_DIRS} )

target_link_libraries(CellSimulator  OpenCL::OpenCL ${OPENGL_LIBRARIES} ${GLUT_LIBRARIES} ) 


