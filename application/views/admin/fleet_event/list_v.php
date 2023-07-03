<section class="content-header">
    <h1>
        <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
    </ol>
</section>
<section class="content">
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    Filter Fleet Event
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="">Loading Unit</label>
                        <select name="loading_unit_id" id="loading_unit_id" class="form-control">
                            <option value="">Pilih Loading Unit</option>
                            <?php foreach ($loading_unit as $key => $loading) { ?>
                            <option value="<?php echo $loading->id;?>"><?php echo $loading->kode." - ".$loading->brand_name." - ".$loading->unit_model_name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="fleet_status_id" id="fleet_status_id" class="form-control">
                            <option value="">Pilih Status</option>
                            <?php foreach($fleet_status as $status){?>
                            <option value="<?php echo $status->id;?>"><?php echo $status->name;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Alasan</label>
                        <select name="fleet_reason_id" id="fleet_reason_id" class="form-control">
                            <option value="">Pilih Alasan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Tanggal Mulai</label>
                        <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Tanggal Akhir</label>
                        <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
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
                <div class="col-sm-6">
                    Data Fleet Event
                </div>
                <div class="col-sm-6 text-right">
                    <?php if($is_can_create){ ?>
                    <a href="<?php echo base_url()?>fleet_event/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Fleet Event</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Kategori</th>
                            <th>Equipment</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-fleet-event" src="<?php echo base_url()?>assets/js/require.js"></script>