<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Paket Baru</h1>
        <p class="m-0">Paket</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>paket"></i>Paket</a></li>
          <li class="breadcrumb-item active">Paket Baru</li>
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
                                <label class="form-label col-sm-3" for="">Pelayanan</label>
                                <div class="col-sm-4">
                                    <select name="id_pelayanan" id="id_pelayanan" class="form-control">
                                        <option value="">Pilih Pelayanan</option>
                                        <?php foreach ($pelayanans as $pelayanan) {?>
                                        <option value="<?php echo $pelayanan->id ?>"><?php echo $pelayanan->name ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Nama Paket</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" id="name" name="name" autocomplete="off" required placeholder="Nama Paket">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Harga</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="number" id="harga" name="harga" autocomplete="off" required placeholder="Harga">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3" for="">Deskripsi</label>
                                <div class="col-sm-4">
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>paket" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-paket" src="<?php echo base_url() ?>assets/js/require.js"></script>
