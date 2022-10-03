<form action="/setting/store" method="post">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Setting Timbangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
                Hidden Timbangan Manual
            </div>
            <div class="col-md-1">
                :
            </div>
            <div class="col-md-4">
                <select class="form-control" name="mode_timbangan">
                    <option {{ ( $mode_timbangan->setting_value == 'auto') ? 'selected' : '' }} value="auto">Auto</option>
                    <option {{ ( $mode_timbangan->setting_value == 'manual') ? 'selected' : '' }} value="manual" >Manual</option>
                </select>
            </div>
        </div>
        <hr>
        <div id="showinputmasuk">
            <div class="row">
                <div class="col-md-3"> IP Timbangan Masuk</div>
                <div class="col-md-1">:</div>
                <div class="col-md-4">
                    <input type="text" value="{{ $ipmasuk->setting_value }}" name="ipmasuk" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="text" value="{{ $portmasuk->setting_value }}" name="portmasuk" class="form-control">
                </div>
            </div>
            <div class="row" style="padding-top:15px;">
                <div class="col-md-3"> IP Timbangan Keluar</div>
                <div class="col-md-1">:</div>
                <div class="col-md-4">
                    <input type="text" name="ipkeluar" value="{{ $ipkeluar->setting_value }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="text" name="portkeluar" value="{{ $portkeluar->setting_value }}" class="form-control">
                </div>
            </div>
        </div>   
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
