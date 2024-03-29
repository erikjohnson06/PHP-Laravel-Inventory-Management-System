<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Register | Easy Inventory 2000</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Admin Dashboard Template" name="description" />
        <meta content="Erik Johnson" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Toaster CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    </head>

    <body>
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="{{ url('/') }}" class="auth-logo">
                                    <img src="{{ asset('logo/easy_logo.png') }}" height="200" class="logo-dark mx-auto" alt="">
                                </a>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Register</b></h4>

                        <div class="p-3">
                            <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
                                @csrf


                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input id="name" class="form-control" type="text" name="name" placeholder="Name"  autofocus >
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input id="username" class="form-control"  type="text" name="username"  placeholder="Username" required >
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input id="email" class="form-control" type="email" name="email" required="" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input id="password"
                                               class="form-control"
                                               type="password"
                                               name="password"
                                               autocomplete="new-password"
                                               placeholder="Password"
                                               required >
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input id="password_confirmation"
                                               class="form-control"
                                               type="password"
                                               name="password_confirmation"
                                               autocomplete="new-password"
                                               placeholder="Password Confirmation"
                                               required >
                                    </div>
                                </div>

                                <div class="form-group text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                </div>

                                <div class="form-group mt-2 mb-0 row">
                                    <div class="col-12 mt-3 text-center">
                                        <a href="{{ route('login') }}" class="text-muted">Already have account?</a>
                                    </div>
                                </div>
                            </form>
                            <!-- end form -->
                        </div>
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end container -->
        </div>
        <!-- end -->


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Toaster JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
@if ($errors && $errors->has('name'))
    toastr.warning(" {{ $errors->first('name') }} ");
@elseif ($errors && $errors->has('username'))
    toastr.warning(" {{ $errors->first('username') }} ");
@elseif ($errors && $errors->has('email'))
    toastr.warning(" {{ $errors->first('email') }} ");
@elseif ($errors && $errors->has('password'))
    toastr.warning(" {{ $errors->first('password') }} ");
@elseif ($errors && $errors->has('password_confirmation'))
    toastr.warning(" {{ $errors->first('password_confirmation') }} ");
@endif


        </script>
    </body>
</html>
