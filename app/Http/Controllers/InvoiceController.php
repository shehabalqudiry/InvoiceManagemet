<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact(['invoices']));
    }

    public function create()
    {
        $sections = Section::all();
        return view('invoices.create', compact(['sections']));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                "invoice_number"    => "required",
                "invoice_date"      => "required",
                "due_date"          => "required",
                "section_id"        => "required",
                "product_id"        => "required",
                "amount_collection" => "required",
                "amount_commission" => "required",
                "discount"          => "nullable",
                "rate_vat"          => "required",
                "value_vat"         => "required",
                "total"             => "required",
                "note"              => "nullable",
            ]);
            $data['status'] = "غير مدفوعة";
            $data['value_status'] = 2;
            $data['user'] = auth()->user()->name;

            $invoice = Invoice::create($data);

            $invoiceDetails = InvoiceDetail::create([
                'invoice_id'        => $invoice->id,
                'invoice_number'    => $invoice->invoice_number,
                'section_id'        => $invoice->section_id,
                'product_id'        => $invoice->product_id,
                'status'            => $invoice->status,
                'value_status'      => $invoice->value_status,
                'note'              => $invoice->note,
                'user'              => auth()->user()->name,
            ]);

            if ($request->hasFile('attach')) {
                $image = $request->file('attach');
                $attach = new InvoiceAttachment();
                $attach->file_name = $image->getClientOriginalName();
                $attach->invoice_number = $invoice->invoice_number;
                $attach->created_by = auth()->user()->name;
                $attach->invoice_id = $invoice->id;
                $attach->save();

                $image->storeAs('invoices/' . $invoice->invoice_number, $image->getClientOriginalName());
            }

            DB::commit();

            session()->flash('success', 'تم حفظ البيانات بنجاح');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
            // return $e->getMessage();
        }
    }

    public function show(Invoice $invoice)
    {
        $attachs = $invoice->attachs;
        return view('invoices.details', compact(['invoice', 'attachs']));
    }

    public function edit(Invoice $invoice)
    {
        $sections = Section::all();
        return view('invoices.edit', compact(['invoice', 'sections']));
    }

    public function update(Request $request, Invoice $invoice)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                "invoice_number"    => "required",
                "invoice_date"      => "required",
                "due_date"          => "required",
                "section_id"        => "required",
                "product_id"        => "required",
                "amount_collection" => "required",
                "amount_commission" => "required",
                "discount"          => "nullable",
                "rate_vat"          => "required",
                "value_vat"         => "required",
                "total"             => "required",
                "note"              => "nullable",
            ]);
            $data['status'] = "غير مدفوعة";
            $data['value_status'] = 2;
            $data['user'] = auth()->user()->name;

            $invoice->update($data);
            $invoiceDetails = InvoiceDetail::where('invoice_id', $invoice->id)->first();
            $invoiceDetails->update([
                'invoice_id'        => $invoice->id,
                'invoice_number'    => $invoice->invoice_number,
                'section_id'        => $invoice->section_id,
                'product_id'        => $invoice->product_id,
                'status'            => $invoice->status,
                'value_status'      => $invoice->value_status,
                'note'              => $invoice->note,
                'user'              => auth()->user()->name,
            ]);

            if ($request->hasFile('attach')) {
                $image = $request->file('attach');
                $attach = new InvoiceAttachment();
                $attach->file_name = $image->getClientOriginalName();
                $attach->invoice_number = $invoice->invoice_number;
                $attach->created_by = auth()->user()->name;
                $attach->invoice_id = $invoice->id;
                $attach->save();

                $image->storeAs('invoices/' . $invoice->invoice_number, $image->getClientOriginalName());
            }

            DB::commit();

            session()->flash('success', 'تم حفظ البيانات بنجاح');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
            // return $e->getMessage();
        }
    }

    public function destroy(Invoice $invoice)
    {
        //
    }


    public function getProducts($section_id)
    {
        $products = Product::where('section_id', $section_id)->pluck('product_name', 'id');
        return json_encode($products);
    }
}
