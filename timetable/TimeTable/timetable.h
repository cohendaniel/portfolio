#pragma once

void initConstants(int d, int i, int b, int s);
void fillGraph(Graph &g, char* edgesPath, char* slotsPath);
void findMatches(Graph &g);
void readEdgeFile(char* fp, Graph &g);
void readSlotFile(char* fp, Graph &g);

void stripTrailingComma(std::ostringstream& oss);