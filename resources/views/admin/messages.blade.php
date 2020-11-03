@extends('layouts.app')

@section('title', 'إدارة الرسائل')

@section('content')
<div class="container-fluid page-dashboard">
    <h2 class="text-center mt-4 animated zoomIn">إدارة الرسائل</h2>
    <div class="row">
        <div class="col-md-4 col-lg-3">
            @php $active = 'messages'; @endphp
            @include('layouts.sidebar')
        </div>

        <div class="col-md-8 col-lg-9">
            @if ( $messages->isNotEmpty() )
                <table class="table mt-4 table-responsive-sm table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الرسالة</th>
                        <th scope="col">المرسل إليه</th>
                        <th scope="col">تاريخ الإرسال</th>
                        <th scope="col">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($messages as $message)
                            <tr>
                                <td scope="row">{{ $i }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->users->name }}</td>
                                <td>{{ $message->created_at->diffForHumans() }}</td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('admin.deleteMessage', ['id' => $message->id]) }}" role="button"><i class="fa fa-close fa-fw"></i></a>
                                </td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center mt-4">
                    <p>{{ $messages->links() }}</p>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="alert alert-primary mt-4" role="alert">
                            لايوجد رسائل ليتم عرضها.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
