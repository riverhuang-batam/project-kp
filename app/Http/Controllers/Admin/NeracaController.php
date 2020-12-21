<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use PDF;

class NeracaController extends Controller
{
    public function index()
    {
        return view('neraca.index');
    }

    public function print(Request $request)
    {
        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        // aset lancar
        $cashTotal = 0;
        $accountReceivableTotal = 0;
        $suppliesTotal = 0;
        $prepaidExpenseTotal = 0;

        // get cash total
        $cashs = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 3)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($cashs); $i++) {
            $cashTotal += ($cashs[$i]->credit - $cashs[$i]->debit);
        }

        // get accountreceivable
        $accountReceivables = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 4)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($accountReceivables); $i++) {
            $accountReceivableTotal += ($accountReceivables[$i]->credit - $accountReceivables[$i]->debit);
        }

        // get supplies
        $supplies = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 12)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($supplies); $i++) {
            $suppliesTotal += ($supplies[$i]->credit - $supplies[$i]->debit);
        }

        // get prepaid expense
        $prepaidExpenses = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 12)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($prepaidExpenses); $i++) {
            $prepaidExpenseTotal += ($prepaidExpenses[$i]->credit - $prepaidExpenses[$i]->debit);
        }

        // aset tidak lancar
        $fixedAssetTotal = 0;

        $fixedAssets = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 14)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($fixedAssets); $i++) {
            $fixedAssetTotal += ($fixedAssets[$i]->credit - $fixedAssets[$i]->debit);
        }

        // liabilitas
        $accountPayableTotal = 0;
        $unearnedRevenueTotal = 0;
        $longTermTotal = 0;
        $bankLoanTotal = 0;

        $accountPayables = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 26)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($accountPayables); $i++) {
            $accountPayableTotal += ($accountPayables[$i]->credit - $accountPayables[$i]->debit);
        }

        $unearnRevenues = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 29)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($unearnRevenues); $i++) {
            $unearnedRevenueTotal += ($unearnRevenues[$i]->credit - $unearnRevenues[$i]->debit);
        }

        $longTermLiabilities = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 30)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($longTermLiabilities); $i++) {
            $longTermTotal += ($longTermLiabilities[$i]->credit - $longTermLiabilities[$i]->debit);
        }

        $bankLoans = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 31)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($bankLoans); $i++) {
            $bankLoanTotal += ($bankLoans[$i]->credit - $bankLoans[$i]->debit);
        }

        // ekuitas
        $capitalTotal = 0;

        $capitals = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 33)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($capitals); $i++) {
            $capitalTotals += ($capitals[$i]->credit - $capitals[$i]->debit);
        }

        $pdf = PDF::loadview('neraca.laporan', 
            [
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
                'cashTotal' => $cashTotal,
                'accountReceivableTotal' => $accountReceivableTotal,
                'suppliesTotal' => $suppliesTotal,
                'prepaidExpenseTotal' => $prepaidExpenseTotal,
                'fixedAssetTotal' => $fixedAssetTotal,
                'accountPayableTotal' => $accountPayableTotal,
                'unearnedRevenueTotal' => $unearnedRevenueTotal,
                'longTermTotal' => $longTermTotal,
                'bankLoanTotal' => $bankLoanTotal,
                'capitalTotal' => $capitalTotal,
            ]
        );
        return $pdf->stream('laporan-neraca-'.$request->month.'.pdf');
    }
}
