@extends('layouts.master')
@section('title', 'الفواتير المدفوعه جزئيا')
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير
                المدفوعه جزئيا</span>
        </div>
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
            @include('layouts.alert')
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">الفواتير المدفوعه جزئيا</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap text-center">
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
                                <th class="border-bottom-0">الإعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('invoices.show', $invoice->id) }}">
                                        {{ $invoice->invoice_number }} @if($invoice->deleted_at) <span
                                            class="badge badge-danger">مؤرشفة</span> @endif
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
                                <td>
                                    <div class="dropdown">
                                        <button aria-expanded="false" aria-haspopup="true"
                                            class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                            id="dropdownMenuButton" type="button">
                                            <i class="fas fa-caret-right ml-3"></i>
                                            العمليات
                                        </button>
                                        <div class="dropdown-menu tx-13">
                                            <a class="dropdown-item" href="{{ route('invoices.show', $invoice->id) }}">
                                                <i class="fa fa-eye ml-2"></i> عرض
                                            </a>
                                            @can('invoice-edit')
                                            <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">
                                                <i class="fa fa-edit ml-2"></i> تعديل
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('invoices.editPayment', $invoice->id) }}">
                                                <i class="fas fa-dollar-sign ml-2"></i> تعديل
                                                حالة الدفع</a>
                                            @endcan
                                            @can('invoice-delete')
                                            @if(!$invoice->deleted_at)
                                            <button class="dropdown-item"
                                                onclick="event.preventDefault();document.getElementById('archive-invoice_{{ $invoice->id }}').submit();">
                                                <i class="fas fa-file ml-2"></i> نقل الي الارشيف
                                            </button>
                                            <form class="d-none" action="{{ route('invoices.archive', $invoice->id) }}"
                                                method="post" id="archive-invoice_{{ $invoice->id }}">
                                                @csrf
                                                <input type="text" hidden value="{{ $invoice->id }}" name="invoice_id">
                                            </form>
                                            @else
                                            <button class="dropdown-item"
                                                onclick="event.preventDefault();document.getElementById('unarchive-invoice_{{ $invoice->id }}').submit();">
                                                <i class="fas fa-file ml-2"></i> إلغاء ارشفة الفاتورة
                                            </button>
                                            <form class="d-none"
                                                action="{{ route('invoices.unarchive', $invoice->id) }}" method="post"
                                                id="unarchive-invoice_{{ $invoice->id }}">
                                                @csrf
                                            </form>
                                            @endif
                                            @endcan
                                            @can('invoice-print')
                                            <a class="dropdown-item"
                                                href="{{ route('invoices.print_info',$invoice->id) }}">
                                                <i class="fa fa-print ml-2"></i> طباعة الفاتورة

                                            </a>
                                            @endcan
                                            @can('invoice-delete')
                                            <a class="modal-effect dropdown-item" data-effect="effect-sign"
                                                data-toggle="modal" href="#delete_{{ $invoice->id }}">
                                                <i class="fa fa-trash ml-2"></i> حذف نهائي
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @can('invoice-delete')
                            <!-- Delete Modal effects -->
                            <div class="modal" id="delete_{{ $invoice->id }}">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">حذف الفاتورة : {{ $invoice->invoice_number }}</h6>
                                            <button aria-label="Close" class="close" data-dismiss="modal"
                                                type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="post"
                                                id="delete-invoice_{{ $invoice->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <label class="col-form-label">هل انت متأكد من حذف الفاتورة نهائيا
                                                    ؟</label>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-danger" type="button"
                                                onclick="event.preventDefault();document.getElementById('delete-invoice_{{ $invoice->id }}').submit();">تأكيد</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal"
                                                type="button">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal effects-->
                            @endcan
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
