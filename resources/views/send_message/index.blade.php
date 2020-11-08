@extends('layouts.app')

@section('content')
<div class="container page-sned-message">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="container-send-message">
                <p class="text-left mb-0"><span>{{ $user->views }} <i class="fa fa-eye fa-fw"></i></span></p>
                <div class="text-center mb-3">
                    <a     data-magnify="gallery"
                           data-caption="{{ $user->name }}"
                           data-group=""
                           href="{{$user->facebook_id != null ? $user->avatar : asset("avatar") . "/" . $user->avatar }}"
                        ><img class="rounded-circle" width="90" height="90" src="{{ $user->facebook_id != null ? $user->avatar : asset("avatar") . "/" . $user->avatar }}" /></a>
                    <h3 class="mt-3 animated zoomIn">{{ $user->name }}</h3>
                    @if ( !empty($user->facebook) )
                        <a href="{{ $user->facebook }}" target="_blank"><i class="fa fa-facebook-square fa-fw fa-2x"></i></a>
                    @endif

                    @if ( !empty($user->instagram) )
                        <a href="{{ $user->instagram }}" target="_blank"><i class="fa fa-instagram fa-fw fa-2x"></i></a>
                    @endif
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-md-8">
                        @if ( session()->has('success_message') )
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('success_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form method="POST" class="" action="{{ route("send_message.send", ['id' => $user->id]) }}">
                            @csrf
                            <label for="message_form">رسالتك:</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message_form" name="message" rows="3" placeholder="تكلم عني بصدق ..."></textarea>
                            <div class="invalid-feedback">
                                @error('message')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="text-left">
                                <button class="btn btn-info mt-4 animated slideInRight" type="submit"><i class="fa fa-send fa-fw"></i> إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @if ( $message_show->isNotEmpty() )
            <div class="col-md-8 mt-4">
                <h2 class="mb-3 text-secondary">الردود</h2>
                @foreach ($message_show as $message)
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="media">
                                <img class="rounded-circle" src="{{ asset('avatar/avatar.png') }}" width="50" height="50" class="mr-3" alt="...">
                                <div class="media-body mr-2">
                                <h5 class="mt-0 mb-0">مجهول</h5>
                                <p class="mt-0 mb-3 mr-2 text-secondary time-reply">{{ $message->created_at->diffForHumans() }}</p>
                                {{ $message->message }}
                                <hr>
                                @foreach ($message->reply as $reply)
                                    <div class="media mt-3">
                                        <a class="mr-0">
                                        <img class="rounded-circle" src="{{$message->users->facebook_id != null ? $message->users->avatar : asset("avatar") . "/" . $message->users->avatar }}" width="50" height="50" class="mr-3" alt="...">
                                        </a>
                                        <div class="media-body mr-2">
                                        <h5 class="mt-0 mb-0">قصي الشرتح</h5>
                                        <p class="mt-0 mb-3 mr-2 text-secondary time-reply">{{ $reply->created_at->diffForHumans() }}</p>
                                        {{ $reply->reply }}
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
