<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Livewire\WithPagination;


class Struck extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $show = 5;
    
    public function render()
    {
        $data = DB::connection('bg_db')->table('transaction_log')
            ->select([
                'trans_date', 'id', 'trans_date_after', 'door_id','truck_id','weight','weight_after'
            ])->where('id', $this->search)
            // ->when($this->filter, function ($builder) {
            //     $builder->where('status', $this->filter);
            // })
            // ->when($this->search, function ($builder) {
            //     $builder->where(function ($builder) {
            //         $builder->where('id', $this->search);
            //             // ->orWhere('trans_date', 'like', '%' . $this->search . '%')
            //             // ->orWhere('trans_date_after', 'like', '%' . $this->search . '%')
            //             // ->orWhere('door_id', 'like', '%' . $this->search . '%')
            //             // ->orWhere('truck_id', 'like', '%' . $this->search . '%');
            //     });
            // })
            ->orderBy('id' ,'desc')
        ->paginate($this->show);
  
        return view('livewire.admin.struck', ['data' => $data]);
    }
}
