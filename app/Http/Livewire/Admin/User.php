<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Models\User as Users;
use Illuminate\Support\Arr;
use Livewire\WithPagination;


class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $show = 5;

    public function render()
    {
        $data = Users::with('roles')
        ->when($this->search, function ($builder) {
            $builder->where(function ($builder) {
                $builder->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        })->orderBy('id' ,'desc')
    ->paginate($this->show);;
        return view('livewire.admin.user', ['data' => $data]);
    }
}
