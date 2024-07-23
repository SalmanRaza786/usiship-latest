@extends('layouts.master-without-nav')
@section('title')
    Signin
@endsection
@section('content')

    @include('components.auth-bg-image')
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>


        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg background-image h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                @include('components.auth-logo')
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-warning"></i>
                                                </div>

                                                @include('components.auth-slider')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome</h5>
                                            <p class="text-muted">Sign in to continue to </p>
                                        </div>
                                        @isset($data)
                                            <div class="text-danger"> {{ $data }}  </div>
                                        @endisset

                                        <div class="mt-4" >

                                            <form action="{{route('login')}}" method="POST" id="LoginForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" required>

                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="{{route('password.request')}}" class="text-muted">Forget Password</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter Password" id="password-input" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>


                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100 btn-submit" type="button">Sign in</button>

                                                </div>

                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Don't have an account ?
                                                <a href="{{url('register')}}" class="fw-semibold text-primary text-decoration-underline">Sign Up</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">©
                                <script>document.write(new Date().getFullYear())</script>USHIP </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div id="scrnli_recorder_root"></div>
@endsection

@section('script')
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

