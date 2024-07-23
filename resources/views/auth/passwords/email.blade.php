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
                                    <div class="card mt-4">

                                        <div class="card-body p-4">
                                            <div class="text-center mt-2">
                                                <h5 class="text-primary">Forgot Password?</h5>
                                                <p class="text-muted">Reset password with USI Ship</p>

                                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                                           colors="primary:#0ab39c" class="avatar-xl">
                                                </lord-icon>

                                            </div>

                                            <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                                Enter your email and instructions will be sent to you!
                                            </div>
                                            @if (session('status'))
                                                <div class="alert alert-success text-center mb-4" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <div class="p-2">

                                                <form class="form-horizontal" method="POST"
                                                      action="{{ route('password.email') }}" id="LoginForm">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="useremail" class="form-label">Email</label>
                                                        <input type="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               id="useremail" name="email" placeholder="Enter email"
                                                               value="{{ old('email') }}" id="email">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="text-center mt-4">
                                                        <button class="btn btn-success w-100 btn-submit"  type="button">Send Reset Link</button>
                                                    </div>

                                                    <div class="mt-5 text-center">
                                                        <p class="mb-0">Already have an account ?
                                                            <a href="{{url('login')}}" class="fw-semibold text-primary text-decoration-underline">Login</a> </p>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                        <!-- end card body -->
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

