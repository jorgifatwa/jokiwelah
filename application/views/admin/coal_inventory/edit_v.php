<section class="content-header">
    <h1>
        Coal Inventory
        <small>Ubah Data</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>location"></i>Coal Inventory</a></li>
        <li class="active">Ubah Data</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $coal_inventory->id; ?>">
            <input type="hidden" name="selected_pit" id="selected_pit" value="<?php echo $coal_inventory->pit_id; ?>">
            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Site</label>
                    <div class="col-sm-4">
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Pilih Site</option>
                            <?php foreach ($locations as $location) { ?>
                                <option 
                                <?php if($coal_inventory->location_id == $location->id){ echo "selected"; } ?>
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
                        <input type="text" class="form-control" id="tanggal" name="tanggal" autocomplete="off" placeholder="Tanggal" value="<?php echo date("d-m-Y", strtotime($coal_inventory->tanggal)); ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Tonase</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control number" name="tonase" id="tonase" placeholder="Tonase" value="<?php echo floatVal($coal_inventory->tonase); ?>">
                            <span class="input-group-addon" id="basic-addon2">Mt</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>coal_inventory" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-inventory" src="<?php echo base_url() ?>assets/js/require.js"></script>
