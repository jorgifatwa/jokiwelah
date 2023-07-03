<section class="content-header">
    <h1>
    Fuel Plan
        <small>Fuel Plan Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>fuel_plan"></i>Fuel Plan</a></li>
        <li class="active">Fuel Plan Baru</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="row">
            <div class="col-md-12 border-responsive">  
                <div class="box-body">
                    <form id="form-create" name="form">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Lokasi</label>
                                <select class="js-example-basic location_id" name="location_id" id="location_id">
                                    <option value="">Pilih Lokasi</option>
                                    <?php if(!empty($locations)){
                                        foreach ($locations as $key => $value) { 
                                    ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Unit</label>
                                <select class="js-example-basic unit" name="unit" id="unit">
                                    <option value="">Pilih Unit</option>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label">Bulan</label>
                                <select class="form-control bulan_input" name="bulan_input" id="bulan_input">
                                    <option value="">Pilih Bulan</option>
                                    <?php if(!empty($bulan)){ 
                                        foreach ($bulan as $key => $value) {
                                    ?>
                                        <option <?php if($key == date("n")){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Tahun</label>
                                <input type="text" class="form-control tahun_input" name="tahun_input" id="tahun_input" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Nilai</label>
                                <div class="input-group">
                                    <input type="text" class="form-control nilai_input" name="nilai_input" id="nilai_input" placeholder="Masukan Nilai" autocomplete="off">
                                    <span class="input-group-addon" id="basic-addon2">Liter</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:1%">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Plan</button> 
                            </div>
                        </div>
                    </form>
                </div>     
                 
            </div>      
            <div class="col-md-12">  
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div> 
        </div>
        <div class="box-footer">    
            <a href="<?php echo base_url() ?>plan"><button class="btn btn-light text-black">Kembali</button>  </a>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-fuel-plan" src="<?php echo base_url()?>assets/js/require.js"></script>