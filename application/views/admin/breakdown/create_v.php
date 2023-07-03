<section class="content-header">
    <h1>
        Breakdown
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Breakdown</a></li>
        <li class="active">Add New</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <form id="form" method="post">
            <div class="row" id="isi">
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Tanggal BD</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tanggal_bd" id="tanggal_bd">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Lokasi</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="location_id" id="location_id">
                                    <option selected hidden disabled>Pilih Lokasi</option>
                                    <?php foreach($locations as $location){?>
                                    <option value="<?php echo $location->id;?>"><?php echo $location->name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Loading Unit</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="loading_unit_id" id="loading_unit_id">
                                    <option selected hidden disabled>Pilih Loading Unit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Job Status</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="job_status_id" id="job_status_id">
                                    <option selected hidden disabled>Pilih Job Status</option>
                                    <?php foreach($job_status as $job){?>
                                    <option value="<?php echo $job->id;?>"><?php echo $job->name."-".$job->description;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3">Deskripsi Masalah</label>
                            <div class="col-sm-4">
                                <textarea name="trouble_description" id="trouble_description" class="form-control" cols="30" rows="3" placeholder="Masukkan Deskripsi Masalah"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>breakdown" class="btn btn-secondary text-black">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Table -->
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-breakdown" src="<?php echo base_url()?>assets/js/require.js"></script>
<!-- /.content -->