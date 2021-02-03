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
            ->whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->get();
        for($i = 0; $i < count($purchases); $i++) {
            $purchaseTotal += $purchases[$i]->grand_total;
        }

        // get total sale
        $sales = Sale::select('grand_total')
            ->whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->get();
        for($i = 0; $i < count($sales); $i++) {
            $salesTotal += $sales[$i]->grand_total;
        }

        // gaji Beban Gaji
        $salaries = JurnalDetail::select('debit')
            ->where('akun_id', 11)
            // ->orWhere('akun_id', 54)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($salaries); $i++) {
            $salaryTotal += $salaries[$i]->debit;
        }

        // sales discount discount penjualan 
        $saleDiscounts = JurnalDetail::select('debit')
            ->where('akun_id', 12)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($saleDiscounts); $i++) {
            $salesDiscountTotal += $saleDiscounts[$i]->debit;
        }

        // sales return Retur Penjualan
        $saleReturns = JurnalDetail::select('debit')
            ->where('akun_id', 13)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($saleReturns); $i++) {
            $salesReturTotal += $saleReturns[$i]->debit;
        }

        // sewa gedung beban sewa gedung
        $buildingExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 14)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();

        for($i = 0; $i < count($buildingExpenses); $i++) {
            $buildingExpenseTotal += $buildingExpenses[$i]->debit;
        }

        // equipment
        $equipments = JurnalDetail::select('debit')
            ->where('akun_id', 15)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($equipments); $i++) {
            $equipmentTotal += $equipments[$i]->debit;
        }

        // freight out
        $freightOuts = JurnalDetail::select('debit')
            ->where('akun_id', 16)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($freightOuts); $i++) {
            $freightOutTotal += $freightOuts[$i]->debit;
        }

        // other sales total Operational Expense
        $otherSales = JurnalDetail::select('debit')
            ->where('akun_id', 17)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($otherSales); $i++) {
            $otherSalesTotal += $otherSales[$i]->debit;
        }

        // other expense total listrik dan air
        $otherExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 18)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();
        for($i = 0; $i < count($otherExpenses); $i++) {
            $otherExpenseTotal += $otherExpenses[$i]->debit;
        }

        // administration expense total
        $administrationExpenses = JurnalDetail::select('debit')
            ->where('akun_id', 19)
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
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
