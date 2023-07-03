<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Blok</h1>
        <p class="m-0">Blok</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>blok"></i>Blok</a></li>
          <li class="breadcrumb-item active">Ubah Blok</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post">
                <input type="hidden" name="selected_pit" id="selected_pit" value="<?php echo $pit_id; ?>">
                <input type="hidden" name="selected_seam" id="selected_seam" value="<?php echo $seam_id; ?>">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Site</label>
                        <div class="col-sm-4">
                            <select name="location_id" id="location_id" class="form-control">
                                <option value="">Pilih Site</option>
                                <?php foreach ($locations as $location) {?>
                                <option <?php if ($location->id == $location_id) {echo "selected";}?> value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
                                <?php }?>
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
                        <label class="form-label col-sm-3" for="">Nama Blok</label>
                        <div class="col-sm-4">
                            <input class="form-control" value="<?php echo $name; ?>" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Blok">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>blok" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-blok" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
