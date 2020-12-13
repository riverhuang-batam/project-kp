<?php

namespace App\Http\Controllers\Admin;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\JurnalDetail;
use App\Models\LabaRugi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\LabaRugiExport;
use PDF;

class LabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laba-rugi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // return Excel::download(new LabaRugiExport($request->month), 'laba-rugi.xlsx');

        $purchaseTotal = 0;
        $salesTotal = 0;
        $salesDiscountTotal = 0;
        $salesReturTotal = 0;
        $otherSalesTotal = 0;

        $salaryTotal = 0;
        $buildingExpenseTotal = 0;
        $equipmentTotal = 0;
        $freightOutTotal = 0;
        $otherExpenseTotal = 0;
        $administrationExpenseTotal = 0;

        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        // get total purchase
        $purchases = Purchase::select('grand_total')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($purchases); $i++) {
            $purchaseTotal += $purchases[$i]->grand_total;
        }

        // get total sale
        $sales = Sale::select('grand_total')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($sales); $i++) {
            $salesTotal += $sales[$i]->grand_total;
        }

        // gaji
        $salaries = JurnalDetail::select('debit')
            ->where('akun_id', 53)
            ->orWhere('akun_id', 54)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($salaries); $i++) {
            $salaryTotal += $salaries[$i]->debit;
        }

        // sales discount
        $saleDiscounts = JurnalDetail::select('debit')
            ->where('akun_id', 38)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($saleDiscounts); $i++) {
            $salesDiscountTotal += $saleDiscounts[$i]->debit;
        }

        // sales return 
        $saleReturns = JurnalDetail::select('debit')
            ->where('akun_id', 37)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($saleReturns); $i++) {
            $salesReturTotal += $saleReturns[$i]->debit;
        }

        // sewa gedung
        $buildingExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 56)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        for($i = 0; $i < count($buildingExpenses); $i++) {
            $buildingExpenseTotal += $buildingExpenses[$i]->debit;
        }

        // equipment
        $equipments = JurnalDetail::select('debit')
            ->where('akun_id', 15)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($equipments); $i++) {
            $equipmentTotal += $equipments[$i]->debit;
        }

        // freight out
        $freightOuts = JurnalDetail::select('debit')
            ->where('akun_id', 50)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($freightOuts); $i++) {
            $freightOutTotal += $freightOuts[$i]->debit;
        }

        // other sales total
        $otherSales = JurnalDetail::select('debit')
            ->where('akun_id', 46)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($otherSales); $i++) {
            $otherSalesTotal += $otherSales[$i]->debit;
        }

        // other expense total
        $otherExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 64)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($otherSales); $i++) {
            $otherExpenseTotal += $otherExpenses[$i]->debit;
        }

        // administration expense total
        $administrationExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 52)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($administrationExpenses); $i++) {
            $administrationExpenseTotal += $administrationExpenses[$i]->debit;
        }

        // count all laba dan rugi
        $totalPendapatan = $salesTotal - ($salesDiscountTotal + $salesReturTotal);
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $totalBebanOperasional = $equipmentTotal + $freightOutTotal + $otherSalesTotal + $salaryTotal + $buildingExpenseTotal + $otherExpenseTotal + $administrationExpenseTotal;
        $totalLabaBersihOperasional = $totalLabaKotor - $totalBebanOperasional;
        LabaRugi::create([
            'laba_rugi' => $totalLabaBersihOperasional,
        ]);

        $pdf = PDF::loadview('laba-rugi.laporan',
            [
                'salesTotal' => $salesTotal,
                'salesDiscount' => $salesDiscountTotal,
                'salesRetur' => $salesReturTotal,
                'purchaseTotal' => $purchaseTotal,
                'salaryTotal' => $salaryTotal,
                'buildingExpenseTotal' => $buildingExpenseTotal,
                'equipmentTotal' => $equipmentTotal,
                'freightOutTotal' => $freightOutTotal,
                'otherSalesTotal' => $otherSalesTotal,
                'otherExpenseTotal' => $otherExpenseTotal,
                'administrationExpenseTotal' => $administrationExpenseTotal,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-laba-rugi-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
