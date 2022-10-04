<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Permission as Permisiions;
use Livewire\WithPagination;

class Permision extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $show = 5;

    public function render()
    {
        $data = Permisiions::when($this->search, function ($builder) {
            $builder->where(function ($builder) {
                $builder->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('guard_name', 'like', '%' . $this->search . '%');
            });
        })->orderBy('id' ,'desc')
    ->paginate($this->show);
        return view('livewire.admin.permision', ['data' => $data]);
    }
}
