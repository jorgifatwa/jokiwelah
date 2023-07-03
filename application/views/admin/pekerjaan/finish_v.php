<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Selesaikan Pekerjaan</h1>
        <p class="m-0">Pekerjaan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>pekerjaan"></i>Pekerjaan</a></li>
          <li class="breadcrumb-item active">Selesaikan Pekerjaan</li>
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
                      <label class="form-label col-sm-3" for="">Upload Bukti Pekerjaan</label>
                      <div class="col-sm-4">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <input type="file" id="bukti_pekerjaan" name="bukti_pekerjaan[]" multiple required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Keterangan</label>
                      <div class="col-sm-4">
                        <textarea name="keterangan" id="keterangan" cols="30" rows="7" class="form-control" placeholder="Keterangan"></textarea>
                      </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>pekerjaan" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-pekerjaan" src="<?php echo base_url() ?>assets/js/require.js"></script>