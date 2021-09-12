@extends('layouts.master')
@section('title', 'طباعة الفاتورة رقم : ' . $invoice->invoice_number)
@section('css')
<style>
    @media print{
        #print_button {
            display: none;
        }
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة
                الفاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class="main-content-body-invoice" id="print">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">فاتورة رقم : {{ $invoice->invoice_number }}</h1>
                        <div class="billed-from">
                            <h6>BootstrapDash, Inc.</h6>
                            <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                Tel No: 324 445-4544<br>
                                Email: youremail@companyname.com</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <label class="tx-gray-600">Billed To</label>
                            <div class="billed-to">
                                <h6>Juan Dela Cruz</h6>
                                <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات الفاتورة</label>
                            <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>GHT-673-00</span></p>
                            <p class="invoice-info-row"><span>تاريخ الاصدار</span> <span>32334300</span></p>
                            <p class="invoice-info-row"><span>تاريخ الاستحقاق</span> <span>November 21, 2017</span></p>
                            <p class="invoice-info-row"><span>القسم</span> <span>November 30, 2017</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">المنتج</th>
                                    <th class="tx-right">مبلغ التحصيل</th>
                                    <th class="tx-center">مبلغ العمولة</th>
                                    <th class="tx-right">الاجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">{{ $invoice->product->product_name }}</td>
                                    <td class="tx-center">{{ number_format($invoice->amount_collection, 2) }}</td>
                                    <td class="tx-right">{{ number_format($invoice->amount_commission, 2) }}</td>
                                    @php
                                        $total = $invoice->amount_collection + $invoice->amount_commission;
                                    @endphp
                                    <td class="tx-right">{{ number_format($total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13"></label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">الاجمالي</td>
                                    <td class="tx-right" colspan="2">{{ number_format($total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">قيمة نسبة الضريبة ({{ $invoice->rate_vat }})</td>
                                    <td class="tx-right" colspan="2">{{ $invoice->value_vat }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">الخصم</td>
                                    <td class="tx-right" colspan="2">-{{ $invoice->discount }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{ number_format($invoice->total, 2) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">
                    @can('invoice-print')
                    <button id="print_button" onclick="printDiv()" class="btn btn-danger float-left mt-3 mr-2">
                        <i class="mdi mdi-printer ml-1"></i>طباعة
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
<!-- row closed -->
@endsection
@section('js')
<script>
    function printDiv(){
        var content = document.getElementById('print').innerHTML,
            mainContent = document.body.innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = mainContent;
        location.reload();
    }
</script>
@endsection
