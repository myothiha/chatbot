<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Miss Migration</a>
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
