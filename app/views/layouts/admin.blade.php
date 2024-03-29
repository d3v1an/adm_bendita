<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Panel de administracion - Bendita Tentacion</title>

        <meta name="description" content="Panel de administracion para GA Comunicacion y clientes de la misma">
        <meta name="author" content="Ricardo Madrigal Rodriguez">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/icon57.png') }}" sizes="57x57">
        <link rel="apple-touch-icon" href="{{ asset('img/icon72.png') }}" sizes="72x72">
        <link rel="apple-touch-icon" href="{{ asset('img/icon76.png') }}" sizes="76x76">
        <link rel="apple-touch-icon" href="{{ asset('img/icon114.png') }}" sizes="114x114">
        <link rel="apple-touch-icon" href="{{ asset('img/icon120.png') }}" sizes="120x120">
        <link rel="apple-touch-icon" href="{{ asset('img/icon144.png') }}" sizes="144x144">
        <link rel="apple-touch-icon" href="{{ asset('img/icon152.png') }}" sizes="152x152">
        <!-- END Icons -->

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="D3 Catalyst">

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        {{ HTML::style('css/bootstrap.min.css') }}

        <!-- Related styles of various icon packs and plugins -->
        {{ HTML::style('css/plugins.css') }}

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        {{ HTML::style('css/main.css') }}

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        {{ HTML::style('css/themes.css') }}
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
        <!-- Preloader -->
        <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
        <!-- Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in body element (HTML version) -->
        <div class="preloader themed-background">
            <h1 class="push-top-bottom text-light text-center"><strong>BT</strong>Administrador</h1>
            <div class="inner">
                <h3 class="text-light visible-lt-ie9 visible-lt-ie10"><strong>Cargando..</strong></h3>
                <div class="preloader-spinner hidden-lt-ie9 hidden-lt-ie10"></div>
            </div>
        </div>
        <!-- END Preloader -->

        <!-- Page Container -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available #page-container classes:

            '' (None)                                       for a full main and alternative sidebar hidden by default (> 991px)

            'sidebar-visible-lg'                            for a full main sidebar visible by default (> 991px)
            'sidebar-partial'                               for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
            'sidebar-partial sidebar-visible-lg'            for a partial main sidebar which opens on mouse hover, visible by default (> 991px)

            'sidebar-alt-visible-lg'                        for a full alternative sidebar visible by default (> 991px)
            'sidebar-alt-partial'                           for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
            'sidebar-alt-partial sidebar-alt-visible-lg'    for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)

            'sidebar-partial sidebar-alt-partial'           for both sidebars partial which open on mouse hover, hidden by default (> 991px)

            'sidebar-no-animations'                         add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!

            'style-alt'                                     for an alternative main style (without it: the default style)
            'footer-fixed'                                  for a fixed footer (without it: a static footer)

            'disable-menu-autoscroll'                       add this to disable the main menu auto scrolling when opening a submenu

            'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
            'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar
        -->
        <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">

            <!-- Main Sidebar -->
            <div id="sidebar">
                <!-- Wrapper for scrolling functionality -->
                <div class="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <!-- Brand -->
                        <a href="{{ URL::to('/'); }}" class="sidebar-brand">
                            <i class="gi gi-flash"></i><strong>BT</strong> Administrador
                        </a>
                        <!-- END Brand -->

                        <!-- User Info -->
                        <div class="sidebar-section sidebar-user clearfix">
                            <div class="sidebar-user-avatar">
                                <a href="{{ URL::to("user/profile") }}">
                                    <img src="{{ asset('img/placeholders/avatars/avatar_default.png') }}" alt="avatar">
                                </a>
                            </div>
                            <div class="sidebar-user-name">{{ Auth::user()->username }}</div>
                            <div class="sidebar-user-links">
                                @if(Auth::user()->role_id <= 1)
                                    <a href="#modal-user-settings" data-toggle="modal" class="enable-tooltip" data-placement="bottom" title="Configuracion"><i class="gi gi-cogwheel"></i></a>
                                @endif
                                <a href="{{ URL::to("logout") }}" data-toggle="tooltip" data-placement="bottom" title="Salir"><i class="gi gi-exit"></i></a>
                            </div>
                        </div>
                        <!-- END User Info -->

                        <!-- Theme Colors -->
                        <!-- Change Color Theme functionality can be found in js/app.js - templateOptions() -->
                        <ul class="sidebar-section sidebar-themes clearfix">
                            <li class="active">
                                <a href="javascript:void(0)" class="themed-background-dark-default themed-border-default" data-theme="default" data-toggle="tooltip" title="Default Blue"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-night themed-border-night" data-theme="/css/themes/night.css" data-toggle="tooltip" title="Night"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-amethyst themed-border-amethyst" data-theme="/css/themes/amethyst.css" data-toggle="tooltip" title="Amethyst"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-modern themed-border-modern" data-theme="/css/themes/modern.css" data-toggle="tooltip" title="Modern"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-autumn themed-border-autumn" data-theme="/css/themes/autumn.css" data-toggle="tooltip" title="Autumn"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-flatie themed-border-flatie" data-theme="/css/themes/flatie.css" data-toggle="tooltip" title="Flatie"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-spring themed-border-spring" data-theme="/css/themes/spring.css" data-toggle="tooltip" title="Spring"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-fancy themed-border-fancy" data-theme="/css/themes/fancy.css" data-toggle="tooltip" title="Fancy"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="themed-background-dark-fire themed-border-fire" data-theme="/css/themes/fire.css" data-toggle="tooltip" title="Fire"></a>
                            </li>
                        </ul>
                        <!-- END Theme Colors -->

                        <!-- Sidebar Navigation -->
                        <ul class="sidebar-nav">
                            
                            <!-- Dashboard -->
                            <li>
                                <a href="{{ URL::to('dashboard') }}" {{ isset($active) && $active=="dashboard"?'class="active"':'' }}><i class="gi gi-signal sidebar-nav-icon"></i>Dashboard</a>
                            </li>
                            <!-- /Dashboard -->
                            
                            <!-- Sistema -->
                            <li class="sidebar-header">
                                <span class="sidebar-header-options clearfix">
                                    <a title="" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Tipo de cambio" id="btn-tipo-cambio"><i class="gi gi-usd"></i></a>
                                </span>
                                <span class="sidebar-header-title">Sistema</span>
                            </li>
                            <li>
                                <a href="{{ URL::to("system/admins") }}" {{ isset($active) && $active=="system/admins"?'class="active"':'' }}><i class="gi gi-user sidebar-nav-icon"></i>Usuarios</a>
                            </li>
                            <!-- /Sistemas -->

                            <!-- Media -->
                            <li class="sidebar-header">
                                <span class="sidebar-header-title">Media</span>
                            </li>
                            <li>
                                <a href="{{ URL::to("media/video") }}" {{ isset($active) && $active=="media/video"?'class="active"':'' }}><i class="gi gi-facetime_video sidebar-nav-icon"></i>Videos</a>
                            </li>
                            <li>
                                <a href="{{ URL::to("media/carrousel") }}" {{ isset($active) && $active=="media/carrousel"?'class="active"':'' }}><i class="gi gi-picture sidebar-nav-icon"></i>Carrusel</a>
                            </li>
                            <!-- /Media -->

                            <!-- Email -->
                            <li class="sidebar-header">
                                <span class="sidebar-header-title">Email</span>
                            </li>
                            <li>
                                <a href="{{ URL::to("email/report") }}" {{ isset($active) && $active=="email/report"?'class="active"':'' }}><i class="gi gi-message_new sidebar-nav-icon"></i>Reporte</a>
                            </li>
                            <!-- /Email -->

                            <!-- Ordenes -->
                            <li class="sidebar-header">
                                <span class="sidebar-header-title">Clientes</span>
                            </li>
                            <li>
                                <a href="{{ URL::to("customer/orders/report") }}" {{ isset($active) && $active=="customer/orders/report"?'class="active"':'' }}><i class="gi gi-cargo sidebar-nav-icon"></i>Ordenes</a>
                            </li>
                            <li>
                                <a href="{{ URL::to("customer/carts/report") }}" {{ isset($active) && $active=="customer/carts/report"?'class="active"':'' }}><i class="gi gi-shopping_cart sidebar-nav-icon"></i>Carritos</a>
                            </li>
                            <li>
                                <a href="{{ URL::to("customer") }}" {{ isset($active) && $active=="customer"?'class="active"':'' }}><i class="gi gi-parents sidebar-nav-icon"></i>Listado</a>
                            </li>
                            <!-- /Ordenes -->

                            <!-- Productos -->
                            <li class="sidebar-header">
                                <span class="sidebar-header-title">Productos</span>
                            </li>
                            <li>
                                <a href="{{ URL::to("products/inventory") }}" {{ isset($active) && $active=="products/inventory"?'class="active"':'' }}><i class="gi gi-package sidebar-nav-icon"></i>Inventario</a>
                            </li>
                            <!-- /Ordenes -->

                        </ul>
                        <!-- END Sidebar Navigation -->

                    </div>
                    <!-- END Sidebar Content -->
                </div>
                <!-- END Wrapper for scrolling functionality -->
            </div>
            <!-- END Main Sidebar -->

            <!-- Main Container -->
            <div id="main-container">
                <!-- Header -->
                <!-- In the PHP version you can set the following options from inc/config file -->
                <!--
                    Available header.navbar classes:

                    'navbar-default'            for the default light header
                    'navbar-inverse'            for an alternative dark header

                    'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                        'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                    'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                        'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                -->
                <header class="navbar navbar-default">
                    <!-- Left Header Navigation -->
                    <ul class="nav navbar-nav-custom">
                        <!-- Main Sidebar Toggle Button -->
                        <li>
                            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                                <i class="fa fa-bars fa-fw"></i>
                            </a>
                        </li>
                        <!-- END Main Sidebar Toggle Button -->

                        <!-- Template Options -->
                        <!-- Change Options functionality can be found in js/app.js - templateOptions() -->
                        <!--
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="gi gi-settings"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-custom dropdown-options">
                                <li class="dropdown-header text-center">Header Style</li>
                                <li>
                                    <div class="btn-group btn-group-justified btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-default">Light</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">Dark</a>
                                    </div>
                                </li>
                                <li class="dropdown-header text-center">Page Style</li>
                                <li>
                                    <div class="btn-group btn-group-justified btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style">Default</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">Alternative</a>
                                    </div>
                                </li>
                                <li class="dropdown-header text-center">Main Layout</li>
                                <li>
                                    <button class="btn btn-sm btn-block btn-primary" id="options-header-top">Fixed Side/Header (Top)</button>
                                    <button class="btn btn-sm btn-block btn-primary" id="options-header-bottom">Fixed Side/Header (Bottom)</button>
                                </li>
                                <li class="dropdown-header text-center">Footer</li>
                                <li>
                                    <div class="btn-group btn-group-justified btn-group-sm">
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-footer-static">Default</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" id="options-footer-fixed">Fixed</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        -->
                        <!-- END Template Options -->
                    </ul>
                    <!-- END Left Header Navigation -->

                    <!-- Search Form -->
                    <form action="#" method="post" class="navbar-form-custom" role="search">
                        <div class="form-group">
                            <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Buscar..">
                        </div>
                    </form>
                    <!-- END Search Form -->

                    <!-- Right Header Navigation -->
                    <ul class="nav navbar-nav-custom pull-right">
                        <!-- Alternative Sidebar Toggle Button -->
                        <!-- d3v1an
                        <li>
                            // If you do not want the main sidebar to open when the alternative sidebar is closed, just remove the second parameter: App.sidebar('toggle-sidebar-alt'); 
                            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt', 'toggle-other');">
                                <i class="gi gi-share_alt"></i>
                                <span class="label label-primary label-indicator animation-floating">4</span>
                            </a>
                        </li>
                        -->
                        <!-- END Alternative Sidebar Toggle Button -->

                        <!-- User Dropdown -->
                        <li class="dropdown">
                            <!-- d3v1an
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('img/placeholders/avatars/avatar_default.png') }}" alt="avatar"> <i class="fa fa-angle-down"></i>
                            </a>
                            -->
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li class="dropdown-header text-center">Account</li>
                                <li>
                                    <a href="page_ready_timeline.html">
                                        <i class="fa fa-clock-o fa-fw pull-right"></i>
                                        <span class="badge pull-right">10</span>
                                        Updates
                                    </a>
                                    <a href="page_ready_inbox.html">
                                        <i class="fa fa-envelope-o fa-fw pull-right"></i>
                                        <span class="badge pull-right">5</span>
                                        Messages
                                    </a>
                                    <a href="page_ready_pricing_tables.html"><i class="fa fa-magnet fa-fw pull-right"></i>
                                        <span class="badge pull-right">3</span>
                                        Subscriptions
                                    </a>
                                    <a href="page_ready_faq.html"><i class="fa fa-question fa-fw pull-right"></i>
                                        <span class="badge pull-right">11</span>
                                        FAQ
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="page_ready_user_profile.html">
                                        <i class="fa fa-user fa-fw pull-right"></i>
                                        Profile
                                    </a>
                                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                                    <a href="#modal-user-settings" data-toggle="modal">
                                        <i class="fa fa-cog fa-fw pull-right"></i>
                                        Settings
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>
                                    <a href="login.html"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
                                </li>
                                <li class="dropdown-header text-center">Activity</li>
                                <li>
                                    <div class="alert alert-success alert-alt">
                                        <small>5 min ago</small><br>
                                        <i class="fa fa-thumbs-up fa-fw"></i> You had a new sale ($10)
                                    </div>
                                    <div class="alert alert-info alert-alt">
                                        <small>10 min ago</small><br>
                                        <i class="fa fa-arrow-up fa-fw"></i> Upgraded to Pro plan
                                    </div>
                                    <div class="alert alert-warning alert-alt">
                                        <small>3 hours ago</small><br>
                                        <i class="fa fa-exclamation fa-fw"></i> Running low on space<br><strong>18GB in use</strong> 2GB left
                                    </div>
                                    <div class="alert alert-danger alert-alt">
                                        <small>Yesterday</small><br>
                                        <i class="fa fa-bug fa-fw"></i> <a href="javascript:void(0)" class="alert-link">New bug submitted</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- END User Dropdown -->
                    </ul>
                    <!-- END Right Header Navigation -->
                </header>
                <!-- END Header -->

                <!-- Page content -->
                @yield('content')
                <!-- END Page Content -->

                <!-- Footer -->
                <footer class="clearfix">
                    <div class="pull-right">
                        Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://www.d3catalyst.com" target="_blank">D3 Catalyst</a>
                    </div>
                </footer>
                <!-- END Footer -->
            </div>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
        <div id="modal-user-settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="fa fa-pencil"></i> Configuracion</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="user" method="post" id="form-user-settings" name="form-user-settings" class="form-horizontal form-bordered">
                            <input type="hidden" id="user-settings-user-id" name="user-settings-user-id" value="{{ Auth::user()->id }}">
                            <fieldset>
                                <legend>Informacion de usuario</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Username</label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{ Auth::user()->username }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-first-name">Nombre</label>
                                    <div class="col-md-8">
                                        <input type="text" id="user-settings-name" name="user-settings-name" class="form-control" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Actualizar contraseña</legend>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-password">Nueva Contraseña</label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-password" name="user-settings-password" class="form-control" placeholder="Nueva contraseña">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="user-settings-repassword">Confirmar Contraseña</label>
                                    <div class="col-md-8">
                                        <input type="password" id="user-settings-repassword" name="user-settings-repassword" class="form-control" placeholder="Confirmar">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- END User Settings -->

        <!-- Dialogos -->
        @yield('dialogs')
        <!-- /Dialogos -->

        <!-- dialogo de confirmacion -->
        <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <form action="confirm" method="post" id="form-modal-confirm" name="form-modal-confirm">
                <input type="hidden" id="fmc-param" name="fmc-param">
                <input type="hidden" id="fmc-value" name="fmc-value">
            </form>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-circle_exclamation_mark"></i> Confirmacion</h2>
                    </div>
                    <!-- END Modal Header -->
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <span class="confirm-content"></span>
                    </div>
                    <!-- END Modal Body -->
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="button-modal-confirm">Confirmar</button>
                    </div>
                    <!-- END Modal Footer -->
                </div>
            </div>
        </div>
        <!-- END dialogo de confirmacion -->

        <!-- User Settings, modal which opens from Settings link (found in top right user menu) and the Cog link (found in sidebar user info) -->
        <div id="modal-tipo-cambio" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h2 class="modal-title"><i class="gi gi-usd"></i> Tipo de cambio</h2>
                    </div>
                    <!-- END Modal Header -->

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="user" method="post" id="form-tipo-cambio" name="form-tipo-cambio" class="form-horizontal form-bordered">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="cambio">Actual $</label>
                                <div class="col-md-8">
                                    <input type="text" id="cambio" name="cambio" class="form-control">
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-xs-12 text-right">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-sm btn-primary btn-tip-cambio-update">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- END Modal Body -->
                </div>
            </div>
        </div>
        <!-- END User Settings -->

        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="{{ URL::to('js/vendor/jquery-1.11.1.min.js') }}"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        {{ HTML::script('js/vendor/bootstrap.min.js') }}
        {{ HTML::script('js/plugins.js') }}
        {{ HTML::script('js/d3.commons.js') }}
        {{ HTML::script('js/app.js') }}

        <script>
            var url     = '{{ Config::get('btsite.url') }}';
            var url_ssl = '{{ Config::get('btsite.url_ssl') }}';
            var img_cat = '{{ Config::get('btsite.img_catalog') }}';
        </script>

        @yield('scripts')
    </body>
</html>
