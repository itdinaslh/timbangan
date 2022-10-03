<?php

namespace App\Http\Livewire\Admin\Timbanganmasuk;

use Livewire\Component;
use DB;

class ShowDisplay extends Component
{
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = DB::connection('bg_db')->table('display_transaction')->where('tipe', '=', 'masuk')
        ->first();
        return view('livewire.admin.timbanganmasuk.show-display', ['data' => $data]);
    }
}
