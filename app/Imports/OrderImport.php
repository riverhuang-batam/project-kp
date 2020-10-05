<?php

namespace App\Imports;

use App\Models\Order as Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class OrderImport implements ToModel
{
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row)
  {
    return new Order([
      // 'date' => Carbon::parse($row[0])->format('Y-m-d'),
      'marking' => $row[0],
      'items' => $row[1],
      'qty' => $row[2],
      'ctns' => $row[3],
      'volume' => $row[4],
      'pl' => $row[5],
      'resi' => $row[6],
      // 'expected_date' => Carbon::parse($row[8])->format('Y-m-d')->toDateString(),
      'status' => $row[7],
      'invoice' => $row[8],
      'remarks' => $row[9],
    ]);
  }
}
