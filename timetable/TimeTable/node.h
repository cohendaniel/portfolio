#pragma once

#include <vector>
#include <memory>
#include <sstream>
#include <string>

#include "boost/date_time/posix_time/posix_time.hpp"
#include "boost/date_time/gregorian/gregorian.hpp"

class Node;
class DupNode;
class ItemNode; 
class BlockNode; 
class SlotNode;

namespace pt = boost::posix_time;

class Node {
public:
	
	std::vector<std::shared_ptr<Node>> neighbors;
	enum color {white, gray, black};
	enum type {dup, item, block, slot};

	int eID;
	
	Node();

	int ID();
	
	std::shared_ptr<Node> parent();
	void setParent(std::shared_ptr<Node>);
	
	Node::color getColor();
	void setColor(color c);
	
	Node::type getType();


protected:
	static int nodeCounter;
	int nID;
	std::shared_ptr<Node> nParent;
	color nColor;
	type nType;
};


class BlockNode : public Node {

	public:
		BlockNode(int id, int n, pt::ptime dtStart, pt::ptime dtEnd) :
				dt(dtStart, dtEnd), numSlots(n) 
				{
					eID = id;
					nType = Node::type::block;
				}

		std::vector<std::shared_ptr<BlockNode>> overlaps;
		int numSlots;

		pt::time_period dt;

};

class SlotNode : public Node {
	public:
		SlotNode(std::shared_ptr<BlockNode> blockNode);
	
	private:
		std::shared_ptr<BlockNode> nBlockNode;
};

class ItemNode : public Node {
	public:
		ItemNode(int id);
		std::vector<std::shared_ptr<BlockNode>> matches;
		std::vector<std::shared_ptr<DupNode>> dups;
};

class DupNode : public Node {
	public:
		DupNode(std::shared_ptr<ItemNode> itemNode);
		ItemNode* getItemNode();
	private:
		std::shared_ptr<ItemNode> nItemNode;
};