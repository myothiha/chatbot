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

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="/css/modern-business.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
@include('admin.layouts.nav')

{{--<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div class="carousel-item active" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>First Slide</h3>
                    <p>This is a description for the first slide.</p>
                </div>
            </div>
            <!-- Slide Two - Set the background image for this slide in the line below -->
            <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Second Slide</h3>
                    <p>This is a description for the second slide.</p>
                </div>
            </div>
            <!-- Slide Three - Set the background image for this slide in the line below -->
            <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Third Slide</h3>
                    <p>This is a description for the third slide.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>--}}

<!-- Page Content -->
<div class="container">

    <div class="row mt-4">
        <h1 >
            @yield('heading')
            <small>@yield('subheading')</small>
        </h1>
    </div>
    <div class="row">
        <ol class="breadcrumb">
            @yield('breadcrumb')
        </ol>
    </div>

    @yield('content')
</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>

</html>
