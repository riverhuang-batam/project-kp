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
                'code' => '1.',
                'name' => 'Assets',
            ],
            [
                'code' => '1.1.',
                'name' => 'Current Assets',
            ],
            [
                'code' => '1.1.1.',
                'name' => 'Cash',
            ],
            [
                'code' => '1.1.2.',
                'name' => 'Account Receivable',
            ],
            [
                'code' => '1.1.3.',
                'name' => 'Allowances for Doubtful',
            ],
            [
                'code' => '1.1.4.',
                'name' => 'Notes Receivable',
            ],
            [
                'code' => '1.1.5.',
                'name' => 'Revenue Receivable',
            ],
            [
                'code' => '1.1.6.',
                'name' => 'Raw Material Inventory',
            ],
            [
                'code' => '1.1.7.',
                'name' => 'Work In Process Inventory',
            ],
            [
                'code' => '1.1.8.',
                'name' => 'Finished Goods Inventory',
            ],
            [
                'code' => '1.1.9.',
                'name' => 'Helper Inventory',
            ],
            [
                'code' => '1.1.10.',
                'name' => 'Supplies',
            ],
            [
                'code' => '1.1.11.',
                'name' => 'Prepaid Expenses',
            ],
            [
                'code' => '1.2.',
                'name' => 'Fixed Assets',
            ],
            [
                'code' => '1.2.1.',
                'name' => 'Equipment',
            ],
            [
                'code' => '1.2.2.',
                'name' => 'Acc. Depre. Equipment',
            ],
            [
                'code' => '1.2.3.',
                'name' => 'Vechicle',
            ],
            [
                'code' => '1.2.4.',
                'name' => 'Acc. Depre. Vehicle',
            ],
            [
                'code' => '1.2.5.',
                'name' => 'Machine',
            ],
            [
                'code' => '1.2.6.',
                'name' => 'Acc. Depre. Machine',
            ],
            [
                'code' => '1.2.7.',
                'name' => 'Building',
            ],
            [
                'code' => '1.2.8.',
                'name' => 'Acc. Depre. Building',
            ],
            [
                'code' => '1.2.9.',
                'name' => 'Land',
            ],
            [
                'code' => '2.',
                'name' => 'Liabilities',
            ],
            [
                'code' => '2.1.',
                'name' => 'Current Liabilities',
            ],
            [
                'code' => '2.1.1.',
                'name' => 'Account Payable',
            ],
            [
                'code' => '2.1.2.',
                'name' => 'Notes Payable',
            ],
            [
                'code' => '2.1.3.',
                'name' => 'Expenses Payable',
            ],
            [
                'code' => '2.1.4.',
                'name' => 'Unearned Revenues',
            ],
            [
                'code' => '2.2.',
                'name' => 'Long Term Liabilities',
            ],
            [
                'code' => '2.2.1.',
                'name' => 'Bank Load',
            ],
            [
                'code' => '3.',
                'name' => "Owner's Equity",
            ],
            [
                'code' => '3.1.1.',
                'name' => 'Capital',
            ],
            [
                'code' => '3.1.2.',
                'name' => 'Prive',
            ],
            [
                'code' => '4.',
                'name' => 'Sales',
            ],
            [
                'code' => '4.1.1.',
                'name' => 'Sales',
            ],
            [
                'code' => '4.1.2.',
                'name' => 'Sales Returns and Allowances',
            ],
            [
                'code' => '4.1.3.',
                'name' => 'Sales Discounts',
            ],
            [
                'code' => '5.',
                'name' => 'Purchase',
            ],
            [
                'code' => '5.1.1',
                'name' => 'Purchase',
            ],
            [
                'code' => '5.1.2',
                'name' => 'Freight In',
            ],
            [
                'code' => '5.1.3',
                'name' => 'Purchase Return and Allowances',
            ],
            [
                'code' => '5.1.4.',
                'name' => 'Purchase Discounts',
            ],
            [
                'code' => '6.',
                'name' => 'Expenses',
            ],
            [
                'code' => '6.1.',
                'name' => 'Sales Expenses',
            ],
            [
                'code' => '6.1.1',
                'name' => 'Operational Expense',
            ],
            [
                'code' => '6.1.2.',
                'name' => 'Sales Salaries Expense',
            ],
            [
                'code' => '6.1.3.',
                'name' => 'Store Supplies Expense',
            ],
            [
                'code' => '6.1.4.',
                'name' => 'Depre. Store Equipment Expense',
            ],
            [
                'code' => '6.1.5.',
                'name' => 'Freight out',
            ],
            [
                'code' => '6.1.6.',
                'name' => 'Telkom Expense',
            ],
            [
                'code' => '6.2.',
                'name' => 'Adm. & General Expenses',
            ],
            [
                'code' => '6.2.1.',
                'name' => 'Office Salaries Expense',
            ],
            [
                'code' => '6.2.2.',
                'name' => 'Office Supplies Expense',
            ],
            [
                'code' => '6.2.3.',
                'name' => 'Depre. Office Equipment Expenses',
            ],
            [
                'code' => '6.2.4.',
                'name' => 'Rent Expense',
            ],
            [
                'code' => '6.2.5.',
                'name' => 'INsurance Expense',
            ],
            [
                'code' => '6.2.6.',
                'name' => 'Depre. Building Expense',
            ],
            [
                'code' => '6.2.7.',
                'name' => 'Depre. Vehicle Expense',
            ],
            [
                'code' => '6.2.8.',
                'name' => 'dll',
            ],
            [
                'code' => '7.',
                'name' => 'Other',
            ],
            [
                'code' => '7.1',
                'name' => 'Other Revenue',
            ],
            [
                'code' => '7.1.1.',
                'name' => 'Semua pend. diluar usaha',
            ],
            [
                'code' => '7.2.',
                'name' => 'Other Expenses',
            ],
            [
                'code' => '7.2.1',
                'name' => 'Semua biaya diluar usaha',
            ],
            [
                'code' => '7.3.1',
                'name' => 'Income Tax',
            ],
        ];
        foreach ($akuns as $akun) {
            Akun::create($akun);
        }
    }
}
