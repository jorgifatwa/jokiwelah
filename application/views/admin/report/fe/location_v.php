<section class="content-header">
    <h1>
        Grafik Per Bulan Berdasarkan Lokasi
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></li>
        <li class="active">Grafik Per Bulan Berdasarkan Lokasi</li>    
    </ol>
</section>

<section class="content">
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    Filter Grafik
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <input type="text" name="tahun_search" id="tahun_search" class="form-control yearpicker" value="<?php echo date('Y'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <select name="bulan_search" id="bulan_search" class="form-control">
                            <?php foreach ($bulan as $key => $value) { ?>
                                <option <?php if($key == date('n')){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button type="button" class="btn btn-secondary text-black" id="reset">Reset</button> 
                <button type="button" class="btn btn-primary pull-right" id="btn-filter">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6" id="text-header">
                    Grafik Bulan <?php echo bulan(date("n"))." ".date("Y"); ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="pull-right">
                <div class="col-md-12">
                    <div class="form-inline text-right pt-3">
                        <div class="form-group mb-2">
                            <label  class="control-label mr-2">Filter: </label> 
                            <select id="filter_grafik" class="form-control">
                                <option selected value="day">Harian</option>
                                <option value="week">Mingguan</option>
                                <option value="month">Bulanan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="grafik_location"></div>
        </div>
    </div>
</section>

 <script data-main="<?php echo base_url() ?>assets/js/main/main-hm-location" src="<?php echo base_url() ?>assets/js/require.js"></script>