<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EB | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
 
    <link rel="stylesheet" href="<?= base_url(); ?>assets/animate.css">
    <style type="text/css">
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
            font-weight: 400;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .login-logo,
        .register-logo {
         font-size:35px;
         text-align:center;
         margin-bottom:25px;
         font-weight:300
        }
        .login-logo a,
        .register-logo a {
         color:#444;
        }
        .login-page,
        .register-page {
         background: #18a689 ;
        }
        .login-box,
        .register-box {
         width:360px;
         margin:7% auto
        }
        @media (max-width:768px) {
         .login-box,
         .register-box {
          width:90%;
          margin-top:20px
         }
        }
        .login-box-body,
        .register-box-body {
         background:#fff;
         padding:20px;
         border-top:0;
         color:#666;
        }
        .login-box-body .form-control-feedback,
        .register-box-body .form-control-feedback {
         color:#777
        }
        .login-box-msg,
        .register-box-msg {
         margin:0;
         text-align:center;
         padding:0 20px 20px 20px
        }

        .login-page {
            background: #003eaa;
            background: linear-gradient(148deg,#c7216a 7%,#fda41e 100%);
            height: 28px;
            color: #fff;
            text-align: center;
            font-size: 1.25em;
            padding: 3px 0;
        }

        .login-box-body, .register-box-body {
            background: transparent; 
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
 
 
    <!-- /.login-logo -->
    <?php if ($this->session->flashdata('msg')) {
        echo "<div class='alert alert-danger'>" . $this->session->flashdata('msg') . "</div>";

    } else {

    } ?>
    <div class="login-box-body">
        <div class="login-logo animated fadeInDown" data-animation="fadeInDown">
            <a href="http://multi-inventory.codeslab.net/"><b>EBATECH </b>Inventory </a>
        </div>
        <div class="login-box-body  animated fadeInUp" data-animation="fadeUp">
            <?php $attributes = array('class' => 'form-group', 'id' => 'myform', 'method' => 'post');
                echo form_open('users/loginauthen', $attributes); ?>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="u_email" placeholder="Username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="u_password" autocomplete="off" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            <?php form_close(); ?>
        </div>

        <!-- <a href="<?= base_url('users/register') ?>" class="text-center">Register a new membership</a> -->
        <hr>
        <p><strong>Username:</strong> admin | <strong>Password:</strong> 123admin</p>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>