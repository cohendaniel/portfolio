@extends('layouts.layout')

@section('head')
<link href="/css/blog.css" rel="stylesheet">
@stop

@section('content')

<div class="position-ref">
    <div class="row container">
    	<div class="col-md-2">
    		<ul class="list">
        		<li><a href="/#" class="font-xs no-margin"><em>vertical menu</em></a></li>
        		<li><a href="/#" class="font-xs no-margin"><em>vertical menu</em></a></li>
        	</ul>
        </div>
        <div class="col-md-10 m-t-md">
        	<h2 id="post-title" class="align-center">{{ $post->title }}</h2>
        	<img id="post-image" src="..\img\me2.jpg" height="200px">
	        <div id="post-content" class="font-xs align-left">
	        	{{ $post->content }}
	        </div>
	    </div>
    </div>
</div>
@stop