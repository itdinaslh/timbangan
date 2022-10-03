<div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-inline">
                <div class="col-mb-12 row">
                    <label class="col-md-2 col-form-label">Show</label>
                    <div class="col-md-2">
                        <select class="form-control" wire:model='show'>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">15</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <div class="form-inline pull-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="SearchTable" id="SearchTable" wire:model="search" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover m-b-0 table-bordered table-striped text-center" wire:poll>
            <thead style="background-color: transparent;">
                <tr class="">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                         <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                    @endif
                  </td>
                  <td>
                     <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                     <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                      {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                          {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                      {!! Form::close() !!}
                  </td>
                </tr>
               @endforeach
            </tbody>
        </table>
        <div class="col-md-12 mt-3">
            <div class="pull-right">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
