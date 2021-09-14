<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total = Invoice::count();

        $paid = Invoice::where('value_status', 1)->count() / $total * 100;
        $part_paid = Invoice::where('value_status', 3)->count() / $total * 100;
        $unpaid = Invoice::where('value_status', 2)->count() / $total * 100;
        
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(["الفواتير مدفوعة", "الفواتير المدفوعة جزئيا", "الفواتير الغير مدفوعة"])
            ->datasets([
                [
                    "label" => "نسبة الفواتير",
                    'backgroundColor' => ['#0F52BA', '#0F52BA', '#0F52BA'],
                    'data' => [$paid, $part_paid, $unpaid]
                ],
            ])
            ->options([]);

        return view('home', compact(['chartjs']));
    }
}
