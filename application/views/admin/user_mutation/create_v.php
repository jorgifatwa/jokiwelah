<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Mutasi Pengguna Baru</h1>
        <p class="m-0">Pengguna</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>user_mutation"></i>Mutasi Pengguna</a></li>
          <li class="breadcrumb-item active">Mutasi Pengguna Baru</li>
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
            <label class="form-label col-sm-3" for="">Nama Pengguna</label>
            <div class="col-sm-4">
              <select name="user_id" id="user_id" class="form-control">
                <option value="">Pilih Pengguna</option>
                <?php foreach ($data_user as $key => $u) {?>
                  <option value="<?php echo $u->id ?>"><?php echo $u->nik . " - " . $u->first_name . " (" . $u->role_name . ")" ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Mutasi Dari</label>
            <div class="col-sm-4">
              <select name="from_location" id="from_location" class="form-control" readonly="">
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Mutasi Ke</label>
            <div class="col-sm-4">
              <select name="to_location" id="to_location" class="form-control">
                <option value="">Pilih Lokasi Mutasi</option>
                <?php foreach ($to_locations as $key => $t) {?>
                  <option value="<?php echo $t->id ?>"><?php echo $t->name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>user_mutation" class="btn btn-danger">Batal
              </a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-user-mutation" src="<?php echo base_url() ?>assets/js/require.js"></script>
