@extends('layouts.master')
@section('title', 'تفاصيل الفاتورة رقم : ' . $invoice->invoice_number)
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                الفاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

<div class="card mg-b-20" id="tabs-style3">
    <div class="card-body">
        <div class="main-content-label mb-4">
            تفاصيل الفاتورة رقم : {{ $invoice->invoice_number }} @if(!$invoice->deleted_at) <span class="badge badge-danger">مؤرشفة</span> @endif 
        </div>
        @include('layouts.alert')
        <div class="tabs-style-3">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="">
                            <a href="#tab11" class="active" data-toggle="tab">
                                <i class="fa fa-laptop"></i>
                                معلومات الفاتورة
                            </a>
                        </li>
                        <li>
                            <a href="#tab12" data-toggle="tab">
                                <i class="fa fa-cube"></i>
                                حالة الفاتورة
                            </a>
                        </li>
                        <li>
                            <a href="#tab13" data-toggle="tab">
                                <i class="fa fa-cube"></i>
                                المرفقات
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <div class="row">
                            <div class="col-4">
                                <p>رقم الفاتورة : <strong>{{ $invoice->invoice_number }}</strong></p>
                                <p>تاريخ الفاتورة : <strong>{{ $invoice->invoice_date }}</strong></p>
                                <p>تاريخ الاستحقاق : <strong>{{ $invoice->due_date }}</strong></p>
                                <p>القسم : <strong>{{ $invoice->section->section_name }}</strong></p>
                                <p>المنتج : <strong>{{ $invoice->product->product_name }}</strong></p>
                            </div>
                            <div class="col-4">
                                <p>مبلغ التحصيل : <strong>{{ $invoice->amount_collection }} جنيه مصري</strong></p>
                                <p>العمولة : <strong>{{ $invoice->amount_commission }} جنيه مصري</strong></p>
                                <p>الخصم : <strong>{{ $invoice->discount }} جنيه مصري</strong></p>
                                <p>نسبة الضريبة : <strong>{{ $invoice->rate_vat }}</strong></p>
                                <p>قيمة الضريبة : <strong>{{ $invoice->value_vat }} جنيه مصري</strong></p>
                                <p>الاجمالي شامل الضريبة : <strong>{{ $invoice->total }} جنيه مصري</strong></p>
                            </div>
                            <div class="col-4">
                                <p>ملاحظات : <strong>{{ $invoice->note ? $invoice->note : 'لا توجد ملاحظات' }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab12">
                        @foreach ($invoice->details as $detail)
                        <div class="row alert mb-4 @if($detail->value_status == 1) alert-success @elseif($detail->value_status == 2) alert-danger @else alert-warning @endif">
                            <div class="col">
                                <p>التاريخ : <strong>{{ $invoice->invoice_date }}</strong></p>
                                <p>الحالة :
                                    <strong>
                                        @if($detail->value_status == 1)
                                        <span class="text-success">{{ $detail->status }}</span>
                                        @elseif($detail->value_status == 2)
                                        <span class="text-danger">{{ $detail->status }}</span>
                                        @else
                                        <span class="text-warning">{{ $detail->status }}</span>
                                        @endif
                                    </strong>
                                </p>
                            </div>
                            <div class="col">
                                <p>{{ $detail->payment_date ? 'تاريخ الدفع' : 'تاريخ الاستحقاق' }} : <strong>{{ $detail->payment_date ?? $invoice->due_date }}</strong></p>
                                <p>مبلغ التحصيل : <strong>{{ $detail->part_paid ?? $invoice->amount_collection }} جنيه مصري</strong></p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane" id="tab13">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">المرفقات</h4>
                        </div>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('attachs.store') }}">
                            @csrf
                            <div class="custom-file mb-4">
                                <input type="file" class="custom-file-input" id="customFile" name="attach" required />
                                <input type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}" />
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />
                                <label for="customFile" class="custom-file-label">حدد المرفق</label>
                            </div>
                            <button type="submit" class="btn btn-success">تأكيد</button>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المرفق</th>
                                        <th>رقم الفاتورة</th>
                                        <th>خيارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($invoice->attach->all()) --}}
                                    @foreach ($attachs as $attach)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attach->file_name }}</td>
                                        <td>{{ $attach->invoice_number }}</td>
                                        <td>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-sign"
                                                data-toggle="modal" href="#delete_{{ $attach->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                        <!-- Delete Modal effects -->
                                        <div class="modal" id="delete_{{ $attach->id }}">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">حذف المرفق : {{ $attach->file_name }}</h6>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('attachs.destroy', 'test') }}"
                                                            method="post" id="delete-attach_{{ $attach->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="attach_id"
                                                                value="{{ $attach->id }}" />
                                                            <input type="hidden" name="file_name"
                                                                value="{{ $attach->file_name }}" />
                                                            <input type="hidden" name="invoice_number"
                                                                value="{{ $attach->invoice_number }}" />
                                                            <label class="col-form-label">هل انت متأكد من حذف المرفق
                                                                ؟</label>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-danger" type="button"
                                                            onclick="event.preventDefault();document.getElementById('delete-attach_{{ $attach->id }}').submit();">تأكيد</button>
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                                                            type="button">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal effects-->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!---Prism Pre code-->
    </div>
</div>

@endsection
@section('js')
@endsection
