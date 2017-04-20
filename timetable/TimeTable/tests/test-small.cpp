#include "catch.hpp"

#include "../node.h"
#include "../graph.h"
#include "../matcher.h"
#include "../timetable.h"

TEST_CASE( "Small test", "[timetable]") {

	Matcher matcher(13, "./test-small-edge.csv", "./test-small-slot.csv");

	matcher.makeSchedule();

	matcher.findMatches();

}