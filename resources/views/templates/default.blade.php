<!doctype html>
<html lang="{{ config('app.locale') }}" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <html>
<body>
<header>
    <nav>
        <div class="nav-wrapper">
            <ul>
                <li><a href="{{url('/')}}">User</a></li>
                <li><a href="{{url('/tasks')}}">Tasks</a></li>
            </ul>
        </div>
    </nav>
</header>

@yield('content')

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>
<script src="{{url('js/task.js')}}"></script>

@yield('script')

</html>