<?php 
if ($this->ion_auth->logged_in())
{
  redirect('login/change_page', 'refresh');
}
?>
<!DOCTYPE html>
<html lang="en" style="height:100%;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Jokiwelah - Login</title>
        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url();?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link rel="icon" href="<?php echo base_url() ?>assets/img/logo2.png">
        <link href="<?php echo base_url();?>assets/css/sb-admin.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet">
    </head>
    <body class="h-100">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-md-8 bg-login flex-center h-100">
                    <div class="greeting-content">
                        <img class="logo-login" src="<?php echo base_url();?>assets/img/logo2.png">
                        <h5>Selamat Datang di</h5>
                        <h3>Jokiwelah <br>Group</h3>
                        <p>
                            Portal Informasi Joki dalam rangka laporan yang akurat dan ter-update
                        </p>
                    </div>
                </div>
                <div class="col-md-4 h-100 flex-center bg-soft">
                    <div class="login-form">
                        <h3>Login</h3>
                        <p>Silakan masuk dengan menggunakan akun Anda</p>
                        <form action="<?php echo base_url();?>auth/login" method="post" id="form-login">
                            <?php if(!empty($this->session->flashdata('message_error'))){?>
                            <div class="alert alert-danger">
                                <?php   
                                    print_r($this->session->flashdata('message_error'));
                                    ?>
                            </div>
                            <?php }?>
                            <div class="form-group">
                                <label for="inputEmail">Username</label>
                                <input type="text" id="inputEmail" class="form-control" placeholder="Username" required="required" autofocus="autofocus" name="username">
                            </div>
                            <div class="form-group relative mb-5">
                                <label for="inputPassword">Password</label>
                                <div class="input-icon">
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="password">
                                    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                </div>
                            </div>
                            <button class="btn btn-darkblue btn-block"  id="btn-login">Login</button>
                        </form>
                        <!-- <a class="text-darkblue text-center mt-3 small" href="<?php echo base_url()?>auth/forgot_password">Forgot Password?</a> -->
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
        <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <!-- Core plugin JavaScript-->
        <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
        <script data-main="<?php echo base_url()?>assets/js/main/main-login" src="<?php echo base_url()?>assets/js/require.js"></script>
        <input type="hidden" id="base_url" value="<?php echo base_url();?>">
    </body>
</html>