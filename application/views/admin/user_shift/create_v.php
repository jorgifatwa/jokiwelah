<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Shift Kerja Pengguna Baru</h1>
        <p class="m-0">Pengguna</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>user_shift"></i>Shift Kerja Pengguna</a></li>
          <li class="breadcrumb-item active">Shift Kerja Pengguna Baru</li>
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
            <label class="form-label col-sm-3" for="">Shift Kerja</label>
            <div class="col-sm-4">
              <select name="shift_id" id="shift_id" class="form-control">
                <option value="">Pilih Shift Kerja</option>
                <?php foreach ($shift as $s) {?>
                  <option value="<?php echo $s->id ?>"><?php echo $s->name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Nama Pengguna</label>
            <div class="col-sm-4">
              <select name="user_id[]" id="user_id" class="form-control" multiple="multiple">
                <option value="">Pilih Pengguna</option>
                <?php foreach ($user as $u) {?>
                  <option value="<?php echo $u->id ?>"><?php echo $u->first_name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <!-- <div class="form-group row">
            <label class="form-label col-sm-3" for="">Deskripsi</label>
            <div class="col-sm-4">
              <textarea class="form-control" id="description" name="description" autocomplete="off" placeholder="Deskripsi"></textarea>
            </div>
          </div> -->
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>user_shift" class="btn btn-danger">Batal
              </a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-user-shift" src="<?php echo base_url() ?>assets/js/require.js"></script>
