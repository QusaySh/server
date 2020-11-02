@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container-fluid page-dashboard">
    <h2 class="text-center mt-4 animated bounceInLeft">إدارة المستخدمين</h2>
    <div class="row">
        <div class="col-md-4 col-lg-3">
            @php $active = 'users'; @endphp
            @include('layouts.sidebar')
        </div>

        <div class="col-md-8 col-lg-9">
            @if ( session()->has('success_message') )
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <table class="table mt-4 table-responsive table-hover text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">الإسم</th>
                    <th scope="col">البريد الإلكتروني</th>
                    <th scope="col">الصلاحيات</th>
                    <th scope="col">طريقة الدخول</th>
                    <th scope="col">فيسبوك</th>
                    <th scope="col">إنستغرام</th>
                    <th scope="col">عدد الرسائل</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">التحكم</th>
                  </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td scope="row">{{ $i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{!! $user->admin ? '<i class="fa fa-shield fa-fw"></i>' : '<i class="fa fa-user fa-fw"></i>' !!}</td>
                            <td>{!! $user->facebook_id == null ? '<i class="fa fa-google fa-fw"></i>' : '<i class="fa fa-facebook fa-fw"></i>' !!}</td>
                            <td>{!! !empty($user->facebook) ? '<a href="' . $user->facebook . '"><i class="fa fa-facebook-square fa-fw"></i></a>' : '' !!}</td>
                            <td>{!! !empty($user->instagram) ? '<a href="' . $user->instagram . '"><i class="fa fa-instagram fa-fw"></i></a>' : '' !!}</td>
                            <td>{{ $user->messages->count() }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.rules', ['id' => $user->id]) }}" role="button"><i class="fa fa-shield fa-fw"></i></a>
                                <a class="btn btn-danger mt-1" href="{{ route('admin.deleteUser', ['id' => $user->id]) }}" role="button"><i class="fa fa-close fa-fw"></i></a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
              </table>
            <div class="row justify-content-center mt-4">
                <p>{{ $users->links() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
