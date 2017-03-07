#include "node.h"

Node::Node() {
	nID = nodeCounter++;
	nParent = NULL;
	nColor = white;
}

int Node::ID() {
	return nID;
}

std::shared_ptr<Node> Node::parent() {
	return nParent;
}

void Node::setParent(std::shared_ptr<Node> parent) {
	nParent = parent;
}

Node::color Node::getColor() {
	return nColor;
}

void Node::setColor(Node::color c) {
	nColor = c;
}

Node::type Node::getType() {
	return nType;
}

void Node::initNodeID() {
	nodeCounter = 0;
}

DupNode::DupNode(std::shared_ptr<ItemNode> itemNode) {
	nItemNode = itemNode;
	nType = dup;
}

ItemNode* DupNode::getItemNode() {
	return nItemNode.get();
}

ItemNode::ItemNode(int id) {
	eID = id;
	nType = Node::type::item;
}

BlockNode::BlockNode(int id, int n) {
	eID = id;
	nType = Node::type::block;
	numSlots = n;
}

SlotNode::SlotNode(std::shared_ptr<BlockNode> blockNode) {
	nBlockNode = blockNode;
	nType = slot;
}