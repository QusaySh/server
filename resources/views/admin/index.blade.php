@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid page-dashboard">
    <h3 class="text-center mt-4 animated zoomIn">الإحصائيات</h3>
    <div class="row">
        <div class="col-md-3">
            @php $active = 'home'; @endphp
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9">

            <div class="user-statistc mt-4">
                <h3 class="text-info mb-4 animated fadeIn">احصائية المستخدمين</h3>

                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card mt-2 animated fadeIn">
                            <div class="card-body badge-info">
                                <p class="justify-content-center text-center mb-3"><i class="fa fa-user fa-fw fa-4x"></i></p>
                                <h5 class="text-center text-white">{{ $count_user }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card mt-2 animated fadeIn">
                            <div class="card-body badge-info">
                                <p class="justify-content-center text-center mb-3"><i class="fa fa-shield fa-fw fa-4x"></i></p>
                                <h5 class="text-center text-white">{{ $count_admin }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card mt-2 animated fadeIn">
                            <div class="card-body badge-danger">
                                <p class="justify-content-center text-center mb-3"><i class="fa fa-facebook fa-fw fa-4x"></i></p>
                                <h5 class="text-center text-white">{{ $count_user_facebook }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card mt-2 animated fadeIn">
                            <div class="card-body badge-danger">
                                <p class="justify-content-center text-center mb-3"><i class="fa fa-google fa-fw fa-4x"></i></p>
                                <h5 class="text-center text-white">{{ $count_user_gmail }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="message-statistc mt-4">
                <h3 class="text-primary mb-4 animated fadeIn">احصائية الرسائل</h3>

                <div class="row">
                    <div class="col-sm-6 col-md-3 animated fadeIn">
                        <div class="card mt-2">
                            <div class="card-body badge-primary">
                                <p class="justify-content-center text-center mb-3"><i class="fa fa-envelope fa-fw fa-4x"></i></p>
                                <h5 class="text-center text-white">{{ $count_message }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection
