<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Model</h1>
        <p class="m-0">Model</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>unit_model"></i>Model</a></li>
          <li class="breadcrumb-item active">Ubah Model</li>
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
            <label class="form-label col-sm-3" for="">Brand Unit</label>
            <div class="col-sm-4">
              <select name="brand_id" id="brand_id" class="form-control">
                <option value="">Pilih Brand</option>
                <?php foreach ($brands as $b) {?>
                  <option value="<?php echo $b->id ?>" <?php if ($b->id == $brand_id) {echo 'selected';}?>><?php echo $b->name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Kategori Unit</label>
            <div class="col-sm-4">
              <select name="unit_category_id" id="unit_category_id" class="form-control">
                <option value="">Pilih Kategori</option>
                <?php foreach ($unit_category as $key => $uc) {?>
                  <option value="<?php echo $uc->id ?>" <?php if ($uc->id == $unit_category_id) {echo 'selected';}?>><?php echo $uc->name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Nama Model Unit</label>
            <div class="col-sm-4">
              <input class="form-control" value="<?php echo $name; ?>" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Model Unit">
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>unit_model" class="btn btn-danger">Batal
              </a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-unit-model" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
