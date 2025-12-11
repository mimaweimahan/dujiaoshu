<head>
    <meta charset="utf-8" />
    <title><?php echo e(isset($page_title) ? $page_title : '', false); ?> | <?php echo e(dujiaoka_config_get('title'), false); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="<?php echo e(dujiaoka_config_get('keywords'), false); ?>">
    <meta name="Description" content="<?php echo e(dujiaoka_config_get('description'), false); ?>">
    <?php if(\request()->getScheme() == "https"): ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php endif; ?>
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/assets/hyper/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/hyper/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="/assets/hyper/css/hyper.css?v=045258" rel="stylesheet" type="text/css">
</head>
<?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/layouts/_header.blade.php ENDPATH**/ ?>