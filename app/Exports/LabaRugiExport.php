<?php

namespace App\Exports;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LabaRugiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $date;

    function __construct($date) {
        $this->month = $date;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4    => ['font' => ['bold' => true]],
            9    => ['font' => ['bold' => true]],
            10    => ['font' => ['bold' => true]],
        ];
    }

    public function view(): View
    {
        $purchaseTotal = 0;
        $salesTotal = 0;
        $discountTotal = 0;
        $returTotal = 0;

        // month and year
        $dateYear=strtotime($this->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        // get total purchase
        $purchases = Purchase::select('grand_total')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        foreach($purchases as $purchase) {
            $purchaseTotal += $purchase->grand_total;
        }

        // get total sale
        $sales = Sale::select('grand_total')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        foreach($sales as $sale) {
            $salesTotal += $sale->grand_total;
        }

        return view('laba-rugi.format', [
            'data' => [
                'purchase' => $purchaseTotal,
                'sale' => $salesTotal,
                'discount' => $discountTotal,
                'retur' => $returTotal,
                'gaji' => 0,
                'asuransi' => 0,
                'listrik' => 0,
            ]
        ]);
    }
}