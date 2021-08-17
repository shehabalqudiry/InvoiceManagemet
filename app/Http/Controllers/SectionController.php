<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        // Get All Sections
        $sections = Section::all();
        // Return Section Page With $sections
        return view('sections.sections', compact(['sections']));
    }

    // Store New Section

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'section_name' => 'required|unique:sections',
                'description' => 'nullable',
            ]);

            $data['created_by'] = auth()->user()->name;

            Section::create($data);
            session()->flash('success', 'تم حفظ القسم بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'القسم موجود مسبقا');
            return redirect()->back();
        }
    }

    public function update(Request $request, Section $section)
    {
        try {
            $data = $request->validate([
                'section_name' => 'required|unique:sections,section_name,' . $section->id,
                'description' => 'nullable',
            ]);

            $section->update($data);
            session()->flash('success', 'تم تعديل القسم بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Section $section)
    {
        try {
            $section->delete();
            session()->flash('success', 'تم حذف القسم بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطاء في : ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
