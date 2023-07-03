<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pelayanan Baru</h1>
        <p class="m-0">Pelayanan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>pelayanan"></i>Pelayanan</a></li>
          <li class="breadcrumb-item active">Pelayanan Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nama Pelayanan</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Pelayanan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Proses Pengerjaan</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="proses_pengerjaan" name="proses_pengerjaan" autocomplete="off" placeholder="Proses Pengerjaan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Banner</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="file" id="gambar" name="gambar" autocomplete="off" placeholder="Proses Pengerjaan" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>pelayanan" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-pelayanan" src="<?php echo base_url() ?>assets/js/require.js"></script>