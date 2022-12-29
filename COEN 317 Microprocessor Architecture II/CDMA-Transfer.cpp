/*
 *Samuel Lopez-Ferrada 40112861
 *COEN 317 Lab 5 : CDMA TRANSFER
 */

/*This program consists of tranfering an array of values from a source register to a destinatino
register using the Simple CDMA tranfer protocol from the Xilinx board. Various size of array are transfered
and time is calculated using the AXI Timer. Results are compared to a simple for loop.*/
#include "xil_exception.h"
#include "xil_cache.h"
#include "xparameters.h"
#include <iostream>


using namespace std;


int main()
{

    //SETTING VARIABLES :
    u32* CMDA0_CONTROL      = (u32*) (XPAR_AXI_CDMA_0_BASEADDR);
    u32* CMDA0_STATUS       = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x04);
    u32* CMDA0_CUR_PTR      = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x08);
    u32* CDMA0_TAIL_PTR     = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x10);
    u32* CDMA0_SOURCE_ADDR  = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x18);
    u32* CDMA0_DEST_ADDR    = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x20);
    u32* CDMA0_B_TRANSFER   = (u32*) (XPAR_AXI_CDMA_0_BASEADDR + 0x28);

    u32* HP0_BASE           = (u32*) XPAR_PS7_DDR_0_S_AXI_HP0_BASEADDR;
    u32* HP2_BASE           = (u32*) XPAR_PS7_DDR_0_S_AXI_HP2_BASEADDR;
    u32* TIMER0_CONTROL     = (u32*) XPAR_AXI_TIMER_0_BASEADDR;
    u32* TIMER0_LOAD        = (u32*) (XPAR_AXI_TIMER_0_BASEADDR + 0x4);
    u32* TIMER0_VALUE       = (u32*) (XPAR_AXI_TIMER_0_BASEADDR + 0x8);

    const int MAX_TRANFER_BYTES = 2097151;
    int TRANSFER_LENGTH = 0;
    int BYTES_TO_TRANSFER = 0;
    *(TIMER0_LOAD) = 0x00000000;

    cout <<"====== INIT  VALUES ======"<<endl;
    cout << "HP0 BASE ADDR : \t" <<std::hex << HP0_BASE <<endl;
    cout << "HP2 BASE ADDR : \t" <<std::hex << HP2_BASE <<endl;
    cout << "TIMER 0 CONTROL : \t"<<std::hex << *TIMER0_CONTROL << endl;
    cout <<"====== CDMA INIT =================================="<<endl;
    cout << "CDMA CONTROL : \t\t\t"   << *CMDA0_CONTROL << endl;
    cout << "CDMA STATUS : \t\t\t"   << *CMDA0_STATUS << endl;
    cout << "CDMA CUR_PTR : \t\t\t"   << *CMDA0_CUR_PTR << endl;
    cout << "CDMA TAIL_PTR : \t\t"   << *CDMA0_TAIL_PTR << endl;
    cout << "CDMA SOURCE ADDRESS : \t\t"  << *CDMA0_SOURCE_ADDR << endl;
    cout << "CDMA DESTINATION ADDRESS : \t"   << *CDMA0_DEST_ADDR << endl;
    cout << "CDMA BYTES TO TRANSFER : \t"   << *CDMA0_B_TRANSFER << endl;
    cout<<"===================================================="<<endl;

    //Initialising the source array with some values :
        cout<<"\n\n ---------- Initialising source array with HP0_BASE_ADDR ----------"<< endl;
        for(int i = 0 ; i < MAX_TRANFER_BYTES; i ++)
        {
            *(HP0_BASE + i) = 0x4C4F5452;
            if( i == 4)
            {
                cout<<"..."<<endl;
            }
            if(i < 3 || i + 4 > MAX_TRANFER_BYTES)
            {

                cout<< "ADDRESS : " << std::hex << (HP0_BASE + i) ;
                cout<< "\t VALUE : " << *(HP0_BASE + i ) << endl;
            }
        }

    //Initialising the destination array with negative values :
        cout<<"\n\n ---------- Initialising destination array with HP2_BASE_ADDR ----------"<< endl;
        for(int i = 0 ; i < MAX_TRANFER_BYTES; i ++)
        {
            *(HP2_BASE + i) = -1;
            if( i == 4)
            {
                cout<<"..."<<endl;
            }
            if(i < 3 || i + 4 > MAX_TRANFER_BYTES)
            {

                cout<< "ADDRESS : " << std::hex << (HP2_BASE + i)  ;
                cout<< "\t VALUE : " << *(HP2_BASE + i ) << endl;
            }

        }
  TRANSFER_LENGTH = 1024;

// Start of main loop :
// since we are transferring 8 hex values, each value represents 4 bits, so each register
// is transferring 4 bytes. Thus the maximum length is maximum bytes / 4.

