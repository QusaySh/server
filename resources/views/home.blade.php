@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')
<div class="container page-home">
    <div class="row">

        <div class="col-md-5">
            <div class="my-information border rounded-lg wow bounceIn">
                
                <div class="text-center mb-4">
                    <a data-magnify="gallery"
                           data-caption="{{ Auth::user()->name }}"
                           data-group=""
                           href="{{Auth::user()->facebook_id != null ? Auth::user()->avatar : asset("avatar") . "/" . Auth::user()->avatar }}"
                        ><img width="80" height="80" class="rounded-circle"
                    src="{{ Auth::user()->facebook_id != null ? Auth::user()->avatar : asset("avatar") . "/" . Auth::user()->avatar }}" alt="" /></a>
                </div>
                <div class="text-center mb-4">
                    <h4 class="text-center">{{ Auth::user()->name }}</h4>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        <span><b><i class="fa fa-user fa-fw"></i> رابط الإرسال الخاص بي:</b></span> <span><a href="{{ route("send_message.index", ['key' => Auth::user()->key ]) }}">{{ Auth::user()->name }}</a>.</span>
                    </li>
                    <li class="list-group-item">
                        <span><b><i class="fa fa-envelope fa-fw"></i> البريد الإلكتروني:</b></span> <span>{{ Auth::user()->email }}.</span>
                    </li>
                    <li class="list-group-item">
                        <span><b><i class="fa fa-comments fa-fw"></i> عدد الرسائل:</b></span> <span>[ {{ Auth::user()->messages->count() }} ] رسالة.</span>
                    </li>
                    <li class="list-group-item">
                        <span><b><i class="fa fa-sign-in fa-fw"></i> طريقة الدخول:</b></span> <span>{{ Auth::user()->facebook_id == null ? 'Email' : 'Facebook' }}.</span>
                    </li>
                    <li class="list-group-item">
                        <span><b><i class="fa fa-bell fa-fw"></i> الإشعارات:</b></span> <span>{{ Auth::user()->send_email ? 'مفعل' : 'غير مفعل' }}.</span>
                    </li>
                    <li class="list-group-item">
                        <span><b><i class="fa fa-search fa-fw"></i> ظهور إسمي في البحث:</b></span> <span>{{ Auth::user()->show_account == 'on' ? 'مفعل' : 'غير مفعل' }}.</span>
                    </li>
                    <li class="list-group-item text-center">
                        <button class="btn btn-danger" id="delete_account">حذف حسابي</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-7 mt-sm-4 m-lg-0">
            <div class="container-message">
                @if ( $messages->isNotEmpty() )
                <h2 class="text-center mb-4 text-secondary animated fadeInLeft"><i class="fa fa-comments fa-fw"></i> الرسائل</h2>
                    @if ( session()->has('success') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @foreach ($messages as $message)
                    <div class="message mb-3 border rounded-lg wow bounceIn" data-wow-offset="30">
                        <div><a href="{{ route("send_message.delete", ['id' => $message->id]) }}"><i class="fa fa-close text-danger fa-fw"></i></a></div>
                        <p class="mb-0 mt-3">{{ $message->message }}</p>
                        <hr class="mb-2" />
                        <div class="text-left date"><i class="fa fa-clock-o fa-fw"></i> {{ $message->created_at->diffForHumans() }}</div>
                    </div>
                    @endforeach

                @else
                    <div class="text-center">
                        <img width="150" height="150" src="{{ asset('images/no-data.png') }}" alt="" />
                        <h3 class="mt-4">لايوجد  لديك رسائل</h3>
                        <p class="mb-1">قم بنشر الرابط الخاص بك</p>
                        {{-- <p class="mt-0 text-info" style="font-size: 14px">{{ route("send_message.index", ['key' => Auth::user()->key ])}}</p> --}}
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
