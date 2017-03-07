@extends('layouts.layout')

@section('content')

<h1>Beercheese Admin</h1>
<div class="d-flex">
	<form method="post" action="/beercheese/admin/beers">
		<h2>Create new beer</h2>
		<input type="text" name="brewery" placeholder="Brewery"><br/>
		<input type="text" name="name" placeholder="Name" /><br/>
		<input type="text" name="type" placeholder="Type" /><br/>
		<input type="textarea" name="comments" placeholder="Comments"><br/>
		<input type="file" name="image" placeholder="Image" /><br/>
		<input type="submit" />
	</form>
	<form method="post" action="/beercheese/admin/cheeses">
		<h2>Create new cheese</h2>
		<input type="text" name="maker" placeholder="Maker"><br/>
		<input type="text" name="name" placeholder="Name" /><br/>
		<input type="text" name="type" placeholder="Type" /><br/>
		<input type="textarea" name="comments" placeholder="Comments"><br/>
		<input type="file" name="image" placeholder="Image" /><br/>
		<input type="submit" />
	</form>
	<form method="post" action="/beercheese/admin/pairs">
		<h2>Create new pairing</h2>
		<select name="beerName">
			@foreach ($beers as $beer)
				<option> {{ $beer->name }} </option>
			@endforeach
		</select>
		<select name="cheeseName">
			@foreach ($cheeses as $cheese)
				<option> {{ $cheese->name }} </option>
			@endforeach
		</select>
		<input type="textarea" name="comments" placeholder="Comments"><br/>
		<input type="submit" />
	</form>
</div>
@stop