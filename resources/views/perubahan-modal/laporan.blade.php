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
        <h5>Laporan Perubahan Modal</h4>
		<h5>CV CHALISTA ENGINEERING BATAM</h4>
		<h6>{{$reportMonthYear}}</h5>
	</center>
    @php
        $penambahanModal = $priveSetorTotal + $labaRugiTotal - $priveTarikTotal;
        $modalAkhir = $equityTotal + $penambahanModal;
    @endphp
	<table class='table'>
		<tbody>
			<tr>
                <td class="font-weight-bold">Modal Awal</td>
                <td></td>
                <td class="text-right border-0">{{ number_format($equityTotal) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold ml">Prive Setor</td>
                <td class="text-right border-0">{{ number_format($priveSetorTotal) }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Laba Bersih Usaha</td>
                <td class="text-right border-0">{{ number_format($labaRugiTotal) }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Prive Ambil</td>
                <td class="text-right border-0">{{ number_format($priveTarikTotal) }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="font-weight-bold">Penambahan Modal</td>
                <td></td>
                <td class="text-right border-0">{{ number_format($penambahanModal) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Modal Akhir</td>
                <td></td>
                <td class="text-right border-0">{{ number_format($modalAkhir) }}</td>
            </tr>
		</tbody>
	</table>
</body>
</html>