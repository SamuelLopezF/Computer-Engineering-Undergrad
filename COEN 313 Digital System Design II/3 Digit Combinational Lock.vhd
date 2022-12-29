
#COEN 313 : Digital System design II : Final Project : Combinational Lock


#This program consists of simulating a 3 digit combination lock. Using FSM states and 
# controling the condition for switiching states the lock unlocks only with the right sequence. 

library ieee;
use ieee.std_logic_1164.all;
entity proto3 is
    port(
    ld1    : in std_logic;
    ld2    : in std_logic;
    ld3    : in std_logic;
    value    : in std_logic_vector(3 downto 0);
    enter    : in std_logic;
    clock    : in std_logic;
    reset    : in std_logic;
    unlock    : out std_logic
    );    
end entity;


architecture proto3_arch of proto3 is
type memory_controller_state is
    (idle, read_one, read_two, read_three, unlock_state, load_one, load_two, load_three);
signal state_current, state_next : memory_controller_state;


signal c1 : std_logic_vector(3 downto 0);
signal c2 : std_logic_vector(3 downto 0);
signal c3 : std_logic_vector(3 downto 0);
signal equal : std_logic:= '0';
signal current_digit : std_logic_vector(3 downto 0);
signal sel : std_logic_vector(1 downto 0);

begin



    --state register :
    process(clock ,reset)
   	 begin    if(reset = '1')then
   			 state_current <= read_one;
   		 elsif(clock'event and clock = '1')then
   			 state_current <= state_next;
   		 end if;
    end process;
    
   







 --next state logic :
    process(ld1,ld2,ld3,state_current,enter,equal,value,reset)
   	 begin
   	 if(state_current = read_one) then
   		 sel <= "00";
   	 elsif(state_current = read_two) then
   		 sel <= "01";
   	 elsif(state_current = read_three) then

   		 sel <= "10";
   	 else
   		 sel <= "11";
   	 end if;
   		 
   	 case state_current is
   	 when idle =>
   		 if(ld1 = '1')then
   			 state_next <= load_one;
   		 elsif(ld2 = '1')then
   			 state_next <= load_two;
   		 elsif(ld3 = '1')then
   			 state_next <= load_three;
   		 elsif(reset = '1')then
   			 state_next <= read_one;
   		 else
   			 state_next <= idle;
   		 end if;
   	 when read_one =>
   		 if(enter = '1')then
   			 if(equal = '1')then
   				 state_next <= read_two;
   			 else
   				 state_next <= idle;
   			 end if;
   		 else
   			 state_next <= state_current;
   		 end if;
   	 when read_two =>
   		 if(enter = '1')then
   			 if(equal = '1')then
   				 state_next <= read_three;
   			 else
   				 state_next <= idle;
   			 end if;
   		 else
   			 state_next <= state_current;
   		 end if;
   	 when read_three =>   		 
   		 if(enter = '1')then
   			 if(equal = '1')then
   				 state_next <= unlock_state;
   			 else
   				 state_next <= idle;
   			 end if;
   		 else
   			 state_next <= state_current;
   		 end if;
   	 when load_one =>
   		 c1 <= value;
   		 state_next <= idle;
   	 when load_two =>
   		 c2 <= value;
   		 state_next <= idle;
   	 when load_three =>
   		 c3 <= value;
   		 state_next <= idle;
   	 when unlock_state =>
   		 state_next <= idle;
   	 when others =>
   		 state_next <= idle;
   	 end case;
    end process;


    -- Mux Control :
    process(state_current, sel, c1,c2,c3)
   	 begin

   		 if(sel = "00")then
   			 current_digit <= c1;
   		 elsif(sel = "01")then
   			 current_digit <= c2;
   		 elsif(sel = "10")then
   			 current_digit <= c3;
   		 else
   			 current_digiSSt <= "1111";
   		 end if;
    end process;


    
    -- Equal :
    process(enter, value, current_digit)
   	 begin
   		 if(value = current_digit)then
   			 equal <= '1';
   		 else
   			 equal <= '0';
   		 end if;
   	 end process;


    -- Moore output :
    unlock <= '1' when (state_current = unlock_state) else
   		 '0';
end proto3_arch;   	