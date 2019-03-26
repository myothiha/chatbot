<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Miss Migration - @yield('title')</title>

    <!-- Custom Style -->
    <link href="/css/style.css" rel="stylesheet">
    <link rel="icon" href="/img/logo.png" type="image/x-icon"/>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="/css/modern-business.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="/img/logo.png" class="logo" />Miss Migration</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @if( \Illuminate\Support\Facades\Auth::user() )
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->is('questions/*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ action('QuestionController@index', 0) }}">Bot Data Entry</a>
                    </li>
                    <li class="nav-item {{ request()->path() }} {{ request()->is('conversations') ? 'active' : 'aaa' }}">
                        <a class="nav-link" href="{{ action('ConversationController@index') }}">Messages</a>
                    </li>
                    <li class="nav-item {{ request()->path() }} {{ request()->is('broadcast') ? 'active' : 'aaa' }}">
                        <a class="nav-link" href="{{ action('BroadcastController@getBroadcast') }}">Broadcast</a>
                    </li>
                    <li class="nav-item {{ request()->path() }} {{ request()->is('users') ? 'active' : 'aaa' }}">
                        <a class="nav-link" href="{{ action('UserController@index') }}">Users</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {{ \Illuminate\Support\Facades\Auth::user()->name ?? '' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                            <a class="dropdown-item" href="{{ action('LoginController@logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        @endIf
    </div>
</nav>


<!-- Page Content -->
<div class="container content">

    <div class="row mt-4">
        <h1>
            @yield('heading')
            <small>@yield('subheading')</small>
        </h1>
    </div>
    <div class="row">
            @yield('breadcrumb')
    </div>

    @yield('content')
</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Miss Migration {{ \Carbon\Carbon::now()->year }}</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>

</html>
