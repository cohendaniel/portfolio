<?php

namespace Timetable\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    
    public function index() {
        return view('Timetable::welcome');
    }

}
