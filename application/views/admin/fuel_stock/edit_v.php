<section class="content-header">
    <h1>
        Fuel Stock
        <small>Fuel Stock Ubah</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>location"></i>Fuel Stock</a></li>
        <li class="active">Fuel Stock Ubah</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $stock->id; ?>">
            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Site</label>
                    <div class="col-sm-4">
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Pilih Site</option>
                            <?php foreach ($locations as $location) { ?>
                                <option 
                                <?php if($location->id == $stock->location_id){ echo "selected"; } ?>
                                value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Waktu</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="waktu" name="waktu" autocomplete="off" placeholder="Waktu" value="<?php echo date("d-m-Y", strtotime($stock->waktu)); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Nilai</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control number" id="nilai" name="nilai" autocomplete="off" placeholder="Nilai" value="<?php echo floatVal($stock->nilai); ?>">
                            <span class="input-group-addon" id="basic-addon2">Liter</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>fuel_stock" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-fuel-stock" src="<?php echo base_url() ?>assets/js/require.js"></script>
