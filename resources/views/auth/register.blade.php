<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>BDM Panel | Register</title>
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
        <!-- BEGIN register -->
        <div class="register register-with-news-feed">
            <!-- BEGIN news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(../assets/img/login-bg/login-bg-15.jpg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><b>Color</b> Admin App</h4>
                    <p>
                        As a Color Admin app administrator, you use the Color Admin console to manage your
                        organization’s account, such as add new users, manage security settings, and turn on the
                        services you want your team to access.
                    </p>
                </div>
            </div>
            <!-- END news-feed -->

            <!-- BEGIN register-container -->
            <div class="register-container">
                <!-- BEGIN register-header -->
                <div class="register-header mb-25px h1">
                    <div class="mb-1">Sign Up</div>
                    <small class="d-block fs-15px lh-16">Create your Color Admin Account. It’s free and always will
                        be.</small>
                </div>
                <!-- END register-header -->

                <!-- BEGIN register-content -->
                <div class="register-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-2"><b>Name</b> <span class="text-danger">*</span></label>
                            <div class="row gx-3">
                                <div class="mb-2">
                                    <input type="text" class="form-control fs-13px" placeholder="name" name="name"
                                        :value="old('name')" required autofocus autocomplete="name" />
                                    @error('name')
                                        <div class="status-msg">
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 ">
                            <label class="mb-2"> <b>Email</b> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control fs-13px" placeholder="Email address"
                                name="email" name="email" :value="old('email')" required autocomplete="username" />
                            @error('email')
                                <div class="status-msg">
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2"> <b> Password </b> <span class="text-danger">*</span></label>
                            <input type="password" class="form-control fs-13px" placeholder="Password" name="password"
                                required autocomplete="new-password" />
                            @error('password')
                                <div class="status-msg">
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="mb-2"> <b> Confirm Password </b> <span class="text-danger">*</span></label>
                            <input type="password" class="form-control fs-13px" placeholder="Confirm Password"
                                name="password_confirmation" required autocomplete="new-password" />
                            @error('password_confirmation')
                                <div class="status-msg">
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="agreementCheckbox" />
                            <label class="form-check-label" for="agreementCheckbox">
                                By clicking Sign Up, you agree to our <a href="javascript:;">Terms</a> and that you have
                                read our <a href="javascript:;">Data Policy</a>, including our <a
                                    href="javascript:;">Cookie Use</a>.
                            </label>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary d-block w-100 btn-lg h-45px fs-13px">Sign
                                Up</button>
                        </div>
                        <div class="mb-4 pb-5">
                            Already a member? Click <a href="/">here</a> to login.
                        </div>
                        <hr class="bg-gray-600 opacity-2" />
                        <p class="text-center text-gray-600">
                            &copy; Color Admin All Right Reserved 2021
                        </p>
                    </form>
                </div>
                <!-- END register-content -->
            </div>
            <!-- END register-container -->
        </div>
        <!-- END register -->

        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
    </div>
    <!-- END #app -->

    <!-- ================== BEGIN core-js ================== -->
    <script src=" {{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->
</body>

</html>
