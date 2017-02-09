@extends('layouts.layout')

@section('head')
<link href="/css/blog.css" rel="stylesheet">
@stop

@section('content')
<div class="position-ref m-lr-md">
	<h3>New Post</h3>
	<form method="post" action="/blog">
		<label>Title</label><br>
		<input type="text" name="title" /><br>
		<label>Content</label><br>
		<textarea name="content" rows="10" cols="120"></textarea><br>
		<label>Category</label><br>
		<select name="category">
			<option name="restaurant">restaurant</option>
			<option name="recipe">recipe</option>
			<option name="book">book</option>
		</select><br><br>
		<input name="Submit" type="submit">
	</form>
</div>
@stop