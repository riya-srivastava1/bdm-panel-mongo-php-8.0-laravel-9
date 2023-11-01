<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>BDM Panel | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/default/app.min.css') }}" rel="stylesheet" />
    <!-- ================== END core-css ================== -->

</head>

<body class='pace-top'>
    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
    <!-- END #loader -->
    <!-- BEGIN #app -->
    <div id="app" class="app">
        <!-- BEGIN login -->
        <div class="login login-v1">
            <!-- BEGIN login-container -->
            <div class="login-container">
                <!-- BEGIN login-header -->
                <div class="login-header">
                    <div class="brand">
                        <div class="d-flex align-items-center">
                            <span class="logo"></span> <b>Color</b> Admin
                        </div>
                        <small>Bootstrap 5 Responsive Admin Template</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
                <!-- END login-header -->
                <!-- BEGIN login-body -->
                <div class="login-body">
                    <!-- BEGIN login-content -->
                    <div class="login-content fs-13px">

                        @yield('content')

                    </div>
                    <!-- END login-content -->
                </div>
                <!-- END login-body -->
            </div>
            <!-- END login-container -->
        </div>
        <!-- END login -->

    </div>
    <!-- END #app -->
    <!-- BEGIN scroll-top-btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i
            class="fa fa-angle-up"></i></a>
    <!-- END scroll-top-btn -->

    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <script>
        // Wait for the document to be ready
        $(document).ready(function() {
            if ($('.status-msg').css('display') == 'block') {
                setTimeout(function() {
                    $('.status-msg').hide();
                }, 3000);
            }
        });
    </script>

    <!-- ================== END core-js ================== -->
</body>


</html>
