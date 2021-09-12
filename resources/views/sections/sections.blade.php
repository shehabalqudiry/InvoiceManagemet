@extends('layouts.master')
@section('title', "الأقسام")
@section('css')
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                الأقسام</span>
        </div>
    </div>
    @can('product-create')
    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
        <a class="modal-effect btn btn-block btn-primary" data-effect="effect-sign" data-toggle="modal"
            href="#create-section">اضافة قسم</a>
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
                    <h4 class="card-title mg-b-0">قائمة الأقسام</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap text-center">
                        @include('layouts.alert')
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم القسم</th>
                                <th class="border-bottom-0">الذي قام بإضافته</th>
                                <th class="border-bottom-0">الوصف</th>
                                <th class="border-bottom-0">اعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $section->section_name }}</td>
                                    <td>{{ $section->created_by }}</td>
                                    <td>{{ $section->description }}</td>
                                    <td>
                                        @can('section-create')
                                        <a class="modal-effect btn btn-sm btn-success ml-2" data-effect="effect-sign" data-toggle="modal" href="#edit_{{ $section->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('section-delete')
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-sign" data-toggle="modal" href="#delete_{{ $section->id }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('sections.actions')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
    @can('section-create')
    <!-- Create Modal effects -->
    <div class="modal" id="create-section">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة قسم جديد</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sections.store') }}" method="post" id="create-section-form">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">إسم القسم:</label>
                            <input type="text" class="form-control" name="section_name" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">وصف القسم:</label>
                            <textarea class="form-control" name="description" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="button" onclick="event.preventDefault();document.getElementById('create-section-form').submit();">تأكيد</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal effects-->
    @endcan
</div>
<!-- row closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
