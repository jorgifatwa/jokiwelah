<section class="content-header">
    <h1>
        Data Hours Meter Per Bulan
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></li>
        <li class="active">Data Hours Meter Per Bulan</li>    
    </ol>
</section>

<section class="content">
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    Filter Data 
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <input type="text" name="tahun_search" id="tahun_search" class="form-control yearpicker" value="<?php echo date('Y'); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <select name="bulan_search" id="bulan_search" class="form-control">
                            <?php foreach ($bulan as $key => $value) { ?>
                                <option <?php if($key == date('n')){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Lokasi</label>
                        <select name="location_search" id="location_search" class="form-control">
                            <option value="">Pilih Lokasi</option>
                            <?php if(!empty($location)){
                                foreach ($location as $key => $value) { 
                            ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                            <?php  } } ?>
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
                    Data Bulan <?php echo bulan(date("n"))." ".date("Y"); ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Equipment</th>
                            <th>Model</th>
                            <th>Operator</th>
                            <th>HM Start</th>
                            <th>HM End</th>
                            <th>Duration</th>
                            <th>B/D</th>
                            <th>Stby</th>
                            <th>Remarks</th>
                            <th>Location</th>
                            <th>Week</th>
                        </tr>
                    </thead>
                    <tbody id="hm_monthly">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

 <script data-main="<?php echo base_url() ?>assets/js/main/main-hm-monthly" src="<?php echo base_url() ?>assets/js/require.js"></script>