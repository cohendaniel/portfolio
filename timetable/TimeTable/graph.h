#pragma once

#include <vector>
#include <map>
#include <iostream>

#include "node.h"

#include <algorithm>

class Graph {
public:	
	std::vector<std::shared_ptr<DupNode>> dupNodes;
	std::vector<std::shared_ptr<ItemNode>> itemNodes;
	std::vector<std::shared_ptr<BlockNode>> blockNodes;
	std::vector<std::shared_ptr<SlotNode>> slotNodes;
	std::shared_ptr<Node> source, sink;


	Graph(int numNodes);
	std::shared_ptr<ItemNode> addItem(int id, int numDups);
	void addBlock(int id, int numSlots, std::string dtStartStr, std::string dtEndStr);
	std::shared_ptr<BlockNode> getBlock(int id);
	void addEdges(int itemID, int numDups, int blockID);
	void addEdge(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo);

	void setEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo, int weight);
	int getEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo);

	void resetColor();
	int size();
	void printGraph();

private:

	std::vector<std::vector<int>> graph; 
	int numNodes_;

	void addDups(std::shared_ptr<ItemNode> itemNode, int numDups);
	void addSlots(std::shared_ptr<BlockNode> blockNode, int numSlots);
};

struct NodeEqual {
	const std::shared_ptr<Node> n;

	bool operator() (const std::shared_ptr<Node> p) const {
		return n->eID == p->eID;
	}
};