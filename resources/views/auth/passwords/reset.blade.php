@extends('layouts.app')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="container page-reset">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header text-center"><h4 class="mb-0">{{ __('إعادة تعيين كلمة المرور') }}</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

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
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') ? old('password') : '' }}">
                                <div class="invalid-feedback">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <i class="fa fa-eye fa-fw show-password show-pass pointer"></i>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('تأكيد كلمة المرور') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" autocomplete="new-password" value="{{ old('password_confirmation') ? old('password_confirmation') : '' }}">
                                <i class="fa fa-eye fa-fw show-password show-pass pointer"></i>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-info">
                                    {{ __('إعادة التعيين') }}
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
