<section class="content-header">
    <h1>
        Situasi Air
        <small>Tambah Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>seam"></i>Seam</a></li>
        <li>Situasi Air</li>
        <li class="active">Tambah Baru</li>
    </ol>
</section>
<section class="content">
    <form id="form-create" method="post">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Waktu</label>
                    <div class="col-sm-4">
                        <input required class="form-control" type="text" id="waktu" name="waktu" autocomplete="off" placeholder="Waktu">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Est.Volume</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onClick="App.tambahVolume();"><i class="fa fa-plus"></i> Est.Volume</button>
                            </div>

                            <div class="col-sm-12">
                                <table class="table" id="container-volume">
                                    <thead>
                                        <th>Seam</th>
                                        <th>Dari Blok</th>
                                        <th>Ke Blok</th>
                                        <th>Ketinggian Air (mdpl)</th>
                                        <th>Estimasi Total Air</th>
                                        <th>Estimasi Total Lumpur</th>
                                        <th width="50px">Aksi</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Status Pompa</h4>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onClick="App.tambahPompa();"><i class="fa fa-plus"></i> Status Pompa</button>
                            </div>

                            <div class="col-sm-12">
                                <table class="table" id="container-pompa">
                                    <thead>
                                        <th width="30%">Unit Support</th>
                                        <th>Status Unit(Catatan)</th>
                                        <th width="50px">Aksi</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>situasi_air" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    var seam = <?php echo json_encode($seam); ?>;
    var unit = <?php echo json_encode($unit); ?>;
</script>

<script data-main="<?php echo base_url() ?>assets/js/main/main-situasi-air" src="<?php echo base_url() ?>assets/js/require.js"></script>
