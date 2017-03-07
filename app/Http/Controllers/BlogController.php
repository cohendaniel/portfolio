<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except('show');
    }

    function show(Post $post) {
    	return view('blog.show', compact('post'));
    }

    function admin() {
    	return view('blog.admin');
    }

    function create(Request $request) {
    	$post = new Post($request->all());

    	$post->save();

    	return back();
    }
}
