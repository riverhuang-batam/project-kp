<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi</title>
	{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
        },
        table {
            width: 100%;
        },
        .flex {
            width: 100%;
        },
        .left{
            float: left;
            width: 50%;
        },
        .right{
            float: right;
            width: 50%;
        }
	</style>
	<center>
        <h5>Laporan Laba & Rugi</h4>
		<h5>CV CHALISTA ENGINEERING BATAM</h4>
		<h6>{{$reportMonthYear}}</h5>
    </center>
    @php
        $totalAsetLancar = $cashTotal + $accountReceivableTotal + $suppliesTotal + $prepaidExpenseTotal;
        $totalAset = $totalAsetLancar + $fixedAssetTotal;
        $totalLiabilitas = $accountPayableTotal + $unearnedRevenueTotal + $longTermTotal + $bankLoanTotal;
        $totalEkuitas = $capitalTotal;
        $totalLiabilitasEkuitas = $totalLiabilitas + $totalEkuitas;
    @endphp
    <div class="flex">
        <div class="left">
            <table class='table'>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Aset</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Aset Lancar</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Kas</p></td>
                        <td class="text-right border-0">{{  number_format($cashTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Piutang Usaha</p></td>
                        <td class="text-right border-0">{{ number_format($accountReceivableTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Persediaan</p></td>
                        <td class="text-right border-0">{{ number_format($suppliesTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Biaya Dibayar Muka</p></td>
                        <td class="text-right border-0">{{ number_format($prepaidExpenseTotal) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Aset Lancar</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalAsetLancar) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Aset Tidak Lancar</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Aset Tetap</p></td>
                        <td class="text-right border-0">{{  number_format($fixedAssetTotal) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Aset Lancar</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalAsetLancar) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Aset</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalAset) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="right">
            <table class='table'>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Liabilitas</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Akun Hutang</p></td>
                        <td class="text-right border-0">{{  number_format($longTermTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Pendapatan Tidak Diterima</p></td>
                        <td class="text-right border-0">{{  number_format($unearnedRevenueTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Pendapatan Tidak Diterima</p></td>
                        <td class="text-right border-0">{{  number_format($unearnedRevenueTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Liabilitas Jangka Panjang</p></td>
                        <td class="text-right border-0">{{  number_format($longTermTotal) }}</td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Hutang Bank</p></td>
                        <td class="text-right border-0">{{  number_format($bankLoanTotal) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Liabilitas</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalLiabilitas) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Ekuitas</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p class="ml-4 mb-0">Modal</p></td>
                        <td class="text-right border-0">{{  number_format($capitalTotal) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Ekuitas</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalEkuitas) }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jumlah Liabilitas & Ekuitas</td>
                        <td class="text-right font-weight-bold border-0">{{ number_format($totalEkuitas) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>