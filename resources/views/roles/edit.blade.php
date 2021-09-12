@extends('layouts.master')
@section('title', 'تعديل المستخدم')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الرئيسية</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تعديل : {{ $role->name }}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
<div class="col-12">
    <div class="card box-shadow-0">
        <div class="card-header">
            @include('layouts.alert')
            <h4 class="card-title mb-1">تعديل : {{ $role->name }}</h4>
        </div>
        <div class="card-body pt-0">
            <form class="form-horizontal" method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('put')
                <div class="form-group row">
                    <div class="col-6">
                        <label for="inputName">الاسم</label>
                        <input type="text" class="form-control" id="inputName" name="name" value="{{ $role->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="role">الصلاحيات</label>
                        <div class="row mb-2">
                            {{-- @dd($rolePermissions) --}}
                            @foreach($permission as $pr)
                            <div class="col-lg-3 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <label class="ckbox wd-16 mg-b-0">
                                                <input name="permission[]" {{ in_array($pr->id, $rolePermissions) ? 'checked' : '' }} value="{{ $pr->id }}" class="mg-0"
                                                    type="checkbox"><span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <input class="form-control bg-light" placeholder="{{ $pr->display_name }}" type="text" readonly>
                                </div><!-- input-group -->
                            </div><!-- col-4 -->
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 mt-3 justify-content-end">
                    <div>
                        <button type="submit" class="btn btn-primary">تعديل الدور</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- row closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

@endsection
