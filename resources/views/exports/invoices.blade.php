<table>
    <thead>
        <tr>
            <th>#</th>
            <th>رقم الفاتورة</th>
            <th>التاريخ</th>
            <th>تاريخ الاستحقاق</th>
            <th>القسم</th>
            <th>المنتج</th>
            <th>مبلغ التحصيل</th>
            <th>مبلغ العمولة</th>
            <th>الخصم</th>
            <th>النسبة الضريبية</th>
            <th>الضريبة</th>
            <th>الأجمالي</th>
            <th>الحالة</th>
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
        </tr>
        @endforeach
    </tbody>
</table>

