<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agency - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="/<?php echo env('SUBDIR') ?>/public/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php echo env('SUBDIR') ?>/public/plugins/fa/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Fonts -->

    <!-- Theme CSS -->
    <link href="/<?php echo env('SUBDIR') ?>/public/themes/agency/css/agency.css" rel="stylesheet">
    <link href="/<?php echo env('SUBDIR') ?>/public/css/addon.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/<?php echo env('SUBDIR') ?>/public/plugins/vue/vue.1.0.26.min.js"></script>
    <script src="/<?php echo env('SUBDIR') ?>/public/app/js/en.js"></script>
</head>

<body id="page-top" class="index">

<!-- Navigation -->

<!-- Header -->
<div class="clearfix"></div>
<div class="col-lg-8 col-lg-offset-2">
    <?php echo $content ?> <br />
</div>

<footer>

</footer>

<!-- jQuery -->
<script src="/<?php echo env('SUBDIR') ?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="/<?php echo env('SUBDIR') ?>/public/plugins/bootstrap/bootstrap.min.js"></script>


<!-- Theme JavaScript -->
<?php echo \Helpers\Html::instance()->renderPageScripts() ?>

</body>

</html>
