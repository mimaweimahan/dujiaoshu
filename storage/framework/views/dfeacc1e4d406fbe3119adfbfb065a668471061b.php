<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_','-',strtolower(app()->getLocale())), false); ?>">
<?php echo $__env->make('hyper.layouts._article_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
</html><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/layouts/article.blade.php ENDPATH**/ ?>