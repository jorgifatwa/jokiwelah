<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Disposal Baru</h1>
        <p class="m-0">Disposal</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>disposal"></i>Disposal</a></li>
          <li class="breadcrumb-item active">Disposal Baru</li>
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
                    <div class="row">
                        <div class="col-md-12">
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
                                <label class="form-label col-sm-3" for="">Produksi</label>
                                <div class="col-sm-4">
                                    <select name="production" id="production" class="form-control">
                                        <option value="">Pilih Produksi</option>
                                        <option value="1">OB Production</option>
                                        <option value="2">Coal Production</option>
                                        <option value="3">Fuel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Nama Disposal</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Disposal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>disposal" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-disposal" src="<?php echo base_url() ?>assets/js/require.js"></script>
