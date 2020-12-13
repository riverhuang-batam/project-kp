<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalDetail;
use App\Models\LabaRugi;
use Illuminate\Http\Request;
use PDF;


class CapitalController extends Controller
{
    public function index()
    {
        return view('perubahan-modal.index');
    }

    public function print(Request $request)
    {
        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        // laba rugi
        $labaRugi = LabaRugi::select('laba_rugi')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'DESC')
            ->first();
        if($labaRugi == null) {
            return redirect()->route('perubahan-modal.index')->with('error', "Monthly laba and rugi haven't printed! Please print it first!");
        }

        // owner equity
        $equity = JurnalDetail::select('credit')
            ->where('akun_id', 32)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'DESC')
            ->first();

        // prive
        $priveSetorTotal = 0;
        $priveTarikTotal = 0;
        $prive = JurnalDetail::select('debit', 'credit')
            ->where('akun_id', 34)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        for($i = 0; $i < count($prive); $i++)
        {
            $priveTarikTotal += $prive[$i]->debit;
            $priveSetorTotal += $prive[$i]->credit;
        }

        $pdf = PDF::loadview('perubahan-modal.laporan',
            [
                'labaRugiTotal' => $labaRugi->laba_rugi,
                'equityTotal' => $equity->credit,
                'priveTarikTotal' => $priveTarikTotal,
                'priveSetorTotal' => $priveSetorTotal,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );

        return $pdf->stream('laporan-perubahan-modal-'.$request->month.'.pdf');
    }
}
