@extends('layouts.master')
@section('title', 'قائمة الفواتير')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                الفواتير</span>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
        <a class="btn btn-block btn-primary" href="{{ route('invoices.create') }}">اضافة فاتورة</a>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <!--div-->
    <div class="col">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">قائمة الفواتير</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table key-buttons text-md-nowrap text-center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">التاريخ</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">مبلغ التحصيل</th>
                                <th class="border-bottom-0">مبلغ العمولة</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">النسبة الضريبية</th>
                                <th class="border-bottom-0">الضريبة</th>
                                <th class="border-bottom-0">الأجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">الإعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('invoices.show', $invoice->id) }}">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                </td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>{{ $invoice->section->section_name }}</td>
                                <td>{{ $invoice->product->product_name }}</td>
                                <td>{{ $invoice->amount_collection }}</td>
                                <td>{{ $invoice->amount_commission }}</td>
                                <td>{{ $invoice->discount }}</td>
                                <td>{{ $invoice->rate_vat }}</td>
                                <td>{{ $invoice->value_vat }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>
                                    @if($invoice->value_status == 1)
                                    <span class="text-success">{{ $invoice->status }}</span>
                                    @elseif($invoice->value_status == 2)
                                        <span class="text-danger">{{ $invoice->status }}</span>
                                    @else
                                        <span class="text-warning">{{ $invoice->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $invoice->note }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary" data-toggle="dropdown"
                                            id="dropdownMenuButton" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                        <div class="dropdown-menu tx-13">
                                            <a class="dropdown-item" href="{{ route('invoices.show', $invoice->id) }}">عرض</a>
                                            <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
@endsection
@section('js')

@endsection
