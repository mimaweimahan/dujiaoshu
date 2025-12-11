<?php $__env->startSection('field'); ?>
    <input class="form-control ie-input"/>
<?php $__env->stopSection(); ?>

<script>
<?php $__env->startSection('popover-content'); ?>
    $template.find('input').attr('value', $trigger.data('value'));
<?php $__env->stopSection(); ?>

<?php $__env->startSection('popover-shown'); ?>
    <?php if(! empty($mask)): ?>
    $popover.find('.ie-input').inputmask(<?php echo admin_javascript_json($mask); ?>);
    <?php endif; ?>
<?php $__env->stopSection(); ?>
</script>

<?php echo $__env->make('admin::grid.displayer.editinline.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/editinline/input.blade.php ENDPATH**/ ?>