while(TRANSFER_LENGTH <= MAX_TRANFER_BYTES){

        BYTES_TO_TRANSFER = TRANSFER_LENGTH *4;

    //Reseting the CDMA :
        cout<<"\n\n-------RESETTING CDMA CONTROL -------"<< endl;

        *(CMDA0_CONTROL) = 4;
        cout << "CDMA CONTROL : \t\t\t"   << *CMDA0_CONTROL << endl;
        cout << "CDMA STATUS : \t\t\t" << *CMDA0_STATUS <<endl;

    //Polling the status to see if idle :
        if(*(CMDA0_STATUS) == 0x2)
        {
            cout<<"CDMA RESET AND IDLE"<< endl;
        }else{
            cout<<"CDMA NOT RESET AND IDLE" << endl;
        }
        cout<<"--------------------------------------"<<endl;
    /*Configuring CDMA in simple mode and with no interrupts :
    * Clearing bit 12   -> 0 : Corresponds to disabling interrupts for completion
    * Clearing bit 3    -> 0 : Corresponds to CDMA Simple mode.
    */
        *(CMDA0_CONTROL) = 0x0000;

        *(CDMA0_SOURCE_ADDR) =  (u32) HP0_BASE;
        *(CDMA0_DEST_ADDR) =    (u32) HP2_BASE;
        *(CMDA0_CONTROL) = 0x0000;

    // Flushing Cache :
        Xil_DCacheFlush();

    // Writing the amount of data to transfer :
    //  cout<< "CDMA STATUS BEFORE BTT : " << *(CMDA0_STATUS) <<endl; for debugging


        *(TIMER0_CONTROL)  = 0xA0;

        *(CDMA0_B_TRANSFER) = BYTES_TO_TRANSFER;

    //  cout<< "CDMA STATUS AFTER BTT : " << *(CMDA0_STATUS) <<endl; for debugging

        *(TIMER0_CONTROL)  = 0x80;

        while((*(CMDA0_STATUS) &(1<<1)) != 2 );

        *(TIMER0_CONTROL) = 0x00;

        cout<<"\n------------------ METRICS FOR : " << std::dec << TRANSFER_LENGTH  << "------------------------------------" << endl;
        cout<<"\n----------------------------CDMA TRANSFER---------------------------"<<endl;

        float time_elapsed = (float) *(TIMER0_VALUE);
        time_elapsed = time_elapsed / 50000000;

        cout<<"\n\nDESTINATION ARRAY \t\t\t\t\t\t\t SOURCE ARRAY "<<endl;
        for(int i = 0 ; i < TRANSFER_LENGTH; i ++)
        {
            if( i == 4)
            {
                cout<<"..."<<endl;
            }
            if(i + 4 > TRANSFER_LENGTH)
            {

                cout<< "ADDRESS : " << std::hex << (HP2_BASE + i) ;
                cout<< "\t VALUE : " << *(HP2_BASE + i );

                cout<< "    <---->   " << *(HP0_BASE + i ) << ": VALUE";
                cout<< "\tADDRESS : " << std::hex << (HP0_BASE + i)<<endl;
            }

        }
        cout<<"Timer value : " << std::hex << *(TIMER0_VALUE)<< "\tTime elapsed : " << time_elapsed<<endl;

        cout<<"\n--------------------------------------------------------------------"<<endl;

        cout<<"\n----------------------------FOR LOOP -------------------------------"<<endl;
        *(TIMER0_CONTROL) = 0xA0;
        *(TIMER0_CONTROL) = 0x80;
        for(int i = 0 ; i < TRANSFER_LENGTH; i ++)
        {
            *(HP2_BASE + i) = 0xFAFAFAFA;
            if(i > ( TRANSFER_LENGTH-3))
            {

                cout<< "HP2_BASE \t\t" << std::hex << *(HP2_BASE)<<endl;
            }
        }

        *(TIMER0_CONTROL) = 0x00;
        time_elapsed = (float) *(TIMER0_VALUE);
        time_elapsed = time_elapsed / 50000000;
        cout<<"Timer value : " << std::hex << *(TIMER0_VALUE)<< "\tTime elapsed : " << time_elapsed<<endl;

        cout<<"\n-------------------------------------------------------------------"<<endl;
        if(TRANSFER_LENGTH == MAX_TRANFER_BYTES)
                {
                    break;
                }
        TRANSFER_LENGTH = TRANSFER_LENGTH * 2;
        if(TRANSFER_LENGTH > MAX_TRANFER_BYTES)
        {
            TRANSFER_LENGTH = MAX_TRANFER_BYTES;
        }
}
        cout<<"END OF APPLICATION "<<endl;
    return 0;
}
