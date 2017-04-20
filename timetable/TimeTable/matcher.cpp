/*
 *  Implements standard BFS algorithm for use within the 
 *  Ford-Fulkerson algorithm for bipartite matching.
 *
 *  Created on: Oct 31, 2015
 *  Author: Daniel Cohen
 */
#include "matcher.h"

/* Implementation of the Ford Fulkerson algorithm specific
 * to bipartite matching. References the items data structure, which
 * does not currently make it general. This is necessary for multiple tour
 * handling.
 */

Matcher::Matcher(int numNodes, char* edgesPath, char* slotsPath) : graph(numNodes) {
	fillGraph(edgesPath, slotsPath);
}

void Matcher::makeSchedule() {
	// While there exists a path from the source to the sink.
	while (BFS(graph.source, graph.sink)) {
		
		// Retrace the path, update (reverse) flows
		for (std::shared_ptr<Node> n = graph.sink; n->ID() != graph.source->ID(); n = n->parent()) {
			std::shared_ptr<Node> p = n->parent();
			
			// if parent is item, add block to item's matches
			if (p->getType() == Node::item && n->getType() == Node::block) {
				std::static_pointer_cast<ItemNode>(p)->matches.push_back(std::static_pointer_cast<BlockNode>(n));
			}

			// if the parent is block, remove match between item and block
			if (p->getType() == Node::block && n->getType() == Node::item) {
				removeMatch(p, n);
			}

			// reverse the edge weights
			graph.setEdgeWeight(n, p, 1);
			graph.setEdgeWeight(p, n, 0);
		}
		// reset all node colors to white
		graph.resetColor();
	}
}


/* Implementation of BFS. Returns true if path from source to sink
 * was found. 
 */
bool Matcher::BFS(std::shared_ptr<Node> source, std::shared_ptr<Node> sink) {

	int numNodes = graph.size();
	source->setColor(Node::gray);
	std::queue<std::shared_ptr<Node>> queue;
	queue.push(source);
	while (!queue.empty()) {
		std::shared_ptr<Node> currentNode = queue.front();
		queue.pop();
		for (unsigned int i = 0; i < currentNode->neighbors.size(); i++) {
			std::shared_ptr<Node> neighbor = currentNode->neighbors[i];
			if (graph.getEdgeWeight(currentNode, neighbor) > 0 && neighbor->getColor() == Node::white) {
				neighbor->setColor(Node::gray);
				neighbor->setParent(currentNode);
				queue.push(neighbor);
			}
		}
		currentNode->setColor(Node::black);
	}
	// If a path to sink was found, return true
	return (sink->getColor() == Node::black);
}


/*
 	Remove match between block and item.
*/
void Matcher::removeMatch(std::shared_ptr<Node> bNode, std::shared_ptr<Node> iNode) {
	
	std::shared_ptr<ItemNode> itemNode = std::static_pointer_cast<ItemNode>(iNode);

	// For all of the item's current matches, find the block and remove it
	for (int i = 0; i < itemNode->matches.size(); i++) {
		if (itemNode->matches[i]->ID() == std::static_pointer_cast<BlockNode>(bNode)->ID()) {
			// TODO: Break early?
			itemNode->matches.erase(itemNode->matches.begin() + i);
		}
	}
}


/*
 	Get the item to slot matches from the graph. Format the data in JSON in order
 	to be returned and displayed on website
*/
void Matcher::findMatches() {
	std::map<BlockNode*, std::vector<DupNode*>> printSchedule;
	std::vector<int> notMatchedOutput;
	std::ostringstream output;
	
	for (auto itemNode:graph.itemNodes) {
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
	for (auto blockNode:graph.blockNodes) {
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


/*
 	Helper function to format JSON properly
*/
void Matcher::stripTrailingComma(std::ostringstream& oss) {
	std::string s = oss.str();
	if (s[s.length()-1] == ',') {
		s.erase(s.length()-1);
	}
	oss.str("");
	oss << s;
}


/*
 	Given CSV data for edges and slots, fill the graph with nodes and edges
*/
void Matcher::fillGraph(char* edgesPath, char* slotsPath) {
	readEdgeFile(edgesPath);
	readSlotFile(slotsPath);
}


/*
	Import CSV file containing edge information
*/
void Matcher::readEdgeFile(char* fp) {
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

			graph.addEdges(std::stoi(itemID), std::stoi(numDups), std::stoi(blockID), std::stoi(numSlots));
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	file.close();
}


/*
	Import CSV file containing slot information
*/
void Matcher::readSlotFile(char* fp) {
	std::fstream file(fp, std::fstream::in);
	if (file.is_open()) {
		std::string line;
		while (getline(file, line)) {
			std::stringstream ss(line);

			std::string slotID, slotNumber;

			std::getline(ss, slotID, ',');
			std::getline(ss, slotNumber, ',');

			graph.addBlock(std::stoi(slotID), std::stoi(slotNumber));
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	file.close();
}