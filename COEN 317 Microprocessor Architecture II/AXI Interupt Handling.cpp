/*
 *Samuel Lopez-Ferrada 40112861
 *COEN 317 Lab 5 : AXI Interupt Handling
 */

/* This program generates periodic interupts using the AXI Timer. An interupt handler catches the interupt(s) and 
identifies which timer instance (T0 or T1) threw the interupt.*/

#include <iostream>
using namespace std;
#include "xparameters.h"
#include "xil_types.h"
#include "xtmrctr.h"
#include "xil_io.h"
#include "xil_exception.h"
#include "xscugic.h"
#include <stdio.h>

/* Instance of the Interrupt Controller */
XScuGic InterruptController;

/* The configuration parameters of the controller */
static XScuGic_Config *GicConfig;

// Timer Instance
XTmrCtr TimerInstancePtr;

int test = 0;
static int counter = 0;
void Timer_InterruptHandler(void)
{

    cout << "I am the interrupt handler        event # " << counter << endl;
    counter++;
    unsigned int* timer_ptr_to_TCR0 = (unsigned int*)XPAR_AXI_TIMER_0_BASEADDR;
    unsigned int* timer_ptr_to_TCR1 = (unsigned int*)(XPAR_AXI_TIMER_0_BASEADDR + 0x10);

    bool TCRO_flag =  (*timer_ptr_to_TCR0) & (1<<8);                    // Capture bit 9 of TCR0
    bool TCR1_flag =  (*timer_ptr_to_TCR1) & (1<<8);                    // Capture bit 9 of TCR1

    *(timer_ptr_to_TCR0) &= ~(1<<7);                                    // Stop timer 0
    *(timer_ptr_to_TCR1) &= ~(1<<7);                                    // Stop timer 1

    cout<<"Stopped timers " << endl;


    if(TCRO_flag)
    {
        cout << "Timer 0 flagged an interrupt" << endl;
    }else if(TCR1_flag){
        cout << "Timer 1 flagged an interrupt" << endl;
    }else{
        cout <<"idk what happened"<<endl;
    }

    char input;
    cout << "Press any key to start the timer" << endl;
    cin >> input ;
    cout <<" Starting Timers " << endl;

    *(timer_ptr_to_TCR0) |= (1<<8);                                     // writes 1 to bit 9 to clear interrupt flag
    *(timer_ptr_to_TCR1) |= (1<<8);                                     // writes 1 to bit 9 to clear interrupt flag

    *(timer_ptr_to_TCR0) |= (1<<7);                                     //start timer 0
    *(timer_ptr_to_TCR1) |= (1<<7);                                     //start timer 0

}

int SetUpInterruptSystem(XScuGic *XScuGicInstancePtr)
{
    /*
    * Connect the interrupt controller interrupt handler to the hardware
    * interrupt handling logic in the ARM processor.
    */
    Xil_ExceptionRegisterHandler(XIL_EXCEPTION_ID_INT,
    (Xil_ExceptionHandler) XScuGic_InterruptHandler,
    XScuGicInstancePtr);
    /*
    * Enable interrupts in the ARM
    */
    Xil_ExceptionEnable();
    return XST_SUCCESS;
}

