CFLAG=-std=c++11

all: timetable

timetable: timetable.o graph.o node.o matcher.o
	g++ $(CFLAG) timetable.o graph.o matcher.o node.o -o timetable

timetable.o: timetable.cpp timetable.h
	g++ $(CFLAG) -c timetable.cpp

graph.o: graph.cpp graph.h
	g++ $(CFLAG) -c graph.cpp

matcher.o: matcher.cpp
	g++ $(CFLAG) -c matcher.cpp

node.o: node.cpp node.h
	g++ $(CFLAG) -c node.cpp

clean: 
	rm *.o *.exe