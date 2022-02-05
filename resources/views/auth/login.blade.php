<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        <title>Admin - Kedaton</title>



        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/font-awesome/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.cs')}}s" rel="stylesheet">


        <!-- Theme Styles -->
        <link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class='loader'>
            <div class='spinner-grow text-primary' role='status'>
              <span class='sr-only'>Loading...</span>
            </div>
          </div>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 col-lg-4">
                    <div class="card login-box-container">
                        <div class="card-body">
                            <div class="authent-logo">
                                <img src="{{asset('assets/images/kedaton-logo.png')}}" height="40px" alt="">
                            </div>
                            <div class="authent-text">

                                <p>Please Sign-in to your account.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control"  id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                        <label for="floatingInput">Email address</label>
                                      </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control"  @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                      </div>
                                </div>
                                <div class="mb-3 form-check">
                                  {{-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> --}}
                                  {{-- <label class="form-check-label" for="exampleCheck1">Check me out</label> --}}
                                </div>
                                <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs">{{ __('Login') }}</button>
                                {{-- <button class="btn btn-primary">Facebook</button> --}}
                            </div>
                              </form>
                              <div class="authent-reg">
                                  {{-- <p>Not registered? <a href="register.html">Create an account</a></p> --}}
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascripts -->
        <script src="{{asset('assets/plugins/jquery/jquery-3.4.1.min.js')}}"></script>
        <script src="https://unpkg.com/@popperjs/core@2')}}"></script>
        <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('assets/js/main.min.js')}}"></script>
    </body>
</html>
