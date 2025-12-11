<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><?php echo e(__('hyper.error_error'), false); ?></h4>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
		<div class="text-center">
			<div class="text-error mt-4">error</div>
            <h1 class="text-uppercase text-danger mt-3"><?php echo e($content, false); ?></h1>
            <?php if(!$url): ?>
                <a class="btn btn-info mt-3" href="javascript:history.back(-1);"><i class="mdi mdi-reply"></i> <?php echo e(__('hyper.error_back_btn'), false); ?></a>
			<?php else: ?>
                <a class="btn btn-info mt-3" href="<?php echo e($url, false); ?>"><i class="mdi mdi-reply"></i> <?php echo e(__('hyper.error_back_btn'), false); ?></a>
            <?php endif; ?>
        </div> <!-- end /.text-center-->
    </div> <!-- end col-->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/errors/error.blade.php ENDPATH**/ ?>