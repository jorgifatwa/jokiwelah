<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Brand Baru</h1>
        <p class="m-0">Brand</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>unit_brand"></i>Brand</a></li>
          <li class="breadcrumb-item active">Brand Baru</li>
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
            <label class="form-label col-sm-3" for="">Nama Brand Unit</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Brand Unit" required>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>unit_brand" class="btn btn-danger">Batal
              </a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-unit-brand" src="<?php echo base_url() ?>assets/js/require.js"></script>
