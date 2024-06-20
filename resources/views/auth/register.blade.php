@extends('layouts.app')

@section('title', 'Register')

@section('app_content')

    <div class="col-md-8 col-lg-8 col-xxl-4">
        <div class="card mb-0">
            <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                </a>
                <form>
                    <x-forms.input id="name" label="Name" type="text" placeholder="Enter your name" />
                    <x-forms.input id="email" label="Email Address" type="email" placeholder="Enter your email" />
                    <x-forms.input id="password" label="Password" type="password" placeholder="Enter your password" />
                    <a href="#" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</a>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                        <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
