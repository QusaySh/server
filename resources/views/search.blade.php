@extends('layouts.app')

@section('title', 'البحث')

@section('content')
<div class="container-fluid page-search">
    <h3 class="text-center mt-4 mb-5">نتائج البحث عن [ {{ $input }} ]</h3>
    <div class="row">
        
        @if ( $users->isNotEmpty() )
            @foreach ($users as $user)                
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="media border rounded-lg mb-3 wow bounceIn" data-wow-offset="30">
                        <a data-magnify="gallery"
                           data-caption="{{ $user->name }}"
                           data-group=""
                           href="{{$user->facebook_id != null ? $user->avatar : asset("avatar") . "/" . $user->avatar }}"
                        ><img class="rounded-circle ml-3 border border-info" width="70" height="70" src ="{{$user->facebook_id != null ? $user->avatar : asset("avatar") . "/" . $user->avatar }}" class="ml-3" alt="..."></a>
                        <div class="media-body">
                        <h5 class="mt-0">{{ $user->name }}</h5>
                            <div>
                                <a href="{{ $user->facebook }}" target="_blank"><i class="fa fa-facebook-square fa-fw fa-2x" @if ( empty($user->facebook) )
                                    style="visibility: hidden"
                                @endif></i></a>
                                <a href="{{ $user->instagram }}" target="_blank"><i class="fa fa-instagram fa-fw fa-2x" @if ( empty($user->instagram) )
                                    style="visibility: hidden"
                                @endif></i></a>
                            </div>
                            <hr />
                            <div class="text-left">
                                <a class="btn btn-info" href="{{ route('send_message.index', ['key' => $user->key]) }}" role="button">إرسال رسالة <i class="fa fa-send fa-fw"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center">
                    <img width="200" height="200" src="{{ asset('images/no-search.png') }}" alt="" />
                    <h4 class="mt-4">لايوجد نتائج عن هذا الإسم [ <span class="text-info">{{ $input }}</span> ]</h4>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
