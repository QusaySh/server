<div class="sidebar mt-4">
    <div class="list-group">
        <a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ $active == 'home' ? 'active' : '' }}"><i class="fa fa-home fa-fw"></i> الإحصائيات</a>
        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action {{ $active == 'users' ? 'active' : '' }}"><i class="fa fa-users fa-fw"></i> إدارة المستخدمين</a>
        <a href="{{ route('admin.messages') }}" class="list-group-item list-group-item-action {{ $active == 'messages' ? 'active' : '' }}"><i class="fa fa-envelope fa-fw"></i> إدارة الرسائل</a>
      </div>
</div>