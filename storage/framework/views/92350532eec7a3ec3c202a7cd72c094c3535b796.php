<div class="row">
    <div class="col-md-12"><?php echo $panel; ?></div>

    <?php if($relations->count()): ?>
        <div class="col-md-12">
            <div class="row show-relation-container">
                <?php $__currentLoopData = $relations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-<?php echo e($relation->width ?: 12, false); ?>">
                        <?php echo $relation->render(); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /www/wwwroot/session.dpdns.org/vendor/dcat/laravel-admin/src/../resources/views/show/container.blade.php ENDPATH**/ ?>