@extends('layouts.layout')

@section('head')
	<link href="/css/vis.css" rel="stylesheet">
	<script src="/js/vis.js"></script>
@stop

@section('content')
<div class="position-ref three-quarter-height">
	<div>
		<h2>Are they friends?</h2>
	</div>
	<div class="col-md-6">
		<form>
			<select id="senator1">
				@foreach ($nodes as $node)
				<option value="{{ $node['id'] }}">{{ $node['title'] }}</option>
				@endforeach
			</select>
		</form>
	</div>
	<div class="col-md-6">
		<form>
			<select id="senator2">
				@foreach ($nodes as $node)
				<option value="{{ $node['id'] }}">{{ $node['title'] }}</option>
				@endforeach
			</select>
		</form>
	</div>
	<div id="answer">
		
	</div>
</div>
@stop

@section('footer')
<script>

$(document).ready(function() {
	
	var edges = {!! json_encode($edges) !!};

	$('#senator1, #senator2').on('change', function() {

		$('#answer').html('');
		console.log("changed");
		var s1 = $('#senator1').val();
		var name1 = $('#senator1 option:selected').text();
		var s2 = $('#senator2').val();
		var name2 = $('#senator2 option:selected').text();

		for (var i = 0; i < edges.length; i++) {
			if (edges[i]['to'] == s1 && edges[i]['from'] == s2) {
				$('#answer').append("<p>"+name2+" follows " + name1+"</p>");
			}
			if (edges[i]['to'] == s2 && edges[i]['from'] == s1) {
				$('#answer').append("<p>"+name1+" follows " + name2+"</p>");
			}
		}
	})

});

</script>
@stop