<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_','-',strtolower(app()->getLocale())), false); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo e(isset($page_title) ? $page_title : '', false); ?> | <?php echo e(dujiaoka_config_get('title'), false); ?></title>
    <meta name="keywords" content="<?php echo e($gd_keywords, false); ?>">
    <meta name="description" content="<?php echo e($gd_description, false); ?>">
    <meta property="og:type" content="article">
    <meta property="og:image" content="<?php echo e($picture, false); ?>">
    <meta property="og:title" content="<?php echo e(isset($page_title) ? $page_title : '', false); ?>">
    <meta property="og:description" content="<?php echo e($gd_description, false); ?>">    
    <meta property="og:release_date" content="<?php echo e($updated_at, false); ?>">
    <?php if(\request()->getScheme() == "https"): ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php endif; ?>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/assets/hyper/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="/assets/hyper/css/hyper.css?v=045256" rel="stylesheet" type="text/css">
</head>
<body data-layout="topnav">
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <?php echo $__env->make('hyper.layouts._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="container">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div><!-- content -->
            <?php echo $__env->make('hyper.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div><!-- content-page -->
    </div><!-- wrapper -->
    <?php echo $__env->make('hyper.layouts._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startSection('js'); ?>
    <?php echo $__env->yieldSection(); ?>
</body>
</html><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/layouts/seo.blade.php ENDPATH**/ ?>