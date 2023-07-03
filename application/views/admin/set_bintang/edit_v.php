<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Set Bintang</h1>
        <p class="m-0">Set Bintang</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>set_bintang"></i>Set Bintang</a></li>
          <li class="breadcrumb-item active">Ubah Set Bintang</li>
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
                        <label class="form-label col-sm-3" for="">Rank</label>
                        <div class="col-sm-4">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input class="form-control" value="<?php echo $rank_name; ?>" type="text" id="rank_name" name="rank_name" autocomplete="off" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Harga</label>
                        <div class="col-sm-4">
                            <input class="form-control" value="<?php echo $price; ?>" type="number" id="price" name="price" autocomplete="off" placeholder="Harga Per Bintang">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>set_bintang" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-set-bintang" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
