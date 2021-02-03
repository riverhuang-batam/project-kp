<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('akuns')->delete();
        $akuns = [

            [
                'code' => '1.1.1.',
                'name' => 'Kas',
            ],
            [
                'code' => '1.1.2.',
                'name' => 'Piutang Usaha',
            ],
            [
                'code' => '1.1.10.',
                'name' => 'Persediaan',
            ],
            [
                'code' => '1.2.',
                'name' => 'Aset Tetap',
            ],
            [
                'code' => '1.1.11.',
                'name' => 'Biaya Dibayar Muka',
            ],
            [
                'code' => '2.1.1.',
                'name' => 'Utang Dagang',
            ],
            [
                'code' => '2.1.4.',
                'name' => 'Pendapatan Tidak Diterima',
            ],
            [
                'code' => '2.2.',
                'name' => 'Liabilitas Jangka Panjang',
            ],
            [
                'code' => '2.2.1.',
                'name' => 'Hutang Bank',
            ],
            [
                'code' => '3.1.1.',
                'name' => 'Capital',
            ],


            [
                'code' => '1.2.1.',
                'name' => 'Beban Penyusutan Peralatan',
            ],
            [
                'code' => '4.1.2.',
                'name' => 'Retur Penjualan',
            ],
            [
                'code' => '4.1.3.',
                'name' => 'Discount Penjualan',
            ],
            [
                'code' => '6.1.1',
                'name' => 'Beban Penjualan Lainnya',
            ],
            [
                'code' => '6.1.5.',
                'name' => 'Ongkos Kirim Penjualan',
            ],
            [
                'code' => '6.2.',
                'name' => 'Beban Administrasi Lainnya',
            ],
            [
                'code' => '6.2.1.',
                'name' => 'Beban Gaji',
            ],
            [
                'code' => '6.2.4.',
                'name' => 'Beban Sewa Gedung',
            ],
            [
                'code' => '7.2.',
                'name' => 'Beban Listrik dan Air',
            ],
        ];
        foreach ($akuns as $akun) {
            Akun::create($akun);
        }
    }
}
