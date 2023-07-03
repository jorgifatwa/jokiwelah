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
                    Data Dewatering Pump
                </div>
                <div class="col-sm-6 text-right">
                    <?php if($is_can_create){ ?>
                    <a href="<?php echo base_url()?>dewatering_pump/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Dewatering Pump</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th>Shift</th>
                            <th>Operator</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script>
    var equipment_event = [];
    var units = [];
</script>
<script data-main="<?php echo base_url()?>assets/js/main/main-dewatering-pump" src="<?php echo base_url()?>assets/js/require.js"></script>