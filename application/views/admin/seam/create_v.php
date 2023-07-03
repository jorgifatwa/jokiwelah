<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Seam Baru</h1>
        <p class="m-0">Seam</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>seam"></i>Seam</a></li>
          <li class="breadcrumb-item active">Seam Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Site</label>
                        <div class="col-sm-4">
                            <select name="location_id" id="location_id" class="form-control">
                                <option value="">Pilih Site</option>
                                <?php foreach ($locations as $location) {?>
                                    <option value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
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
                        <label class="form-label col-sm-3" for="">Nama Seam</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Seam">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>seam" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-seam" src="<?php echo base_url() ?>assets/js/require.js"></script>
