@extends('layouts.guest')

@section('title','Register')

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-6 col-lg-7 col-md-9">

        <div class="card shadow-lg my-5">

            <div class="card-body p-5">

                <div class="text-center">

                    <h1 class="h4 text-gray-900 mb-4">

                        Register Library Mini

                    </h1>

                </div>

                <form method="POST"
                      action="{{ route('register') }}">

                    @csrf

                    <div class="form-group">

                        <input
                            type="text"
                            name="name"
                            class="form-control form-control-user"
                            placeholder="Nama Lengkap">

                    </div>

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

                    <div class="form-group">

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control form-control-user"
                            placeholder="Konfirmasi Password">

                    </div>

                    <button class="btn btn-success btn-user btn-block">

                        Register

                    </button>

                </form>

                <hr>

                <div class="text-center">

                    Sudah punya akun?

                    <a href="{{ route('login') }}">

                        Login

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection