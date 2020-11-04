@extends('layouts.app')

@section('title', 'ملفي الشخصي')

@section('content')
<div class="container page-profile">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card mt-4">
                <div class="card-header text-center"><h4 class="mb-0">{{ __('تعديل البيانات') }}</h4></div>

                <div class="card-body">
                    @if ( session()->has('success_message') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('الإسم') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" >
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if ( Auth::user()->facebook_id == null )
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('البريد الإلكتروني') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}" >
                                <div class="invalid-feedback">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ( Auth::user()->facebook_id == null )
                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('كلمة المرور') }}:</label>

                                <div class="col-sm-11 col-md-8 mb-3"> 
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
                                <label class="col-md-3 col-form-label text-md-right">{{ __('الصورة الشخصية') }}:</label>
                                <div class="col-md-8 mb-1">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('avatar_input') is-invalid @enderror" id="avatar" name="avatar_input">
                                        <div class="invalid-feedback">
                                            @error('avatar_input')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <label class="custom-file-label" for="avatar">اختر صورة</label>
                                    </div>
                                    <div class="row justify-content-center mb-0">
                                        <img src="" id="show_image" style="visibility: hidden" class="col-sm-12 col-md-8 mt-4 d-block" />
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="facebook" class="col-md-3 col-form-label text-md-right">{{ __('رابط الفيسبوك') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook') ? old('facebook') : Auth::user()->facebook }}" >
                                <div class="invalid-feedback">
                                    @error('facebook')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instagram" class="col-md-3 col-form-label text-md-right">{{ __('رابط الانستغرام') }}:</label>

                            <div class="col-md-8 mb-3"> 
                                <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram') ? old('instagram') : Auth::user()->instagram }}" >
                                <div class="invalid-feedback">
                                    @error('instagram')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="send_email" class="col-md-3 col-form-label">{{ __('إرسال إشعارات') }}:</label>

                            <div class="custom-control custom-switch mr-3">
                            <input type="checkbox" class="custom-control-input" id="send_email" name="send_email" 
                            @if ( old('send_email') )
                                {{ old('send_email') }}
                            @else
                                @if ( Auth::user()->send_email )
                                    checked
                                @endif
                            @endif
                            >
                            <label class="custom-control-label" for="send_email">هل تريد إرسال إشعارات عندما يقوم أحد بإرسال رسالة لك؟</label>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="show_name" class="col-md-3 col-form-label">{{ __('ظهور الإسم') }}:</label>

                            <div class="custom-control custom-switch mr-3">
                            <input type="checkbox" class="custom-control-input" id="show_name" name="show_account" 
                            @if ( old('show_account') )
                                {{ old('show_account') }}
                            @else
                                @if ( Auth::user()->show_account == 'on' )
                                    checked
                                @endif
                            @endif
                            >
                            <label class="custom-control-label" for="show_name">هل تريد ظهور اسمك في البحث؟</label>
                            </div>
                        </div>

                        <div class="form-group row mr-auto">
                            <div class="col-sm-12 text-left">
                                <button type="submit" class="btn btn-info">
                                    {{ __('حفظ') }}
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
