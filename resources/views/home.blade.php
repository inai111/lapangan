@extends('layouts.main')

@section('iseng', 'title')
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    <div class="banner-1 py-3 px-5 mt-2 shadow">
        <div class="mx-3 my-4">
            <div class="">
                
            </div>
        </div>
    </div>
    {{-- modal regis&login --}}
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div id="loginFormMessage" class="alert alert-success" style="display: none"></div>
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="username">
                            <div id="username-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <div id="password-msg"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-success btn-outline" id="toRegistForm">Register Here</button>
                            <button type="submit" class="btn btn-dark w-50">Login</button>
                        </div>
                    </form>
                    <form id="registForm" style="display:none;">
                        <div id="registFormMessage" class="alert alert-success" style="display:none"></div>
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="username">
                            <div id="username-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="name">
                            <div id="name-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="col-form-label">Phone Number:</label>
                            <input type="text" name="number" class="form-control" id="number">
                            <div id="number-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <div id="password-regist-msg"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" id="toLoginForm"><i class="fa-solid fa-arrow-left text-light"></i></button>
                            <button type="submit" class="btn btn-dark w-75">Register Now</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/home.js')}}"></script>
@endsection
