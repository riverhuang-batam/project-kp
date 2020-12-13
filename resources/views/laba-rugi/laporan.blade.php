<!DOCTYPE html>
<html>
<head>
	<title>Laporan Laba Rugi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
        <h5>Laporan Laba & Rugi</h4>
		<h5>CV CHALISTA ENGINEERING BATAM</h4>
		<h6>{{$reportMonthYear}}</h5>
	</center>
    @php
        $totalPendapatan = $salesTotal - ($salesDiscount + $salesRetur);
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $totalBebanOperasional = $equipmentTotal + $freightOutTotal + $otherSalesTotal + $salaryTotal + $buildingExpenseTotal + $otherExpenseTotal + $administrationExpenseTotal;
        $totalLabaBersihOperasional = $totalLabaKotor - $totalBebanOperasional;
    @endphp
	<table class='table'>
		<tbody>
			<tr>
                <td class="font-weight-bold">Penjualan</td>
                <td></td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Penjualan</p></td>
                <td class="text-right border-0">{{ number_format($salesTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Discount Penjualan</p></td>
                <td class="text-right border-0">{{ number_format($salesDiscount) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Retur Penjualan</p></td>
                <td class="text-right border-0">{{ number_format($salesRetur) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Total Pendapatan</td>
                <td class="text-right font-weight-bold border-0">{{ number_format($totalPendapatan) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Harga Pokok Penjualan</td>
                <td></td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Harga Pokok Penjualan</p></td>
                <td class="text-right border-0">{{ number_format($purchaseTotal) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Total Harga Pokok Penjualan</td>
                <td class="text-right font-weight-bold border-0">({{ number_format($purchaseTotal) }})</td>
            </tr>
            <tr>
                <td class="font-weight-bold">TOTAL LABA KOTOR</td>
                <td class="text-right font-weight-bold">{{ number_format($salesTotal - $purchaseTotal) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Beban Operasional</td>
                <td></td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Penyusutan Peralatan</p></td>
                <td class="text-right font-weight-bold">{{ number_format($equipmentTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Ongkos Kirim Penjualan</p></td>
                <td class="text-right font-weight-bold">{{ number_format($freightOutTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Penjualan Lainnya</p></td>
                <td class="text-right font-weight-bold">{{ number_format($otherSalesTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Gaji</p></td>
                <td class="text-right font-weight-bold">{{ number_format($salaryTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Sewa Gedung</p></td>
                <td class="text-right font-weight-bold">{{ number_format($buildingExpenseTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Listrik dan Air</p></td>
                <td class="text-right font-weight-bold">{{ number_format($otherExpenseTotal) }}</td>
            </tr>
            <tr>
                <td><p class="ml-4 mb-0">Beban Administrasi Lainnya</p></td>
                <td class="text-right font-weight-bold">{{ number_format($administrationExpenseTotal) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">LABA BERSIH OPERASIONAL</td>
                <td class="text-right font-weight-bold">({{ number_format($totalLabaBersihOperasional) }})</td>
            </tr>
            <tr>
                <td class="font-weight-bold">LABA/(RUGI) BERSIH</td>
                <td class="text-right font-weight-bold">{{ number_format($totalLabaBersihOperasional) }}</td>
            </tr>
		</tbody>
	</table>
</body>
</html>