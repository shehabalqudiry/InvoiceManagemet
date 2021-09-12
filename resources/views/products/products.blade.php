@extends('layouts.master')
@section('title', "المنتجات")
@section('css')
{{-- Internal Select2 css --}}
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
{{--Internal  Datetimepicker-slider css --}}
<link href="{{asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتجات</span>
        </div>
    </div>
    @can('product-create')
    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
        <a class="modal-effect btn btn-block btn-primary" data-effect="effect-sign" data-toggle="modal"
            href="#create-product">اضافة منتج</a>
    </div>
    @endcan
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة المنتجات</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap text-center" data-page-length="50">
                        @include('layouts.alert')
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الوصف</th>
                                <th class="border-bottom-0">اعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->section->section_name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    @can('product-edit')
                                    <a class="modal-effect btn btn-sm btn-success ml-2" data-effect="effect-sign"
                                        data-toggle="modal" href="#edit_{{ $product->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('product-delete')
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-sign"
                                        data-toggle="modal" href="#delete_{{ $product->id }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @include('products.actions')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
@can('product-create')
<!-- Create Modal effects -->
<div class="modal" id="create-product">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">إضافة منتج جديد</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="post" id="createProduct">
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">إسم المنتج:</label>
                        <input type="text" class="form-control" name="product_name" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="section-select" class="col-form-label">القسم:</label>
                        <select class="form-control select2" name="section_id" id="section-select">
                            <option label="اختار القسم ..."></option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}">
                                {{ $section->section_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">وصف المنتج:</label>
                        <textarea class="form-control" name="description" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button"
                    onclick="event.preventDefault();document.getElementById('createProduct').submit();">تأكيد</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal effects-->
@endcan
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
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
@endsection
