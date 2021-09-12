@extends('layouts.master')
@section('title', 'المستخدمين')
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرئيسية</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المستخدمين</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        @can('user-create')
        <a class="btn btn-success" href="{{ route('users.create') }}"> إضافة مستخدم جديد</a>
        @endcan
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            @include('layouts.alert')
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">المستخدمين</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>البريد الالكتروني</th>
                                <th>حالة المستخدم</th>
                                <th>نوع المستخدم</th>
                                <th width="280px">اعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <label class="badge badge-{{ $user->status == 0 ? 'danger' : 'success' }}">{{ $user->status == 0 ? 'غير مفعل' : 'مفعل' }}</label>
                                </td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @can('user-list')
                                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">عرض</a>
                                    @endcan
                                    @can('user-edit')
                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">تعديل</a>
                                    @endcan
                                    @can('user-delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post"
                                        style="display:inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- {!! $data->render() !!} --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@endsection
