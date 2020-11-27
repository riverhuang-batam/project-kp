<!DOCTYPE html>
<html>
    <body>
        <table>
            <tr>
                <td colspan="4"><p>CV CHALISTA ENGINEERING BATAM</p></td>
            </tr>
            <tr>
                <td colspan="4"><p>Laporan Laba Rugi</p></td>
            </tr>
            <tr>
                <td colspan="4"><p>Tampilkan bulan dan tahun</p></td>
            </tr>
            <tr>
                <td><p>Pendapatan</p></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><p>Penjualan Bersih</p></td>
                <td></td>
                <td><p>{{$data['sale']}}</p></td>
                <td></td>
            </tr>
            <tr>
                <td><p>Retur dan Potongan</p></td>
                <td><p>{{$data['retur']}}</p></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><p>Diskon penjualan</p></td>
                <td><p>{{$data['discount']}}</p></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><p>Penjualan Bersih</p></td>
                <td></td>
                <td></td>
                <td><p>{{$data['sale'] - ($data['discount'] + $data['retur'])}}</p></td>
            </tr>
            <tr>
                <td><p>Harga Pokok Penjualan</p></td>
                <td></td>
                <td></td>
                <td><p>{{$data['purchase']}}</p></td>
            </tr>
            <tr>
                <td><p>Total Laba Kotor</p></td>
                <td></td>
                <td></td>
                <td><p>{{$data['sale'] - ($data['discount'] + $data['retur'] + $data['purchase'])}}</p></td>
            </tr>

            <tr>
            </tr>

            <tr>
                <td><p>Beban Operasional</p></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><p>Biaya Gaji</p></td>
                <td></td>
                <td></td>
                <td>{{$data['gaji']}}</td>
            </tr>
            <tr>
                <td><p>Biaya Asuransi</p></td>
                <td></td>
                <td></td>
                <td>{{$data['asuransi']}}</td>
            </tr>
        </table>
    </body>
</html>
