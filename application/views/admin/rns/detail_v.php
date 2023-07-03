<section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
  </ol>
</section>

<section class="content">
  <input type="hidden" value="<?php echo $this->uri->segment(3) ?>" id="tanggal">
  <input type="hidden" value="<?php echo $this->uri->segment(4) ?>" id="lokasi">
  <div class="row">
    <div class="col-md-6">
      <div class="box mb-3">
        <div class="box-header">
          <div class="row">
            <div class="col-sm-6">
              Rain
            </div>
            <div class="col-sm-6 text-right">
              Tanggal : <?php echo $this->uri->segment(3) ?>              
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="table-rain" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Iterasi</th>
                  <th>Start</th>  
                  <th>Stop</th>  
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box mb-3">
        <div class="box-header">
          <div class="row">
            <div class="col-sm-6">
              Slippery
            </div>
            <div class="col-sm-6 text-right">
              Tanggal : <?php echo $this->uri->segment(3) ?>              
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="table-slippery" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Iterasi</th>
                  <th>Start</th>  
                  <th>Stop</th>  
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-rns" src="<?php echo base_url()?>assets/js/require.js"></script>