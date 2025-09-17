<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Forget Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body class="bg-white">
    <!-- Begin page -->
    <div class="account-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0">
                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                                <div class="mb-4 p-0">
                                    <a href="index.html" class="auth-logo">
                                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo-dark"
                                            class="mx-auto" height="28" />
                                    </a>
                                </div>

                                <div class="pt-0">
                                    <form method="POST" action="{{ route('admin.password_submit') }}" class="my-4">
                                        @csrf


                                          @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                          @if (session('success'))
                                            <div class="alert alert-info">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                      

                                        <div class="form-group mb-3">
                                            <label for="emailaddress" class="form-label">Email address</label>
                                            <input class="form-control" name="email" type="email" id="email"
                                                required="" placeholder="Enter your email">
                                        
                                                  @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                            @error('email')
                                                <small class="text-info">{{ $message }}</small>
                                            @enderror
                                        </div>

                                       

                                       
                                           

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="submit"> Email Password Reset Link </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                   


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="account-page-bg p-md-5 p-4">
                        <div class="text-center">
                            <h3 class="text-dark mb-3 pera-title">Login Page For Inventory Managament System </h3>
                            <div class="auth-image d-flex justify-content-center align-items-center">

                                <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>

                                <dotlottie-wc
                                    src="https://lottie.host/9802ef85-87b5-4ca0-9b52-c67db1524fd1/iiJMXFyqNX.lottie"
                                    style="width: 300px;height: 300px" speed="1" autoplay loop></dotlottie-wc>

                                {{-- <img src="{{asset('backend/assets/images/authentication.svg')}}" class="mx-auto img-fluid"  alt="images"> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- App js-->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>


</body>

</html>
