<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Joki</h1>
        <p class="m-0">Joki</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>joki"></i>Joki</a></li>
          <li class="breadcrumb-item active">Ubah Joki</li>
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
                        <label class="form-label col-sm-3" for="">Nama Joki</label>
                        <div class="col-sm-4">
                            <input class="form-control" value="<?php echo $name; ?>" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Joki">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nomor Whatsapp</label>
                        <div class="col-sm-4">
                            <input class="form-control" value="<?php echo $nomor_whatsapp; ?>" type="text" id="nomor_whatsapp" name="nomor_whatsapp" autocomplete="off" placeholder="Nomor Whatsapp">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>joki" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-joki" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
