#include "catch.hpp"
#include <string>

#include "../node.h"

TEST_CASE( "Checking ID counter", "[node]") {

	Node n = Node();
	Node m = Node();

	REQUIRE( n.ID() == 0 );
	REQUIRE( m.ID() == 1 );

}

TEST_CASE( "Checking Date Formatting", "[node]") {

	std::string dtStart = "2004-Jan-01 05:00:00";
	std::string dtEnd = "2004-Jan-01 06:00:00";
	//BlockNode n = BlockNode(1, 2, dtStart, dtEnd);

	std::stringstream ss(dtStart);

	boost::posix_time::ptime a;

	ss >> a;
	
	std::stringstream ss2(dtEnd);

	boost::posix_time::ptime b;

	ss2 >> b;

	boost::posix_time::time_period n(a,b);

	std::cout << n << std::endl;

	REQUIRE (n.begin().date().year() == 2004);

}