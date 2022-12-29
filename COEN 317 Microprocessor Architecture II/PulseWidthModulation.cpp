/*
 *Samuel Lopez-Ferrada 40112861
 *COEN 317 Lab 3 : Pulse Width Modulation
 */

/* This program consits in setting up the parameters for an AXI Timer to run a PWD on a LED*/

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

    int xStatus;

    cout << "####  Counter Application Starts ####" << endl;

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Step-1: AXI GPIO Initialization
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    xStatus = XGpio_Initialize(&GPIOInstance_Ptr, XPAR_AXI_GPIO_FOR_OUTPUT_DEVICE_ID);
    if(xStatus != XST_SUCCESS)
    {
        cout << "GPIO A Initialization FAILED" << endl;
        return 1;
    }

    u32* timer_ptr_0 = (u32*) XPAR_AXI_TIMER_0_BASEADDR;
    u32* timer_ptr_1 = (u32*) (XPAR_AXI_TIMER_0_BASEADDR + 0x10);

    *timer_ptr_0 = 0x206;
    *timer_ptr_1 = 0x206;
    unsigned int high_time;
    unsigned int period;

    while(1){
    cout<<"enter period in seconds "<<endl;
    cin>>period;
    cout<<"enter duty cycle percentage "<<endl;
    cin>>high_time;
    cout<<"Duty cycle :" << high_time << "  period " << period <<endl;

    *(timer_ptr_0 + 1) = (u32) (period * 50000000) - 2;
    *(timer_ptr_1 + 1) = (u32) (high_time * 50000000) - 2;

    cout<<"timer ptr 0 " << *(timer_ptr_0 + 1) << endl;
    cout<<"timer ptr 1 " << *(timer_ptr_1 + 1) << endl;

    *timer_ptr_0 = 0x226;
    *timer_ptr_1 = 0x226;

    *timer_ptr_0 = 0x286;
    *timer_ptr_1 = 0x286;

    }
    return 0;

}
