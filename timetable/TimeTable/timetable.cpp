#include <ctime>
#include <cstdlib>
#include <sstream>
#include <fstream>
#include <iostream>
#include <algorithm>
#include <string>

#include "graph.h"
#include "matcher.h"
#include "constants.h"
#include "timetable.h"

int NUMDUPS, NUMITEMS, NUMBLOCKS, NUMSLOTS, NUMNODES, Node::nodeCounter;

/* Parameters:
 *	0: Name
 *  1: Block File
 *  2: Item File
 */

int main(int argc, char* argv[]) {

	std::clock_t start = std::clock();

	initConstants(std::atoi(argv[2]), std::atoi(argv[3]), std::atoi(argv[4]), std::atoi(argv[5]));

	//std::cout << NUMDUPS << ", " << NUMITEMS << ", " << NUMBLOCKS << ", " << NUMSLOTS << "</br>";

	Graph graph(NUMNODES);
	fillGraph(graph, argv[1], argv[6]);

	makeSchedule(graph);
	findMatches(graph);

	double duration = (std::clock() - start) / (double) CLOCKS_PER_SEC;
	//std::cout << "Time: " << duration << std::endl;
}

void initConstants(int d, int i, int b, int s) {
	Node::initNodeID();
	NUMDUPS = d;
	NUMITEMS = i;
	NUMBLOCKS = b;
	NUMSLOTS = s;
	NUMNODES = NUMDUPS + NUMITEMS + NUMBLOCKS + NUMSLOTS + 2;
}

void fillGraph(Graph &g, char* edgesPath, char* slotsPath) {
	readEdgeFile(edgesPath, g);
	readSlotFile(slotsPath, g);
}

void findMatches(Graph &g) {
	std::map<BlockNode*, std::vector<DupNode*>> printSchedule;
	std::vector<int> notMatchedOutput;
	std::ostringstream output;
	
	for (auto itemNode:g.itemNodes) {
		if (itemNode->matches.size() > 0) {
			for (int matchNum = 0; matchNum < itemNode->matches.size(); matchNum++) {
				printSchedule[itemNode->matches[matchNum].get()].push_back(itemNode->dups[matchNum].get()); 
			}
		}
		else {
			notMatchedOutput.push_back(itemNode->eID);
			//std::cout << itemNode->eID << " has not been scheduled." << std::endl;
		}
	}
	output << "{\"item_not_scheduled\":[";
	for (int i = 0; i < notMatchedOutput.size(); i++) {
		output << notMatchedOutput[i] << ",";
	}
	stripTrailingComma(output);
	output << "],\"block_not_scheduled\":[";
	for (auto blockNode:g.blockNodes) {
		if (printSchedule.count(blockNode.get()) == 0) {
			output << blockNode->eID << ",";
			//std::cout << blockNode->eID << " block has not been scheduled." << std::endl;
		}
		if (printSchedule[blockNode.get()].size() < blockNode->numSlots) {
			output << blockNode->eID << ",";
		}
	}
	stripTrailingComma(output);
	
	output << "],\"matched\":{";
	for (std::map<BlockNode*, std::vector<DupNode*>>::iterator it=printSchedule.begin(); it!=printSchedule.end(); ++it) {
		if (!(it->second.empty())) {
			output << "\"" << it->first->eID << "\"" << ":[";
			for (auto dup:it->second) {
				output << dup->getItemNode()->eID << ",";
			}
			stripTrailingComma(output);
			output << "],";
		}
	}
	stripTrailingComma(output);
	output << "}}";
	std::cout << output.str();
}

void stripTrailingComma(std::ostringstream& oss) {
	std::string s = oss.str();
	if (s[s.length()-1] == ',') {
		s.erase(s.length()-1);
	}
	oss.str("");
	oss << s;
}

void readEdgeFile(char* fp, Graph &g) {
	std::fstream file(fp, std::fstream::in);
	if (file.is_open()) {
		std::string line;
		while (getline(file, line)) {
			std::stringstream ss(line);

			std::string itemID, blockID, numSlots, numDups;

			std::getline(ss, itemID, ',');
			std::getline(ss, numDups, ',');
			std::getline(ss, blockID, ',');
			std::getline(ss, numSlots, ',');

			g.addEdges(std::stoi(itemID), std::stoi(numDups), std::stoi(blockID), std::stoi(numSlots));
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	file.close();
}

void readSlotFile(char* fp, Graph &g) {
	std::fstream file(fp, std::fstream::in);
	if (file.is_open()) {
		std::string line;
		while (getline(file, line)) {
			std::stringstream ss(line);

			std::string slotID, slotNumber;

			std::getline(ss, slotID, ',');
			std::getline(ss, slotNumber, ',');

			g.addBlock(std::stoi(slotID), std::stoi(slotNumber));
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	file.close();
}