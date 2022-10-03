<div wire:poll>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="breadcomb-list">
                            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 col- text-center">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-ctn text-center">
                                        <h1>TRUK SEBELUMNYA</h1>
                                        <h1 style='font-weight:normal;padding-top:40px;'>Tanggal : {{$data->tanggal}} KG</h1>
                                        <br>
                                        <h1 style='font-weight:normal;padding-top:10px;'>No Pintu : {{$data->nopintu}}</h1>
                                        <br>
                                        <h1 style='font-weight:normal;padding-top:10px;'> No Lambung : {{$data->nopol}} KG</h1>
                                        <h1 style='font-weight:normal;padding-top:10px;'>Berat : {{$data->berat}} KG</h1><br>"
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="breadcomb-list">
                            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 col- text-center">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-ctn text-center">
                                        <h1>TRUK SEKARANG</h1>
                                        <div id="showdata">
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
