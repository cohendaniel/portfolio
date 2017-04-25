CFLAG=-std=c++11
BOOSTPATH=-I /c/boost_1_64_0/boost_1_64_0

all: timetable

tests: test-small

timetable: timetable.o graph.o node.o matcher.o
	g++ $(CFLAG) $(BOOSTPATH) timetable.o graph.o matcher.o node.o -o timetable

timetable.o: timetable.cpp timetable.h
	g++ $(CFLAG) $(BOOSTPATH) -c timetable.cpp

graph.o: graph.cpp graph.h
	g++ $(CFLAG) $(BOOSTPATH) -c graph.cpp

matcher.o: matcher.cpp
	g++ $(CFLAG) $(BOOSTPATH) -c matcher.cpp

node.o: node.cpp node.h
	g++ $(CFLAG) $(BOOSTPATH) -c node.cpp

test-small: node.o graph.o matcher.o tests/test-main.o tests/test-small.cpp
	g++ $(CFLAG) $(BOOSTPATH) node.o graph.o matcher.o tests/test-main.o tests/test-small.cpp -o tests/tests

clean: 
	rm *.o *.exe