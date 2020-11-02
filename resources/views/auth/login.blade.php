@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container page-signin">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header text-center"><h4 class="mb-0">{{ __('تسجيل الدخول') }}</h4></div>

                <div class="card-body">
                    @if ( session()->has('error_message') )
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error_message') }}
                        </div>
                    @endif
                    @if ( session()->has('error_facebook') )
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error_facebook') }}
                        </div>
                    @endif
                    <div class="text-center mb-3">
                        <a class="btn btn-primary" href="{{ route('login.facebook') }}" role="button"><img width="30" src="{{ asset('images/facebook-logo.png') }}" /> متابعة بواسطة فيسبوك</a>
                        <P class="mt-3">ـــ OR ـــ</P>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('البريد الإلكتروني') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" >
                                <div class="invalid-feedback">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('كلمة المرور') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" >
                                <div class="invalid-feedback">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <i class="fa fa-eye fa-fw show-password show-pass pointer"></i>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('تذكرني') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-info d-block mr-auto ml-auto mb-3">
                                    {{ __('تسجيل الدخول') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('هل نسيت كلمة المرور؟') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
