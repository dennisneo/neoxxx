<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- Bootstrap -->
    <link href="/en/public/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<link href="/en/public/plugins/fa/css/font-awesome.min.css" rel="stylesheet">-->
    <!-- Custom Theme Style -->
    <link href="/en/public/themes/gntl/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <div style="background-color: #333333">
        <div style="padding:16px">
            <img src="http://localhost/en/public/images/neo-logo-light.png" class="img-responsive" style="height:64px;"/>
        </div>
    </div>
    <div class="login_wrapper">


        <div class="animate form login_form">
            <section class="login_content">
                <?php if( isset( $error )){ ?>
                <div class="alert alert-danger" style="font-family: helvetica, sans-serif;">
                    <?php echo $error ?>
                </div>
                <?php } ?>
                <form method="post" action="<?php echo Url('login') ?>">
                    <h1>Login</h1>
                    <div>
                        <input type="text" name="username" class="form-control" placeholder="Email / Username" required />
                    </div>
                    <div>
                        <input type="password" name="pwd" class="form-control" placeholder="Password" required />
                    </div>
                    <div>
                        <button class="btn btn-default submit"> Log in</button>
                        <a class="reset_pass" href="#">Lost your password?</a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">


                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> </h1>
                            <p>©<?php echo date('Y') ?> All Rights Reserved. Privacy and Terms</p>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </section>
        </div>
        
    </div>
</div>
</body>
</html>