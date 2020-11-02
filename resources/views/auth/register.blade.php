@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
<div class="container page-signup">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header text-center"><h4 class="mb-0">{{ __('إنشاء حساب') }}</h4></div>

                <div class="card-body">
                    
                    <div class="text-center mb-3">
                        <a class="btn btn-primary" href="{{ route('login.facebook') }}" role="button"><img width="30" src="{{ asset('images/facebook-logo.png') }}" /> متابعة بواسطة فيسبوك</a>
                        <P class="mt-3">ـــ OR ـــ</P>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('الإسم') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ? old('name') : '' }}" >
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('البريد الإلكتروني') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ? old('email') : '' }}" >
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
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') ? old('password') : '' }}" >
                                <div class="invalid-feedback">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <i class="fa fa-eye fa-fw show-password show-pass pointer"></i>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="show_name" class="col-md-3 col-form-label">{{ __('ظهور الإسم') }}:</label>

                            <div class="custom-control custom-switch mr-3">
                            <input type="checkbox" class="custom-control-input" id="show_name" name="show_account" {{ old('show_account') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="show_name">هل تريد ظهور اسمك في البحث؟</label>
                            </div>
                        </div>

                        <div class="form-group row mr-auto">
                            <div class="col-sm-12 text-left">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-user-plus fa-fw"></i> {{ __('إنشاء') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
