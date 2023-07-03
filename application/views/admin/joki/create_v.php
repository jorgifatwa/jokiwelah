<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Joki Baru</h1>
        <p class="m-0">Joki</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>joki"></i>Joki</a></li>
          <li class="breadcrumb-item active">Joki Baru</li>
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
                            <input class="form-control" type="text" id="name" name="name" autocomplete="off" placeholder="Nama Joki">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Nomor Whatsapp</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="nomor_whatsapp" name="nomor_whatsapp" autocomplete="off" placeholder="Nomor Whatsapp">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="form-label col-sm-3">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="form-label col-sm-3">No. Handphone</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control number" maxlength="13" id="phone" placeholder="No.Handphone" name="phone">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3">Alamat</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" name="address" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3">Kata Sandi</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="password"  name="password" placeholder="Kata Sandi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3">Ulangi Kata Sandi</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi Kata Sandi">
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