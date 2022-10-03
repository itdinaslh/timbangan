<form action="/data_user/store" method="post">
    <div class="modal-header bg-primary-500 bg-success-gradient">
        <h4 class="modal-title">
            @if ($data->id != 0)
            Edit Transaksi
            @else
            Tambah Transaksi Baru
            @endif</h4>
        <button type="button" class="btn-close text-red" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body ">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Username </label>
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="text" name="username" class="form-control" required autocomplete="off"
                        value="{{$data->username}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Nama User</label>
                    <input type="text" name="nama" class="form-control" required autocomplete="off"
                        value="{{$data->name}}" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
