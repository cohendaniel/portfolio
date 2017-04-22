#include <ctime>
#include <cstdlib>
#include <fstream>
#include <iostream>
#include <algorithm>

#include "graph.h"
#include "matcher.h"
#include "timetable.h"

/* Parameters:
 *	0: Name
 *  1: Block File
 *  2: Item File
 */

int main(int argc, char* argv[]) {

	std::clock_t start = std::clock();

	Matcher matcher(std::atoi(argv[1]), argv[2], argv[3]);

	matcher.makeSchedule();

	matcher.findMatches();

	double duration = (std::clock() - start) / (double) CLOCKS_PER_SEC;
	//std::cout << "Time: " << duration << std::endl;
}