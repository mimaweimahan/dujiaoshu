<head>
    <meta charset="utf-8" />
    <?php if(!empty($seo) && $seo['title']): ?>
    <title><?php echo e(isset($seo['title']) ? $seo['title'] : '', false); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="<?php echo e(isset($seo['keywords']) ? $seo['keywords'] : '', false); ?>">
    <meta name="Description" content="<?php echo e(isset($seo['description']) ? $seo['description'] : '', false); ?>">
    <?php else: ?>
    <title><?php echo e(dujiaoka_config_get('title'), false); ?></title>
    <?php endif; ?>

    <?php if(\request()->getScheme() == "https"): ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php endif; ?>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/assets/hyper/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="/assets/hyper/css/hyper.css?v=045256" rel="stylesheet" type="text/css">
</head>
<?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/layouts/_article_header.blade.php ENDPATH**/ ?>