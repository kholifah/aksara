<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
    <head>
        <title>Personal Blog a Blogging Category Flat Bootstarp  Responsive Website Template | Home :: w3layouts</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Personal Blog Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />

        {{-- <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />        --}}
        {{-- <link href="css/style.css" rel='stylesheet' type='text/c        ss' /> --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="        anonymous">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        {{-- webfonts --}}

        <link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic' rel='stylesheet' type='text/css'>

        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
        <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>


        {{-- end slider --}}
        {{-- script --}}
        {{-- <script type="text/javascript" src="js/move-top.js"></script> --}}
        {{-- <script type="text/javascript" src="js/easing.js"></script> --}}

        <script type="text/javascript" src="{{ asset('assets/js/move-top.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/easing.js') }}"></script>

        <script type="text/javascript">
jQuery(document).ready(function ($) {
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 900);
    });
});
        </script>

    </head>
    <body>

        <!---header---->
        @include('front-end:mino::partials.header')
        <!--/header-->
        @yield('content')

        @include('front-end:mino::partials.footer')
    </body>
</html>
