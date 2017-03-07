/*
 *  Implements standard BFS algorithm for use within the 
 *  Ford-Fulkerson algorithm for bipartite matching.
 *
 *  Created on: Oct 31, 2015
 *  Author: Daniel Cohen
 */
#include "matcher.h"
#include "graph.h"
#include <iostream>

/* Basic implementation of the Ford Fulkerson algorithm specific
 * to bipartite matching. References the items data structure, which
 * does not currently make it general. This is necessary for multiple tour
 * handling.
 */

void makeSchedule(Graph &graph) {
	// While there exists a path from the source to the sink.
	while (BFS(graph, graph.source, graph.sink)) {
		// Retrace the path, update (reverse) flows
		for (std::shared_ptr<Node> n = graph.sink; n->ID() != graph.source->ID(); n = n->parent()) {
			std::shared_ptr<Node> p = n->parent();
			if (p->getType() == Node::item && n->getType() == Node::block) {
				std::static_pointer_cast<ItemNode>(p)->matches.push_back(std::static_pointer_cast<BlockNode>(n));
			}
			if (p->getType() == Node::block && n->getType() == Node::item) {
				removeMatch(p, n);
			}
			graph.setEdgeWeight(n, p, 1);
			graph.setEdgeWeight(p, n, 0);
		}
		graph.resetColor();
	}
}

/* Basic implementation of BFS. Returns true if path from source to sink
 * was found. Takes in vector parameter parent that will store the path from
 * source to sink.
 */
bool BFS(Graph &graph, std::shared_ptr<Node> source, std::shared_ptr<Node> sink) {
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
	return (sink->getColor() == Node::black);
}

void removeMatch(std::shared_ptr<Node> bNode, std::shared_ptr<Node> iNode) {
	std::shared_ptr<ItemNode> itemNode = std::static_pointer_cast<ItemNode>(iNode);
	for (int i = 0; i < itemNode->matches.size(); i++) {
		if (itemNode->matches[i]->ID() == std::static_pointer_cast<BlockNode>(bNode)->ID()) {
			itemNode->matches.erase(itemNode->matches.begin() + i);
		}
	}
}




