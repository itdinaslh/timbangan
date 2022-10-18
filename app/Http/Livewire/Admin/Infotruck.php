<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Livewire\WithPagination;

class Infotruck extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $filter = "";
    public $show = 5;
    
    public function render()
    {
        $data = DB::connection('bg_db')->table('rfid_card as a')
            ->leftJoin('ekspenditur_list', 'a.ekspenditur', '=', 'ekspenditur_list.id')
            ->leftJoin('tipe_truk', 'a.tipe', '=', 'tipe_truk.initial')
            ->select('a.*', 'tipe_truk.initial', 'ekspenditur_list.ekspenditur_name',
                DB::raw('SUBSTRING_INDEX(a.area, ",", 1) as areas'),
                DB::raw('SUBSTRING_INDEX(a.area, ",", -1) as penugasan'))
            ->when($this->filter, function ($builder) {
                $builder->where('a.status', $this->filter);
            })
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('a.rfid_id', 'like', '%' . $this->search . '%')
                        // ->orWhere('areas', 'like', '%' . $this->search . '%')
                        // ->orWhere('penugasan', 'like', '%' . $this->search . '%')
                        ->orWhere('a.door_id', 'like', '%' . $this->search . '%')
                        ->orWhere('a.truck_id', 'like', '%' . $this->search . '%');
                });
            })->orderBy('id' ,'desc')
        ->paginate($this->show);
        return view('livewire.admin.infotruck', ['data' => $data]);
    }
}
