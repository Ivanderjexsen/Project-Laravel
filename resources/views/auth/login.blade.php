@extends('layouts.guest')

@section('title','Login')

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-5 col-lg-6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">

            <div class="card-body p-0">

                <div class="p-5">

                    <div class="text-center">

                        <h1 class="h4 text-gray-900 mb-4">

                            Login Library Mini

                        </h1>

                    </div>

                    <form method="POST"
                          action="{{ route('login') }}">

                        @csrf

                        <div class="form-group">

                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-user"
                                placeholder="Email">

                        </div>

                        <div class="form-group">

                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-user"
                                placeholder="Password">

                        </div>

                        <button class="btn btn-primary btn-user btn-block">

                            Login

                        </button>

                    </form>

                    <hr>

                    <div class="text-center">

                        Belum punya akun?

                        <a href="{{ route('register') }}">

                            Register

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection