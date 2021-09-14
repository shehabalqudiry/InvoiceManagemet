<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use App\Notifications\InvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:invoice-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:invoice-delete', ['only' => ['destroy']]);
    }

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

            $user = auth()->user();
            $user->notify(new AddInvoice($invoice->id));

            $admin = User::find(1);
            $admin->notify(new InvoiceNotification($invoice->id));

            DB::commit();
            session()->flash('success', 'تم حفظ البيانات بنجاح');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $attachs = $invoice->attachs;
        // Mark Notification as Read
        if(auth()->user()->getRoleNames() == ['owner']){
            $user = User::find(1);
            $noti = $user->notifications->where("data.id", $id)->first()->markAsRead();
        }
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

    public function archivePage()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive', compact(['invoices']));
    }
    public function unArchive($id)
    {
        try {
            Invoice::withTrashed()->findOrFail($id)->restore();
            return redirect()->back()->with('success', 'تم إلغاء ارشفة الفاتورة');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function archive(Request $request)
    {
        try {
            $invoice = Invoice::findOrFail($request->invoice_id);
            $invoice->delete();
            return redirect()->back()->with('success', 'تم نقل الفاتورة الي الارشيف');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            if (!empty($invoice->attachs->invoice_number)) {
                Storage::disk('local')->deleteDirectory($invoice->attachs->invoice_number);
            }
            $invoice->forceDelete();
            session()->flash('invoice_delete');
            return redirect()->back()->with('success', 'تم حذف الفاتورة');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function getProducts($section_id)
    {
        $products = Product::where('section_id', $section_id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function editPayment($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.payment.edit', compact('invoice'));
    }

    public function updatePayment($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $invoice = Invoice::findOrFail($id);
            $invoice->update([
                'value_status'      => $request->status,
                'status'            => $request->status == 1 ? 'مدفوعه' : 'مدفوعة جزئيا',
                'payment_date'      => $request->payment_date,
                'total'             => $request->part_paid ? $invoice->total - $request->part_paid : $invoice->total,
            ]);
            InvoiceDetail::create([
                'invoice_id'        => $invoice->id,
                'invoice_number'    => $invoice->invoice_number,
                'section_id'        => $invoice->section_id,
                'product_id'        => $invoice->product_id,
                'value_status'      => $request->status,
                'status'            => $request->status == 1 ? 'مدفوعه' : 'مدفوعة جزئيا',
                'note'              => $invoice->note,
                'user'              => auth()->user()->name,
                'payment_date'      => $request->payment_date,
            ]);
            DB::commit();
            session()->flash('success', 'تم حفظ البيانات بنجاح');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function paid()
    {
        $invoices = Invoice::withTrashed()->where('value_status', 1)->get();
        return view('invoices.paid', compact(['invoices']));
    }
    public function unpaid()
    {
        $invoices = Invoice::withTrashed()->where('value_status', 2)->get();
        return view('invoices.unpaid', compact(['invoices']));
    }
    public function part_paid()
    {
        $invoices = Invoice::withTrashed()->where('value_status', 3)->get();
        return view('invoices.part_paid', compact(['invoices']));
    }

    public function print_info($id)
    {
        $invoice = Invoice::withTrashed()->findOrFail($id);
        return view('invoices.print_invoice', compact(['invoice']));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}
