@extends('layouts.layout')
@section('content')
<div class="text-center">
    <h1 class="title font-lg">Projects</h1>
    <h4 class="font-sm">An overview of computer science projects I have worked on</h4>
</div>
<div class="container">
    <div class="row m-t-lg">
        <div class="col-md-4">
            <img src="img\project1.png" height="250px">
        </div>
        <div class="col-md-8">
            <p class="font-md">
                Through a summer fellowship at Bowdoin College, I developed and designed an algorithm to <b>schedule tour guides</b> for the admissions office (see <b><a href="poster presentation" class="text-primary">poster</a></b>). In my own time, I experimented with applying AI techniques to improve the algorithm. I have generalized the scheduling algorithm and am currently working on a web application.
            </p>
        </div>
    </div>
    <div class="row m-t-lg">
        <div class="col-md-8">
            <p class="font-md">
                As part of a final project in <em>Nature Inspired Computation</em>, my group and I explored the use of <b>Ant Colony Optimization</b> to build efficient <b>neural network</b> structures (minimizing the size of the network without compromising network performance).
            </p>
        </div>
        <div class="col-md-4">
            <img src="img\ant.png" height="250px">
        </div>
    </div>
    <div class="row m-t-lg">
        <div class="col-md-4">
            <img src="img\mpi.png" height="250px">
        </div>
        <div class="col-md-8">
            <p class="font-md">
                During the Spring 2015 semester at Bowdoin College, I taught myself and a professor <b>MPI</b> (Message Passing Interface) standards, leveraging the power of a high performance computing grid, in order to execute complex computational geometry programs. My work resulted in significant speed increases. 
            </p>
        </div>
    </div>
    <div class="row m-t-lg">
        <div class="col-md-12"></div>
    </div>
</div>
@stop