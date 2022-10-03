<form action="/data_ekspenditur/store" method="post">
    <div class="modal-header bg-primary-500 bg-success-gradient">
        <h4 class="modal-title">
            @if ($data->id != 0)
            Edit Truk
            @else
            Tambah Truk Baru
            @endif</h4>
        <button type="button" class="btn-close text-red" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body ">
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Nama Ekspendetur </label>
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="text" name="ekspenditur_name" class="form-control" autocomplete="off"
                        value="{{$data->ekspenditur_name}}" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="">
                        <option {{ ( $data->status == '') ? 'selected' : '' }} value="">Tidak Terblokir</option>
                        <option {{ ( $data->status == 'izin') ? 'selected' : '' }} value="izin"> Izin Perusahaan Habis</option>
                        <option {{ ( $data->status == 'retri') ? 'selected' : '' }} value="retri">Belum Bayar Retribusi</option>
                        <option {{ ( $data->status == 'none') ? 'selected' : '' }} value="none">Persyaratan Perusahaan Belum Lengkap</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
