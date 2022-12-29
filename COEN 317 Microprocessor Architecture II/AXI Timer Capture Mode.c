/*
 *Samuel Lopez-Ferrada 40112861
 *COEN 317 Lab 3 : Time between two Switch press using Capture Mode AXI Timer
 */

/*This program consists of calculating the number of clock cycles between two presses of a switch
on the Xiling board. The program acocunts for switch bouncing and estimates the elapsed time
with a clock frequency of 50 Mhz.*/

#include "stdbool.h"
#include "xparameters.h"
#include "xil_types.h"
#include "xgpio.h"
#include "xil_io.h"
#include "xil_exception.h"

#include "xtmrctr.h"

#include <iostream>
using namespace std;

int main()
{
    static XGpio GPIOInstance_Ptr;
    u32* Timer_Ptr = (u32*)XPAR_TMRCTR_0_BASEADDR;
    // base address = control/status reg
    // base address + 4 bytes = load register value (reset value)
    // base address + 8 bytes = counter register
    int xStatus;

    cout << "#### Sam's counter Application Starts ####" << endl;
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Step-1: AXI GPIO Initialisation
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    xStatus = XGpio_Initialize(&GPIOInstance_Ptr,XPAR_AXI_GPIO_FOR_OUTPUT_DEVICE_ID);
    if(xStatus != XST_SUCCESS)
        {
        cout<<"GPIO INIT failed"<<endl;
        return 1;
        }

        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // AXI GPIO Set the Direction
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //XGpio_SetDataDirection(XGpio *InstancePtr, unsigned Channel, u32 DirectionMask);
        //we use only channel 1, and 0 is the the parameter for output
        XGpio_SetDataDirection(&GPIOInstance_Ptr, 1, 0);

        // changing bits for init :
        // This changes the timer to
            //bit(0) = 1 -> capture mode enabled
            //bit(1) = 0 -> up timer enabled
            //bit(3) = 1 -> external capture enabled
            //bit(4) = 1 -> Auto reload : overwrites capture value.
        *(Timer_Ptr) = 0x019;

        // load 0 as the reset value into the load register of the counter
        *(Timer_Ptr + 1) = 0;

        // now load this value into the counter register by setting load =1 in control register
        // setting the bit(5) to 1 , allows TLR0 to be loaded. this changes our hex value from 0x19 to 0x39
        *(Timer_Ptr) = 0x039;

        // setting bits :
            // bit(5) = 0 -> de-asserts load to allow timer to start.
            // bit(7) = 1 -> starts the timer

        *(Timer_Ptr) = 0x019;

        cout<<"Starting Timer, press a the button to record first value"<<endl;
        cout<<endl;
        *(Timer_Ptr) = 0x099;


        while(*(Timer_Ptr + 1) == 0);

        cout<<" Captured first value"<<endl;

        unsigned int capture_value = *(Timer_Ptr + 1);
        cout<<" Captured value :   " << capture_value <<endl;


        cout<<endl;

        while(*(Timer_Ptr + 2) < capture_value + 0x16FFFFF);   //about ~ 0.5 seconds delay

        cout<<" ~ About 0.5s delay "<<endl;
        cout<<" Press the button to record second value"<<endl;

        while((*(Timer_Ptr + 1) == capture_value) || *(Timer_Ptr + 1) <  capture_value + 0x16FFFFF );

        unsigned int new_capture_value = *(Timer_Ptr + 1);

        cout << "The difference between the two values is :    " << (new_capture_value - capture_value)<< endl;
        cout << "The estimated time between presses is :       " << (float) (new_capture_value - capture_value)/ 50000000<<endl;

}
