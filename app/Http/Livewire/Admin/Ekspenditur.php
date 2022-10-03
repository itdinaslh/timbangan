<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use DB;
use Livewire\WithPagination;

class Ekspenditur extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $filter = "";
    public $show = 5;
    public function render()
    {
        $data = DB::connection('bg_db')->table('ekspenditur_list')
            ->select([
                'ekspenditur_name', 'id', 'status'
            ])
            ->when($this->filter, function ($builder) {
                $builder->where('status', $this->filter);
            })
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('ekspenditur_name', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })->orderBy('id' ,'desc')
        ->paginate($this->show);
        return view('livewire.admin.ekspenditur', ['data' => $data]);
    }
}
