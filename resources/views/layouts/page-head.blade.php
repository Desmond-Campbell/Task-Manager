    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/vendor/bootstrap/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/vendor/node_modules/angular-material/angular-material.css">
    <link href="/js/vendor/quill/quill.snow.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/vendor/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="/js/vendor/md-color-picker/mdColorPicker.css" rel="stylesheet">

    @yield('load-css')

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/vendor/bootstrap/ie-emulation-modes-warning.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Bad+Script|Courgette" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
