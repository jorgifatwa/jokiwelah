<section class="content-header">
    <h1>
        RNS Aktual
        <small>RNS Aktual Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>rns_actual"></i>RNS Aktual</a></li>
        <li class="active">RNS Aktual Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">Tanggal</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo date('d-m-Y') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">Tipe</label>
                            <div class="col-sm-4">
                                <select name="type" id="type" class="form-control">
                                    <option value="">Pilih Tipe</option>
                                    <option value="0">Rain</option>
                                    <option value="1">Slippery</option>
                                    <option value="2">Fog</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">Site</label>
                            <div class="col-sm-4">
                                <select name="location_id" id="location_id" class="form-control">
                                    <option value="">Pilih Site</option>
                                    <?php  
                                        if(!empty($locations)){
                                            foreach ($locations as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">PIT</label>
                            <div class="col-sm-4">
                                <select name="pit_id" id="pit_id" class="form-control">
                                    <option value="">Pilih PIT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">Seam</label>
                            <div class="col-sm-4">
                                <select name="seam_id" id="seam_id" class="form-control">
                                    <option value="">Pilih Seam</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3" for="">Blok</label>
                            <div class="col-sm-4">
                                <select name="blok_id" id="blok_id" class="form-control">
                                    <option value="">Pilih Blok</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Shift</label>
                            <div class="col-sm-4">
                                <select name="shift" id="shift" class="form-control">
                                    <option value="">Pilih Shift</option>
                                    <option value="DS">Day Shift</option>
                                    <option value="NS">Night Shift</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row start d-none">
                            <label class="form-label col-sm-3" for="">Start</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="start" id="start" placeholder="Start">
                            </div>
                        </div>
                        <div class="form-group row stop d-none">
                            <label class="form-label col-sm-3" for="">Stop</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="stop" id="stop" placeholder="Stop">
                            </div>
                        </div>
                        <div class="form-group row rainfall d-none">
                            <label class="form-label col-sm-3" for="">Rainfall</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="rainfall" id="rainfall" placeholder="Rainfall">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="iterasi" id="iterasi">
                        <input type="hidden" name="id" id="id">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>rns_actual" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-rns-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>