These program revolve around the use of the Xilinx ZYNQ-7 ZC702 Evaluation Board. Only the cpp files were uploaded as other information is either proprietary or uncessecary. 

CDMA Transfer : The program transfers data from a source register to a destination register. A AXI Timer is used to count the number of clock cycles required to complete the tranfer. Results are compared to a for loop transfer using two pointes.

Capture Mode : THe program uses the Capture Mode of the AXI Timer to calculate the time elapsed between two presses of a switch on the Xilinx board. The program accounts for switch bounce. 

Interupt Handling : The program uses the two AXI timers and generates periodic interupts. The interupt handler function differentiates which timer (T0 or T1) threw the interupt by accessing the control register and using bit masking. 

Pulse witdh modulation : The sets up a AXI Timer to PWD mode with user defined high time and duty cycle. The output of the timer is connected to  LED on the board using a GPIO instance. 
