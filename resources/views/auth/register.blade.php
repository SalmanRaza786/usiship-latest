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
                                            <h5 class="text-primary">Register Account</h5>
                                            <p class="text-muted">Sign in to continue to </p>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                {{ $errors->first() }}
                                            </div>
                                        @endif

                                        <div class="mt-4" >
                                            <form action="{{route('register')}}" method="POST" id="SignupFrom">
                                                @csrf

                                                <div class="mb-3">
                                                    <label class="form-label" for="std_name">Name</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="text" class="form-control"   placeholder="Name" value=""  name="name"  id="std_name" >
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="std_name">Email</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="text" class="form-control"   placeholder="Email" value=""  name="email"  id="std_name">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="password" class="form-label">{{__('translation.password')}}</label>
                                                    <input type="password" class="form-control" name="password" id="password" placeholder=Password" required>
                                                </div>
                                                <div class="mb-5">
                                                    <label for="c_password" class="form-label">{{__('translation.retype_password')}}</label>
                                                    <input type="password" class="form-control" name="password_confirmation" id="c_password" placeholder="{{__('translation.enter_password')}}" required>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100 btn-submit" type="button" >{{__('translation.sign_up')}}</button>
                                                </div>
                                            </form>


                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account ?
                                                <a href="{{url('login')}}" class="fw-semibold text-primary text-decoration-underline">Login</a> </p>
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
        <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
        <script>
            $(document).ready(function(){
                $(".btn-submit").on('click',function (event) {
                    $(".btn-submit").prop("disabled", true);
                    $(".btn-submit").html("Processing...");
                    $('#SignupFrom').submit();

                });

            });
        </script>
    @endsection


