<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'Foobooks')
    </title>

    <meta charset='utf-8'>

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <!-- <link href="/css/gallery.css" type='text/css' rel='stylesheet'> -->

    @stack('head')

</head>
<body>

    <div id='content' style="position:relative;text-align:center">
        @if(Session::get('message') != null)
            <div class='message'>{{ Session::get('message') }}</div>
        @endif

        <header>
            

                <nav>
                    <ul>
                        @if(Auth::check())
                            <li><a href='/'>Home</a></li>
                            <li><a href='/search'>Search</a></li>
                            <li><a href='/gallery/new'>Add a drawing</a></li>
                            <li>
                                <form method='POST' id='logout' action='/logout'>
                                    {{csrf_field()}}
                                    <a href='#' onClick='document.getElementById("logout").submit();'>Logout</a>
                                </form>
                            </li>
                        @else
                            <li><a href='/'>Home</a></li>
                            <li><a href='/login'>Login</a></li>
                            <li><a href='/register'>Register</a></li>
                        @endif
                    </ul>
                </nav>

            </header>

            <section>
                @yield('content')
            </section>


        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="/js/foobooks.js"></script>

        @stack('body')

    </body>
    </html>
