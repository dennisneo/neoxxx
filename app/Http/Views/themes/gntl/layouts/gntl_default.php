<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Native English Online </title>

    <?php echo \Helpers\Html::instance()->renderStyle( '/public/plugins/bootstrap/bootstrap.min.css' ); ?>
    <!-- Font Awesome -->
    <?php echo \Helpers\Html::instance()->renderStyle( '/public/plugins/fa/font-awesome.min.css' ); ?>
    <!-- Custom Theme Style -->
    <?php echo \Helpers\Html::instance()->renderStyle( '/public/themes/gntl/css/custom.min.css' ); ?>
    <?php echo \Helpers\Html::instance()->renderStyle( '/public/css/addon.css' ); ?>
    <?php echo \Helpers\Html::instance()->renderPageStyles() ?>
    <!--- start of JS ------->
    <?php echo \Helpers\Html::instance()->renderScript( '/public/plugins/vue/vue.1.0.26.min.js' ); ?>
    <?php echo \Helpers\Html::instance()->renderScript( '/public/plugins/jquery/jquery.min.js' ); ?>
    <?php echo \Helpers\Html::instance()->renderScript( '/public/plugins/bootstrap/bootstrap.min.js' ); ?>
    <?php echo \Helpers\Html::instance()->renderScript( '/public/app/js/en.js' ); ?>

    <!--
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    -->
    <style>
        h2,h3,h4{
            color:black
        }
    </style>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col" >
            <div class="left_col scroll-view" style="background-color:<?php echo isset( $background_color ) ? $background_color : '' ?>">
                <div class="navbar nav_title" style="border: 0;padding:12px;height:90px">
                    <a href="<?php echo Url('') ?>" class="site_title">
                        <img src="<?php echo Url( 'public/images/neo-logo-light.png' ); ?>" style="height:48px" />
                    </a>
                </div>

                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="<?php echo \App\Models\Users\UserEntity::me()->profilePhotoUrl() ?>" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo \App\Models\Users\UserEntity::me()->displayName() ?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <?php echo \App\Http\Controllers\Partials\SideMenuController::displaySidebar( \App\Models\Users\UserEntity::me() ) ?>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a href="<?php echo Url('logout') ?>"><i class="fa fa-power-off"></i> Logout</a>

                    <!--
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>

                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                    -->
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>
    <!-- top navigation -->
    <div class="top_nav">
        <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="" alt=""> <?php echo \App\Models\Users\UserEntity::me()->displayName( 'short' ) ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo url('profile') ?>"> Profile</a></li>
                        <li><a href="<?php echo url('faq') ?>"> <i class="fa fa-question-circle-o"></i> Help</a></li>
                        <li><a href="<?php echo url('logout') ?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-globe fa-2x"></i>
                        <span class="badge bg-red">6</span>
                    </a>

                </li>
            </ul>
        </nav>
    </div>
    </div>
    <!-- /top navigation -->

    <!-- page content -->
    <!--<div class="right_col" role="main" style=" min-height:92vh; ">-->
    <div class="right_col" role="main" style="min-height:96vh;">
        <?php echo $content ?>
    </div>
    <!-- /page content -->

<!-- footer content -->
<footer>
    <div class="pull-right">
        &copy <?php echo date('Y'); ?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- Custom Theme Scripts -->
<!--<script src="../build/js/custom.min.js"></script>-->

<?php echo \Helpers\Html::instance()->renderPageScripts(); ?>

</body>
<script>
    $('#menu_toggle').on('click', function() {
        if ($('body').hasClass('nav-md')) {
            $('#sidebar-menu').find('li.active ul').hide();
            $('#sidebar-menu').find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $('#sidebar-menu').find('li.active-sm ul').show();
            $('#sidebar-menu').find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $('body').toggleClass('nav-md nav-sm');

        //setContentHeight();
    });
</script>
</html>
