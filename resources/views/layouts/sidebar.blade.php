        <header class="s-header">

            <div class="header__top">
                <div class="header__logo">
                    <a class="site-logo" href="{{ route('home') }}">
                        <img src="{{ asset('/') }}images/logo.svg" alt="Homepage">
                    </a>
                </div>

                <div class="header__search">

                    <form role="search" method="get" class="header__search-form" action="#">
                        <label>
                            <span class="hide-content">Search for:</span>
                            <input type="search" class="header__search-field" placeholder="Type Keywords"
                                value="" name="s" title="Search for:" autocomplete="off">
                        </label>
                        <input type="submit" class="header__search-submit" value="Search">
                    </form>

                    <a href="#0" title="Close Search" class="header__search-close">Close</a>

                </div> <!-- end header__search -->

                <!-- toggles -->
                <a href="#0" class="header__search-trigger"></a>
                <a href="#0" class="header__menu-toggle"><span>Menu</span></a>

            </div> <!-- end header__top -->

            <nav class="header__nav-wrap">

                <ul class="header__nav">
                    <li class="current"><a href="{{ route('home') }}" title="">Home</a></li>
                    <li class="has-children">
                        <a href="{{ route('home') }}" title="">Blog Posts</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('posts.create') }}">Create Post</a></li>
                            <li><a href="{{ route('posts.index') }}">My Posts</a></li>
                        </ul>
                    </li>
                    <li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    

                </ul> <!-- end header__nav -->

            </nav> <!-- end header__nav-wrap -->

        </header> <!-- end s-header -->
