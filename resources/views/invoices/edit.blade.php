@extends('layouts.master')
@section('title', 'اضافة فاتورة')
@section('css')
<!--- Internal Select2 css-->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                فاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            @include('layouts.alert')
            <div class="card-body">
                <form action="{{ route('invoices.update', $invoice->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row row-sm">
                        <div class="col-lg">
                            <label>رقم الفاتورة</label>
                            <input class="form-control" placeholder="رقم الفاتورة" type="text" value="{{ $invoice->invoice_number }}" name="invoice_number">
                        </div>
                        <div class="col-lg">
                            <label>تاريخ الفاتورة</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                    <input class="form-control" id="datetimepicker" type="text" name="invoice_date"
                                        value="{{ $invoice->invoice_date }}">
                            </div>
                        </div>
                        <div class="col-lg">
                            <label>تاريخ الاستحقاق</label>
                            
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" id="datetimepicker2" type="text" name="due_date" value="{{ $invoice->due_date }}">
                                </div>
                        </div>
                    </div>
                    <div class="row row-sm mg-t-20">
                        <div class="col-lg">
                            <label>القسم </label>
                            <select class="form-control SlectBox" name="section_id">
                                <option value="" selected disabled>اختار القسم ...</option>
                                @foreach ($sections as $section)
                                <option {{ $invoice->section_id == $section->id ? 'selected' : '' }} value="{{ $section->id }}">
                                    {{ $section->section_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg">
                            <label>المنتج </label>
                            <select class="form-control select2" id="product" name="product_id">
                                <option value="{{ $invoice->product_id }}">{{ $invoice->product->product_name }}</option>
                            </select>
                        </div>
                        <div class="col-lg">
                            <label>مبلغ التحصيل</label>
                            <input class="form-control" value="{{ $invoice->amount_collection }}" placeholder="مبلغ التحصيل" type="text" id="amount_collection" name="amount_collection">
                        </div>
                    </div>
                    <div class="row row-sm mg-t-20">
                        <div class="col-lg">
                            <label>مبلغ العمولة</label>
                            <input class="form-control" value="{{ $invoice->amount_commission }}" placeholder="مبلغ العمولة" type="text" id="amount_commission" name="amount_commission">
                        </div>
                        <div class="col-lg">
                            <label>الخصم</label>
                            <input class="form-control" value="{{ $invoice->discount }}" placeholder="الخصم" type="text" id="discount" name="discount">
                        </div>
                        <div class="col-lg">
                            <label>نسبة ضريبة القيمة المضافة</label>
                            <select class="form-control select2" id="rate_vat" name="rate_vat" onchange="amounts()">
                                <option value="" selected disabled>حدد نسبة الضريبة ...</option>
                                <option {{ $invoice->rate_vat == '5%' ? 'selected' : '' }} value="5%">
                                    5%
                                </option>
                                <option {{ $invoice->rate_vat == '10%' ? 'selected' : '' }} value="10%">
                                    10%
                                </option>
                                <option {{ $invoice->rate_vat == '14%' ? 'selected' : '' }} value="14%">
                                    14%
                                </option>
                                <option {{ $invoice->rate_vat == '20%' ? 'selected' : '' }} value="20%">
                                    20%
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="row row-sm mg-t-20">
                        <div class="col-lg">
                            <label>قيمة ضريبة القيمة المضافة</label>
                            <input class="form-control" placeholder="قيمة ضريبة القيمة المضافة" type="text" id="value_vat"
                                name="value_vat" value="{{ $invoice->value_vat }}" readonly>
                        </div>
                        <div class="col-lg">
                            <label>الاجمالي شامل الضريبة</label>
                            <input class="form-control" placeholder="الاجمالي شامل الضريبة" type="text" id="total"
                                name="total" value="{{ $invoice->total }}" readonly>
                        </div>
                    </div>
                    <div class="row row-sm mg-t-20">
                        <div class="col-lg">
                            <label>ملاحظات</label>
                            <textarea class="form-control" placeholder="وصف الفاتورة" rows="3" id="note" name="note">{{ $invoice->note }}</textarea>
                        </div>
                    </div>
                    <div class="row row-sm mg-t-20">
                        <div class="col-lg">
                            <label>المرفقات</label>
                            <input type="file" class="dropify" accept=".pdf,image/*" name="attach" data-height="100" />
                        </div>
                    </div>
                    <button class="btn ripple btn-success" type="submit">تأكيد</button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>

<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
{{-- Amounts --}}
<script>
    function amounts(){
        var commission = parseFloat(document.getElementById('amount_commission').value),
        discount = parseFloat(document.getElementById('discount').value),
        rate_vat = parseFloat(document.getElementById('rate_vat').value),
        value_vat = parseFloat(document.getElementById('value_vat').value),

        commission2 = commission - discount;

        if(typeof commission === 'undefined' || !commission) {
            alert('ادخل مبلغ العمولة اولا');
        }else {
            var value = commission2 * rate_vat / 100,
            total = parseFloat(value + commission2),

            pars_value = parseFloat(value).toFixed(2),
            pars_total = parseFloat(total).toFixed(2);

            document.getElementById('value_vat').value = pars_value;
            document.getElementById('total').value = pars_total;

        }
    }
</script>
{{-- Get Products --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('select[name="section_id"]').on('change', function(){
            var SectionID = $(this).val();
            if (SectionID) {
                $.ajax({
                    url: "{{ URL::to('get-products') }}/" + SectionID,
                    type: "GET",
                    dataType: "json",
                    success: function(data){
                        $('select[name="product_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="product_id"]').append('<option value="' + key + '">' + value + '</option>');
                        })
                    },
                });
            } else {
                console.log("AJAX Load Not Work");
            };
        });
    });
</script>
@endsection
