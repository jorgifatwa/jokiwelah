<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Shift Kerja Pengguna</h1>
        <p class="m-0">Pengguna</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>user_shift"></i>Shift Kerja Pengguna</a></li>
          <li class="breadcrumb-item active">Ubah Shift Kerja Pengguna</li>
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
            <label class="form-label col-sm-3" for="">Shift</label>
            <div class="col-sm-4">
              <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
              <select name="shift_id" id="shift_id" class="form-control">
                <option value="">Pilih Shift</option>
                <?php foreach ($shift as $s) {?>
                  <option value="<?php echo $s->id ?>" <?php if ($shift_id == $s->id) {echo "selected";}?>><?php echo $s->name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">User</label>
            <div class="col-sm-4">
              <select name="user_id[]" id="user_id" class="js-example-basic form-control" multiple="multiple">
                <?php foreach ($user as $u) {?>
                  <option value="<?php echo $u->id ?>" <?php if (in_array($u->id, $user_id)) {echo "selected";}?>><?php echo $u->first_name ?></option>
                <?php }?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>user_shift" class="btn btn-secondary text-black">Batal
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


</section>
