@extends('layouts.app')

@section('title', 'تأكيد البريد الإلكتروني')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading mb-1">{{ __('تحقق من عنوان بريدك الإلكتروني') }}</h4>
                <p>
                    @if (session('resent'))
                        {{ __('تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.') }}
                    @endif
                </p>
                <p>
                    {{ __('قبل المتابعة ، يرجى التحقق من بريدك الإلكتروني للحصول على رابط التحقق.') }}
                </p>

                <hr>

                <span>{{ __('إذا لم تستلم البريد الإلكتروني') }},</span>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('انقر هنا لإعادة الإرسال') }}</button>.
                    </form>
              </div>
        </div>
    </div>
</div>
@endsection
