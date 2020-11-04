<?php

namespace App\Exports;

use App\Mes;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class ComprasExportView implements FromView
{
    public $mes_id=0;
    public function __construct($m_id){
        $this->mes_id=$m_id;
    }
    public function view():View
    {
        return view('compra.libro_carta_excel')->with('mes',Mes::find($this->mes_id));
    }
}
