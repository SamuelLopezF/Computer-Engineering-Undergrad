Fifo Scheduler : 
FIFO scheduler with MMU simulates the scheduling of threads on a multicore processor. The MMU is simulated with an array representing RAM pages and a .txt file representing disk space. Threads run for a random amount of time and perform the next command available. Pages and access to CPU core are protected with sempahores and the MMU api is synchronized. 

Fair Share Scheduler : 
This scheduler simulates user thread groups and allocates a slice of the time quantum to each user. Users then distribute fairly their allocated time to each of their currently active threads. 
