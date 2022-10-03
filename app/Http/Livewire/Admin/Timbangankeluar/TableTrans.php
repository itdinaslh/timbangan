<?php

namespace App\Http\Livewire\Admin\Timbangankeluar;

use Livewire\Component;
use DB;
use Livewire\WithPagination;
use DateTime;
use Carbon\Carbon;

class TableTrans extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $show = 10;

    public function render()
    {
        $data = DB::connection('bg_db')->table('transaction_log')
        ->select([
            'trans_date_after', 'door_id','truck_id', DB::raw('(weight - weight_after) as net'), 'id'
        ])->where('stat_timbang', 1)
        ->whereBetween('trans_date_after', [DB::raw('DATE_SUB(NOW(), INTERVAL 24 hour)'), Carbon::now()])
        ->when($this->search, function ($builder) {
            $builder->where(function ($builder) {
                $builder->where('trans_date_after', 'like', '%' . $this->search . '%')
                    ->orWhere('door_id', 'like', '%' . $this->search . '%')
                    ->orWhere('truck_id', 'like', '%' . $this->search . '%');
            });
        })->orderBy('id' ,'desc')
        ->paginate($this->show);

        return view('livewire.admin.timbangankeluar.table-trans', ['data' => $data]);
    }
}
