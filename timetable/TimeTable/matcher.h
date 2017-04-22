/*
 *  bfs.h
 *
 *  Created on: Oct 31, 2015
 *  Author: Daniel Cohen
 */
#pragma once

#include "graph.h"

#include <queue>
#include <vector>
#include <limits.h>
#include <iostream>
#include <map>
#include <sstream>
#include <fstream>
#include <algorithm>

class Matcher {

public:
	void makeSchedule();

	void findMatches();

	Matcher(int numNodes, char* edgesPath, char* slotsPath);

private:

	Graph graph;

	bool BFS(std::shared_ptr<Node> source, std::shared_ptr<Node> sink);
	void removeMatch(std::shared_ptr<Node> bNode, std::shared_ptr<Node> iNode);
	void fillGraph(char* edgesPath, char* slotsPath);
	void readEdgeFile(char* fp);
	void readSlotFile(char* fp);
	void findOverlaps();

	void stripTrailingComma(std::ostringstream& oss);

};
