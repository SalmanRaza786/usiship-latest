@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
@endsection
@section('content')
    <div class="auth-page-wrapper pt-5">


        @if($appInfo->count() > 0)
            <style>
                .background-image {
                    background-image: url('{{ asset('storage/appsettings/' .$appInfo[3]->where('key','admin_bg')->pluck('value')->first() )}}');
                }
            </style>
        @else
            <style>
                .background-image {
                    background-image: url('{{URL::asset('build/images/admin_bg.jpg')}}');
                }
            </style>
        @endif
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg background-image"  id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a class="d-inline-block auth-logo">

                                    @if($appInfo->count() > 0)
                                        @include('components.auth-logo')
                                    @else
                                        <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="50">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back</h5>
                                    <p class="text-muted">Sign in to continue to {{($appInfo->count()>0)?$appInfo[0]->value:'BDC'}}</p>
                                </div>
                                <div class="p-2 mt-4">
                                    @if ($message = Session::get('error'))
                                        <span class="text-center text-danger"> {{ $message }}</span>
                                    @endif
                                    <form action="{{ route('admin.login') }}" method="POST" id="LoginForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input type="email" class="form-control"  id="username" name="email" placeholder="Enter email" required>

                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control password-input pe-5" name="password" placeholder="Enter password" id="password-input" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>



                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100 btn-submit" type="button">Sign In</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

{{--                        <div class="mt-4 text-center">--}}
{{--                            <p class="mb-0">Forgot password? <a href="{{ route('password.request') }}" class="fw-semibold text-primary text-decoration-underline"> Reset Now </a> </p>--}}
{{--                        </div>--}}

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".btn-submit").on('click',function (event) {
                $(".btn-submit").prop("disabled", true);
                $(".btn-submit").html("Processing...");
                $('#LoginForm').submit();

            });

        });
    </script>

@endsection
