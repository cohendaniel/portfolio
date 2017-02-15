@extends('layouts.layout')

@section('head')
	<link href="/css/vis.css" rel="stylesheet">
	<script src="/js/vis.js"></script>
@stop

@section('content')
<div class="col-md-4">
	<div id="info">
		<p>
			I love networks. Recently, I wondered if U.S. Senators show each other more virtual love than what we read in the news, so I decided to graph it by showing who follows who on Twitter.
		</p>
		<p>
			Pulling data from the Twitter API was more challenging than expected given the rate limits on the number of queries. However, after finding some workarounds, I obtained the necessary data and used the vis.js library to display the network. Making it so the right nodes and edges appear upon clicking a node was not incredibly straightforward, but it was an exciting challenge.
		</p>
		<p>
			<em><b>How bipartisan is the U.S. Senate on Twitter? Click the nodes to find out!</b></em>
		</p>
		<p>
			Next steps: UI tweaks to make the graph prettier (e.g. position the nodes more cleanly).
		</p>
	</div>
</div>
<div class="col-md-8">
	<div class="d-flex">
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-primary active" id="following">
			 	<input type="radio" name="options" id="btn1" autocomplete="off" checked> Following
			</label>
			<label class="btn btn-primary" id="followers">
			    <input type="radio" name="options" id="btn2" autocomplete="off"> Followers
			</label>
		</div>
		<div class="font-md">
			<b><span id="senator-name"></span></b>
		</div>
		<div class="font-sm">
			<span><b>Dem:</b> <span id="dem">0</span></span>
			<span><b>Rep:</b> <span id="rep">0</span></span>
			<span><b>Ind:</b> <span id="ind">0</span></span>
		</div>
	</div>
	<div id="network">
		
	</div>
</div>

@stop

@section('footer')
<script type="text/javascript">

function redraw() {
	var nodes = new vis.DataSet({!! json_encode($nodes) !!});
	var edges = new vis.DataSet({!! json_encode($edges) !!});

	var container = document.getElementById('network');

	var data = {
		nodes: nodes,
		edges: edges
	}

	var options = {
		nodes: {
	        shape: 'dot',
	        size: 5,
	        borderWidth: 0.5,
	        chosen: true,
	        physics: false,
    	},
    	groups: {
    		D: {
    			color: 'blue'
    		},
    		R: {
    			color: 'red'
    		},
    		I: {
    			color: 'green'
    		}
    	},
    	edges: {
    		arrows: {
    			to: {enabled: true, type: 'arrow', scaleFactor: 0.2}
    		},
    		width: 0.2,
    		selectionWidth: function(width) {return width;},
    		smooth: false,
    		color: {inherit: false}
    	},
    	layout: {
    		improvedLayout: false,
    		randomSeed: 95,
    	},
    	interaction: {
    		tooltipDelay: 100
    	},
		physics: {

		}
	};

	var network = new vis.Network(container, data, options);

	var allEdges = edges.get({returnType:"Object"});
	var allNodes = nodes.get({returnType:"Object"});


	network.on('selectNode', function(event) {
		
		var selectedNode = event.nodes[0];
		$('#senator-name').html(allNodes[selectedNode].title);

		var hidden = 'rgba(200,200,200,0.4)';
		var counts = {numDem: 0, numRep: 0, numInd: 0};

		// set all nodes to hidden
		for (var node in allNodes) {
			allNodes[node].color = hidden;
		}

		// set all edges to hidden
		for (var edge in allEdges) {
			allEdges[edge].color = {inherit: false, opacity: 0};
		}

		var connectedEdges = network.getConnectedEdges(selectedNode);

		// get nodes the selected node is following
		// note that edge ids are formatted: "from_id"+"to_id"
		if ($("#following").hasClass('active')) {
			for (i = 0; i < connectedEdges.length; i++) {
				var e = allEdges[connectedEdges[i]];
				var n = network.getConnectedNodes(e.id);
				if (e.id == selectedNode+n[1]) {
					e.color = {inherit: 'to', opacity: 1};
					allNodes[n[1]].color = undefined;
					countParty(allNodes[n[1]], counts);
				}
				allNodes[selectedNode].color = undefined;
			}
		}
		// get nodes that follow the selected node
		// note that edge ids are formatted: "from_id"+"to_id"
		else {
			for (i = 0; i < connectedEdges.length; i++) {
				var e = allEdges[connectedEdges[i]];
				var n = network.getConnectedNodes(e.id);
				if (e.id == n[0]+selectedNode) {
					e.color = {inherit: 'from', opacity: 1};
					allNodes[n[0]].color = undefined;
					countParty(allNodes[n[0]], counts);
				}
				allNodes[selectedNode].color = undefined;
			}
		}
		
		
		var updateNodes = [];
		var updateEdges = [];
		for (node in allNodes) {
			updateNodes.push(allNodes[node]);
		}
		for (edge in allEdges) {
			updateEdges.push(allEdges[edge]);
		}
		nodes.update(updateNodes);
		edges.update(updateEdges);

		$('#dem').html(counts.numDem);
		$('#rep').html(counts.numRep);
		$('#ind').html(counts.numInd);
	});

	network.moveTo({
		position: {x: 0, y:20},
		scale: 2
	});
}

function countParty(node, counts) {
	if (node.group == "D") {
		//console.log(node);
		counts.numDem++;
	}
	else if (node.group == "R") {
		counts.numRep++;
	}
	else {
		counts.numInd++;
	}

	return;
}

redraw();

</script>
@stop