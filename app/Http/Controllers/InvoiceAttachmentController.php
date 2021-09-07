<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{

    public function store(Request $request)
    {
        if($request->hasFile('attach')){
            $image = $request->file('attach');
            $attach = new InvoiceAttachment();
            $attach->file_name = $image->getClientOriginalName();
            $attach->invoice_number = $request->invoice_number;
            $attach->created_by = auth()->user()->name;
            $attach->invoice_id = $request->invoice_id;
            $attach->save();

            $image->storeAs('invoices/' . $request->invoice_number , $image->getClientOriginalName());
            return redirect()->back()->with('success','تم اضاقة المرفق بنجاح');
        }
        return redirect()->back()->with('error','حدث خطأ الرجاء مراجعة ادمن النظام');
    }

    public function destroy(Request $request)
    {
        // dd($request->all());
        try {
            InvoiceAttachment::destroy($request->attach_id);
            Storage::disk('local')->delete('invoices/' . $request->invoice_number . '/' . $request->file_name);
            return redirect()->back()->with('success','تم حذف المرفق بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
