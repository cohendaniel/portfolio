#include "catch.hpp"

#include "../node.h"

TEST_CASE( "Checking ID counter", "[node]") {

	Node n = Node();
	Node m = Node();

	REQUIRE( n.ID() == 0 );
	REQUIRE( m.ID() == 1 );

}