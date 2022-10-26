<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Livewire\WithPagination;

class InfoEkspenditur extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filter = "";
    public $show = 5;
    public function render()
    {
        $data = DB::connection('bg_db')->table('rfid_card as a')
            ->leftJoin('ekspenditur_list', 'a.ekspenditur', '=', 'ekspenditur_list.id')
            ->leftJoin('tipe_truk', 'a.tipe', '=', 'tipe_truk.initial')
            ->select('a.*', 'tipe_truk.initial', 'ekspenditur_list.ekspenditur_name')
            ->when($this->filter, function ($builder) {
                $builder->where('a.ekspenditur', $this->filter);
            })->orderBy('id' ,'desc')
        ->paginate($this->show);
        $eks = DB::connection('bg_db')->table('ekspenditur_list')
            ->select([
                'ekspenditur_name', 'id', 'status'
            ])
            ->where('status', '')->orderBy('ekspenditur_name', 'asc')->get();
        return view('livewire.admin.info-ekspenditur', ['data' => $data, 'eks' => $eks]);
    }
}
