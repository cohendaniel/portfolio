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

void makeSchedule(Graph &graph);
bool BFS(Graph &graph, std::shared_ptr<Node> source, std::shared_ptr<Node> sink);
void removeMatch(std::shared_ptr<Node> bNode, std::shared_ptr<Node> iNode);
