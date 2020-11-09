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
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.messages') }}" method="GET">
                        <div class="input-group mb-2 mt-4">
                            <input type="text" class="form-control" autocomplete="off" name="user_id" placeholder="أدخل رقم المعرف للشخص المراد جلب بياناته" aria-label="أدخل رقم المعرف للشخص المراد جلب بياناته" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-info" type="submit" id="button-addon2">بحث</button>
                              <a class="btn btn-outline-primary" href="{{ route('admin.messages') }}">الكل</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if ( $messages->isNotEmpty() )
                <table class="table mt-4 table-responsive-sm table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">معرف المستخدم</th>
                        <th scope="col">معرف الرسالة</th>
                        <th scope="col">الرسالة</th>
                        <th scope="col">المرسل إليه</th>
                        <th scope="col">تاريخ الإرسال</th>
                        <th scope="col">الردود</th>
                        <th scope="col">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($messages as $message)
                            <tr>
                                <td scope="row">{{ $i }}</td>
                                <td scope="row">{{ $message->users->id }}</td>
                                <td scope="row">{{ $message->id }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->users->name }}</td>
                                <td>{{ $message->created_at->diffForHumans() }}</td>
                                <td><button type="button" class="btn btn-primary show-reply" data-mid="{{ $message->id }}" data-toggle="modal" data-target="#show_reply_model"><i class="fa fa-fw fa-eye"></i></button></td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('admin.deleteMessage', ['id' => $message->id]) }}" role="button"><i class="fa fa-close fa-fw"></i></a>
                                </td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center mt-4">
                    @if ( isset($_GET['user_id']) )
                        <p>{{ $messages->appends(['user_id' => $_GET['user_id']])->links() }}</p>
                    @elseif ( isset($_GET['message_id']) )
                        <p>{{ $messages->appends(['message_id' => $_GET['message_id']])->links() }}</p>
                    @else
                        <p>{{ $messages->links() }}</p>
                    @endif
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
<!-- this is a model show replay -->
  <!-- Modal -->
  <div class="modal fade" id="show_reply_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">عرض الردود</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center loading-reply">
                <div class="spinner-border loading-reply-1 text-info" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="body-reply"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">إغلاق</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
