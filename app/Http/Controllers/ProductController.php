<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact(['products', 'sections']));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'product_name'  => 'required',
                'section_id'    => 'required',
                'description'   => 'nullable',
            ]);

            Product::create($data);
            session()->flash('success', 'تم حفظ المنتج بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        
    }

    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validate([
                'product_name'  => 'required',
                'section_id'    => 'required',
                'description'   => 'nullable',
            ]);

            $product->update($data);
            session()->flash('success', 'تم تعديل المنتج بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            session()->flash('success', 'تم حذف المنتج بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