int ScuGicInterrupt_Init(u16 DeviceId,XTmrCtr *TimerInstancePtr)
{
    int Status;
    /*
    * Initialize the interrupt controller driver so that it is ready to
    * use.
    * */

    GicConfig = XScuGic_LookupConfig(DeviceId);
    if (NULL == GicConfig)
    {
        return XST_FAILURE;
    }
    Status = XScuGic_CfgInitialize(&InterruptController, GicConfig,
    GicConfig->CpuBaseAddress);

    if (Status != XST_SUCCESS)
    {
        return XST_FAILURE;
    }
    /*
    * Setup the Interrupt System
    * */
    Status = SetUpInterruptSystem(&InterruptController);
    if (Status != XST_SUCCESS)
    {
        return XST_FAILURE;
    }

    // add this line to fix the interrupt only running once
        // Nov. 15, 2017
        // solution found by Anthony Fiorito on Xilinx Forum

    XScuGic_CPUWriteReg(&InterruptController, XSCUGIC_EOI_OFFSET, XPAR_FABRIC_AXI_TIMER_0_INTERRUPT_INTR);

    /*
    * Connect a device driver handler that will be called when an
    * interrupt for the device occurs, the device driver handler performs
    * the specific interrupt processing for the device
    */
    Status = XScuGic_Connect(&InterruptController,
                             XPAR_FABRIC_AXI_TIMER_0_INTERRUPT_INTR,
                             (Xil_ExceptionHandler)XTmrCtr_InterruptHandler,
                             (void *)TimerInstancePtr);

    if (Status != XST_SUCCESS)
    {
        return XST_FAILURE;
    }
    /*
    * Enable the interrupt for the device and then cause (simulate) an
    * interrupt so the handlers will be called
    */
    XScuGic_Enable(&InterruptController, XPAR_FABRIC_AXI_TIMER_0_INTERRUPT_INTR);

    return XST_SUCCESS;
}

int main()
{
    cout << "Application starts " << endl;
    int xStatus;

        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //Step-1 :AXI Timer Initialization
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        xStatus = XTmrCtr_Initialize(&TimerInstancePtr, XPAR_AXI_TIMER_0_DEVICE_ID);
        if(XST_SUCCESS != xStatus)
        {
                cout << "TIMER INIT FAILED " << endl;
                if(xStatus == XST_DEVICE_IS_STARTED)
                {
                        cout << "TIMER has already started" << endl;
                        cout << "Please power cycle your board, and re-program the bitstream" << endl;
                }
                return 1;
        }




    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Step-2 :Set Timer Handler
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // cast second argument to data type XTmrCtr_Handler since in gcc it gave a warning
        // and with g++ for the C++ version it resulted in an error

    XTmrCtr_SetHandler(&TimerInstancePtr, (XTmrCtr_Handler)Timer_InterruptHandler, &TimerInstancePtr);


      // intialize time pointer with value from xparameters.h file

        unsigned int* timer_ptr = (unsigned int* )XPAR_AXI_TIMER_0_BASEADDR;
         unsigned int* timer_ptr_to_TCR1 = (unsigned int*)(XPAR_AXI_TIMER_0_BASEADDR + 0x10);
         //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //Step-3 :load the reset value
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
       *(timer_ptr+ 1) = 0xf0000000;            //TLR0
       *(timer_ptr_to_TCR1 + 1) = 0xfa000000;   //TLR1


         //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
         //Step-4 : set the timer options
         //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
         // from xparameters.h file #define XPAR_AXI_TIMER_0_BASEADDR 0x42800000
         //  Configure timer in generate mode, count up, interrupt enabled
         //  with autoreload of load register

       *(timer_ptr)  = 0x0f4 ;          //TCR0 : Controls timer 0
       *(timer_ptr_to_TCR1) = 0x0f4;    //TCR1 : Controls timer 1





    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //Step-5 : SCUGIC interrupt controller Initialization
    //Registration of the Timer ISR
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    xStatus=
    ScuGicInterrupt_Init(XPAR_PS7_SCUGIC_0_DEVICE_ID, &TimerInstancePtr);
    if(XST_SUCCESS != xStatus)
    {
        cout << " :( SCUGIC INIT FAILED )" << endl;
        return 1;
    }



       // Beginning of our main code

    //We want to control when the timer starts
    char input;
    cout << "Press any key to start the timer" << endl;
    cin >> input ;
    cout << "You pressed "<<  input << endl;
    cout << "Enabling the timer to start" << endl;

        *(timer_ptr) = 0x0d4 ;          // deassert the load 5 to allow the timer to start counting
        *(timer_ptr_to_TCR1) = 0x0d4;   // deassert the load 5 to allow the timer to start counting

        // let timer run forever generating periodic interrupts

    while( 1)
        {
          //  // wait forever and let the timer generate periodic interrupts
        }

    return 0;
}
