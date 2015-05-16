<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Impresion de orden - Bendita Tentacion</title>

        <meta name="description" content="Panel de administracion para GA Comunicacion y clientes de la misma">
        <meta name="author" content="Ricardo Madrigal Rodriguez">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        {{ HTML::style('css/bootstrap.min.css') }}

        <!-- Related styles of various icon packs and plugins -->
        {{-- HTML::style('css/plugins.css') --}}

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        {{ HTML::style('css/main.css') }}

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        {{-- HTML::style('css/themes.css') --}}
        <!-- END Stylesheets -->

        <!-- Estilos personalizados -->
        @yield('styles')

        <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        {{ HTML::script('js/vendor/modernizr-2.7.1-respond-1.4.2.min.js') }}
        <script type="text/javascript">var base_path="{{ URL::to("/") }}";</script>
    </head>
    <!-- In the PHP version you can set the following options from inc/config file -->
    <!--
        Available body classes:

        'page-loading'      enables page preloader
    -->
    <body>
        
        <div id="page-container" class="sidebar-no-animations">

            <!-- Main Container -->
            <div id="main-container">

                <!-- Page content -->
                @yield('content')
                <!-- END Page Content -->

            </div>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="{{ URL::to('js/vendor/jquery-1.11.1.min.js') }}"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        {{ HTML::script('js/vendor/bootstrap.min.js') }}
        {{ HTML::script('js/plugins.js') }}
        {{ HTML::script('js/d3.commons.js') }}
        {{ HTML::script('js/app.js') }}

        @yield('scripts')
    </body>
</html>
