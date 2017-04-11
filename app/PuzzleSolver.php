<?php

namespace App;

class BoardNode
{
	public $board = array();
	public $parent = null;
	public $neighbors = array();
	public $id;
	public static $counter = 0;
	
	function __construct($b, $p)
	{
		$this->board = $b;
		$this->parent = $p;
		$this->id = self::$counter++;
	}


	public function setNeighbors() {

		$emptyIdx = array_search(16, $this->board);
		$newBoard = $this->board;
		
		// move empty space up
		for ($i = $emptyIdx; $i >= 4; $i -= 4) {
			$newBoard = $this->swap($newBoard, $i, $i - 4);
			$this->neighbors[] = new BoardNode($newBoard, $this);
		}

		// move empty space down
		$newBoard = $this->board;
		for ($i = $emptyIdx; $i < 12; $i += 4) {
			$newBoard = $this->swap($newBoard, $i, $i + 4);
			$this->neighbors[] = new BoardNode($newBoard, $this);
		}

		//move empty space left
		$newBoard = $this->board;
		for ($i = $emptyIdx; $i > floor($emptyIdx / 4) * 4; $i--) {
			$newBoard = $this->swap($newBoard, $i, $i - 1);
			$this->neighbors[] = new BoardNode($newBoard, $this);
		}

		//move empty space right
		$newBoard = $this->board;
		for ($i = $emptyIdx; $i < 3+(floor($emptyIdx / 4) * 4); $i++) {
			$newBoard = $this->swap($newBoard, $i, $i + 1);
			$this->neighbors[] = new BoardNode($newBoard, $this);
		}

	}

	private function swap($arr, $a, $b) {
		
		$tmp = $arr[$a];
		$arr[$a] = $arr[$b];
		$arr[$b] = $tmp;

		return $arr;
	}

	public function printBoard() {

		for ($i = 0; $i < 4; $i++) {
			for ($j = 0; $j < 4; $j++) {
				echo $this->board[$i*4 + $j]." ";
			}
			echo PHP_EOL;
		}

	}

}

class PuzzleSolver
{
	private $start;
	private $goal;

	function __construct($s)
	{
		$this->start = new BoardNode($s, null);

		$arr = array();
		for ($i = 0; $i < 16; $i++) {
			$arr[$i] = $i + 1;
		}
		$this->goal = new BoardNode($arr, null);
	}

	public function solve() {

		$closedSet = array();

		$openSet = array($this->start->id => $this->start);

		$g = array($this->start->id => 0);

		$f = array($this->start->id => $this->hCost($this->start));

		while (sizeof($openSet) > 0) {

			// get node from open set with minimum heuristic value
			$min = array_keys($f, min($f))[0];
			$curNode = $openSet[$min];
			//echo $f[$min]." = ".$g[$min]." + ".($f[$min] - $g[$min]).PHP_EOL;

			// current state equals goal state
			if ($curNode->board == $this->goal->board) {

				$path = array();
				// trace and return the path
				array_unshift($path, $curNode->board);
				
				while ($curNode->parent != null) {
					$curNode = $curNode->parent;
					array_unshift($path, $curNode->board);
				}

				return $path;
			}

			// remove node from open set, add node to closed set
			unset($openSet[$curNode->id]);
			$closedSet[$curNode->id] = $curNode;

			// find neighbors of current node
			$curNode->setNeighbors();

			foreach ($curNode->neighbors as $neighbor) {

				// node already evaluated
				if ($this->findNode($neighbor, array_values($closedSet))) {
					continue;
				}

				// add new neighbor to open set
				if (!$this->findNode($neighbor, array_values($openSet))) {
					$openSet[$neighbor->id] = $neighbor;
					$g[$neighbor->id] = $g[$curNode->id] + 1;
					$f[$neighbor->id] = $g[$neighbor->id] + $this->hCost($neighbor);
				}

			}

			// remove node from f score so not reconsidered as min
			unset($f[$curNode->id]);

		}

	}

	private function hCost($node) {
		$sum = 0;
		for ($i = 0; $i < sizeof($node->board); $i++) {
			if ($node->board[$i] == 16) {
				continue;
			}
			//echo $i.": ".$this->distance($i, $node->board[$i] - 1).PHP_EOL;
			$sum += $this->distance($i, $node->board[$i] - 1);
		}
		return $sum;
	}

	private function distance($pos, $num) {

		$row = floor($pos / 4);
		
		$col = $pos % 4;

		$goalRow = floor($num / 4);

		$goalCol = $num % 4;

		return abs($row - $goalRow) + abs($col - $goalCol);

	}

	private function findNode($node, $arr) {

		foreach ($arr as $element) {
			if ($node->board == $element->board) {
				return true;
			}
		}
		return false;

	}

}

// $arr = array(
// 			'7', '12', '15', '16',
// 			'4', '8', '10', '1',
// 			'5', '11', '6', '3',
// 			'9', '13', '2', '14'
// 								);

// // $arr = array(
// // 			'2', '5', '7', '3',
// // 			'1', '16', '9', '4',
// // 			'13', '15', '6', '10',
// // 			'14', '12', '11', '8'
// // 								);

// $solver = new PuzzleSolver($arr, null);

// $path = $solver->solve();

// echo sizeof($path)."\n\n";

// print_r($path[0]);


?>