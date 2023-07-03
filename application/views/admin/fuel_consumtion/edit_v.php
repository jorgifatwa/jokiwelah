<section class="content-header">
    <h1>
        Fuel Consumtion
        <small>Tambah Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>location"></i>Fuel Consumtion</a></li>
        <li class="active">Tambah Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $fuel->id; ?>">
            <input type="hidden" name="selected_pit" id="selected_pit" value="<?php echo $fuel->pit_id; ?>">
            <input type="hidden" name="selected_pic" id="selected_pic" value="<?php echo $fuel->pic_id; ?>">
            <input type="hidden" name="selected_unit" id="selected_unit" value="<?php echo $fuel->unit_id; ?>">
            <input type="hidden" name="selected_lokasi_pengisian" id="selected_lokasi_pengisian" value="<?php echo $fuel->lokasi_pengisian; ?>">
            <div class="box-body"> 
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Site</label>
                    <div class="col-sm-4">
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Pilih Site</option>
                            <?php foreach ($locations as $location) { ?>
                                <option 
                                <?php if(!empty($location->id == $fuel->location_id)){ echo "selected"; } ?>
                                value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
                            <?php } ?>
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
                    <label class="form-label col-sm-3" for="">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" autocomplete="off" placeholder="Tanggal" value="<?php if(!empty($fuel->tangal)){ echo date("d-m-Y", strtotime($fuel->tanggal)); } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Hour Meter</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control number-nospace" id="hour_meter" name="hour_meter" autocomplete="off" placeholder="Hour Meter" value="<?php echo $fuel->hm; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">PIC</label>
                    <div class="col-sm-4">
                        <select name="pic_id" id="pic_id" class="form-control">
                            <option value="">Pilih PIC</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Unit</label>
                    <div class="col-sm-4">
                        <select name="unit_id" id="unit_id" class="form-control">
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3">Shift</label>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input shift" type="radio" name="shift" id="ds" value="DS" <?php if($fuel->shift == "DS"){ echo "checked"; } ?>>
                                    <label class="form-check-label" for="inlineRadio1">Day Shift</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input shift" type="radio" name="shift" id="ns" value="NS" <?php if($fuel->shift == "NS"){ echo "checked"; } ?>>
                                    <label class="form-check-label" for="inlineRadio1">Night Shift</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Lokasi Pengisian</label>
                    <div class="col-sm-4">
                        <select name="lokasi_pengisian_id" id="lokasi_pengisian_id" class="form-control">
                            <option value="">Pilih Lokasi Pengisian</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">KM Pengisian</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control number" id="km_pengisian" name="km_pengisian" autocomplete="off" placeholder="KM Pengisian" value="<?php if(!empty($fuel->km_pengisian)){ echo floatVal($fuel->km_pengisian); }; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">HM Pengisian</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control number" id="hm_pengisian" name="hm_pengisian" autocomplete="off" placeholder="HM Pengisian" value="<?php if(!empty($fuel->hm_pengisian)){ echo floatVal($fuel->hm_pengisian); }; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">QTY In</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control number-nospace" id="qty_in" name="qty_in" autocomplete="off" placeholder="QTY In" value="<?php echo intVal($fuel->qty_in); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">QTY Out</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control number-nospace" id="qty_out" name="qty_out" autocomplete="off" placeholder="QTY Out" value="<?php echo intVal($fuel->qty_out); ?>">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>fuel_consumtion" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-fuel-consumtion" src="<?php echo base_url() ?>assets/js/require.js"></script>
