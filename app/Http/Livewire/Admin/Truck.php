<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Livewire\WithPagination;


class Truck extends Component
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
            ->select('a.*', 'tipe_truk.initial', 'ekspenditur_list.ekspenditur_name')
            ->when($this->filter, function ($builder) {
                $builder->where('a.status', $this->filter);
            })
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('rfid_id', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        ->orWhere('tipe', 'like', '%' . $this->search . '%')
                        ->orWhere('door_id', 'like', '%' . $this->search . '%')
                        ->orWhere('truck_id', 'like', '%' . $this->search . '%');
                });
            })->orderBy('id' ,'desc')
        ->paginate($this->show);
  
        return view('livewire.admin.truck', ['data' => $data]);
    }
}
