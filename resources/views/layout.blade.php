<html>
    <head>
        <title>
            @yield('title' , '后台管理系统')
        </title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/css/fullcalendar.css" />
        <link rel="stylesheet" href="/css/matrix-style.css" />
        <link rel="stylesheet" href="/css/matrix-media.css" />
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/jquery.gritter.css" />
        @yield('css')
    </head>
    <body>
        @if(Auth::check() && empty($not_menu))
            @include('public.menu')
        @endif
        {{--主要类容--}}
        @yield('main')
        <script type="text/javascript" src="/js/excanvas.min.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/page.js"></script>
        <script type="text/javascript" src="/js/jquery.ui.custom.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.flot.min.js"></script>
        <script type="text/javascript" src="/js/jquery.flot.resize.min.js"></script>
        <script type="text/javascript" src="/js/jquery.peity.min.js"></script>
        <script type="text/javascript" src="/js/fullcalendar.min.js"></script>
        <!--<script type="text/javascript" src="/js/matrix.js"></script>-->
        <!--<script type="text/javascript" src="/js/matrix.dashboard.js"></script>-->
        <script type="text/javascript" src="/js/jquery.gritter.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.js"></script>
        <!--<script type="text/javascript" src="/js/matrix.form_validation.js"></script>-->
        <script type="text/javascript" src="/js/jquery.wizard.js"></script>
        @yield('script')
    </body>
</html>