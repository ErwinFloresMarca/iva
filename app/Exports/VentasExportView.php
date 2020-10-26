<?php

namespace App\Exports;

use App\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;

class VentasExportView implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Venta::all();
    }
}
