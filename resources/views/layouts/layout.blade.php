<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Daniel Cohen</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->       
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- Header overrides -->
        @yield('head')
        
    </head>
    <body>
        <!-- {{Auth::user()}} -->
        <div id="wrapper" class="full-height">
            <nav class="navbar navbar-default">
                <div id="logo">
                    <a href="{{ url('/') }}">DANIEL COHEN</a>
                </div>
                <div class="container-fluid pull-right">
                    <ul class="nav navbar-nav links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="mailto:danielcohen376@gmail.com">Contact</a></li>
                    </ul>
                </div>
            </nav>
            @yield('content')
        </div>
        <footer class="flex-center">
            <ul>
                <li>Email: danielcohen376@gmail.com</li>
                <li><a href="https://www.linkedin.com/in/daniel-cohen-27b507a1">LinkedIn</a></li>
            </ul>
        </footer>
        @yield('footer')
    </body>
</html>