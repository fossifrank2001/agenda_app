@extends('layouts.app')

@section('title', 'Login')

@section('app_content')
    <div class="col-md-8 col-lg-6 col-xxl-3">
        <div class="card mb-0">
            <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                </a>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-forms.input id="login" label="Email or Phone" type="text" placeholder="Enter your email or phone" required />
                    <x-forms.input id="password" label="Password" type="password" placeholder="Enter your password" required />
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <x-forms.checkbox id="remember" label="Remember me" />
                        <a class="text-primary fw-bold" href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                </form>
            </div>
        </div>
    </div>

@endsection
