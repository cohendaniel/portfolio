#include "catch.hpp"

#include "../node.h"
#include "../graph.h"
#include "../matcher.h"
#include "../timetable.h"

// TEST_CASE( "Small test", "[timetable]") {

// 	Matcher matcher(13, "tests/test-small-edge.csv", "tests/test-small-slot.csv");

// 	matcher.makeSchedule();

// 	matcher.findMatches();

// }

TEST_CASE( "Bigger test", "[timetable]") {

	Matcher matcher(5526, "tests/test-edges.csv", "tests/test-slots.csv");

	matcher.makeSchedule();

	matcher.findMatches();

}