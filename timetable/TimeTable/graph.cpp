#include "graph.h"

Graph::Graph(int numNodes) {
	numNodes_ = numNodes;
	for (int i = 0; i < numNodes_; i++) {
		std::vector<int> row(numNodes_);
		graph.push_back(row);
	}
	source = std::shared_ptr<Node>(new Node);
	sink = std::shared_ptr<Node>(new Node);
}


void Graph::addEdges(int itemID, int numDups, int blockID, int numSlots) {
	
	std::shared_ptr<ItemNode> itemNode = addItem(itemID, numDups);
	std::shared_ptr<BlockNode> blockNode = addBlock(blockID, numSlots);

	addEdge(itemNode, blockNode);
}

std::shared_ptr<ItemNode> Graph::addItem(int id, int numDups) {

	auto it = std::find_if(itemNodes.begin(), itemNodes.end(), [=](std::shared_ptr<ItemNode> n) {
		return id == n->eID;
	});

	if (it == itemNodes.end()) {
		std::shared_ptr<ItemNode> newItemNode(new ItemNode(id));
		itemNodes.push_back(newItemNode);
		addDups(newItemNode, numDups);
		return newItemNode;
	}
	else {
		return *it;
	}
}

void Graph::addDups(std::shared_ptr<ItemNode> itemNode, int numDups) {
	for (int i = 0; i < numDups; i++) {
		std::shared_ptr<DupNode> newDupNode(new DupNode(itemNode));
		addEdge(newDupNode, itemNode);
		addEdge(source, newDupNode);
		dupNodes.push_back(newDupNode);
		itemNode->dups.push_back(newDupNode);
	}
}

std::shared_ptr<BlockNode> Graph::addBlock(int id, int numSlots) {
	
	auto it = std::find_if(blockNodes.begin(), blockNodes.end(), [=](std::shared_ptr<BlockNode> n) {
		return id == n->eID;
	});

	if (it == blockNodes.end()) {
		std::shared_ptr<BlockNode> newBlockNode(new BlockNode(id, numSlots));
		blockNodes.push_back(newBlockNode);
		addSlots(newBlockNode, numSlots);
		return newBlockNode;
	}
	else {
		return *it;
	}

}

void Graph::addSlots(std::shared_ptr<BlockNode> blockNode, int numSlots) {
	for (int i = 0; i < numSlots; i++) {
		std::shared_ptr<SlotNode> newSlotNode(new SlotNode(blockNode));
		addEdge(blockNode, newSlotNode);
		addEdge(newSlotNode, sink);
		slotNodes.push_back(newSlotNode);
	}
}

void Graph::addEdge(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo) {
	graph[nodeFrom->ID()][nodeTo->ID()] = 1;
	nodeFrom->neighbors.push_back(nodeTo);
	nodeTo->neighbors.push_back(nodeFrom);
}

int Graph::getEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo) {
	return graph[nodeFrom->ID()][nodeTo->ID()];
}

void Graph::setEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo, int weight) {
	graph[nodeFrom->ID()][nodeTo->ID()] = weight;
}

void Graph::resetColor() {
	for (int i = 0; i < dupNodes.size(); i++) {
		dupNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < itemNodes.size(); i++) {
		itemNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < blockNodes.size(); i++) {
		blockNodes[i]->setColor(Node::white);
	}
	for (int i = 0; i < slotNodes.size(); i++) {
		slotNodes[i]->setColor(Node::white);
	}
	source->setColor(Node::white);
	sink->setColor(Node::white);
}

int Graph::size() {
	return numNodes_;
}

void Graph::printGraph() {
	for (unsigned int i = 0; i < graph.size(); i++) {
		for (unsigned int j = 0; j < graph.size(); j++) {
			std::cout << graph[i][j] << " ";
		}
		std::cout << "</br>";
	}
}