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
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span><?php echo env('SITE_ABBR') ?></span></a>
                </div>

                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>John Doe</h2>
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

        </nav>
    </div>
    </div>
    <!-- /top navigation -->

    <!-- page content -->
    <div class="right_col" role="main" style="min-height:92vh;">
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

</html>
