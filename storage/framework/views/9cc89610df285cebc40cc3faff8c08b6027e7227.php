<div class="input-group input-group-sm">
    <div class="input-group-prepend">
        <span class="input-group-text bg-white text-capitalize"><b><?php echo $label; ?></b></span>
    </div>

    <select class="form-control <?php echo e($class, false); ?>" name="<?php echo e($name, false); ?>" data-value="<?php echo e($value, false); ?>" style="width: 100%;">
        <option value=""></option>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($select, false); ?>" <?php echo e(Dcat\Admin\Support\Helper::equal($select, $value) ?'selected':'', false); ?>><?php echo e($option, false); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php echo $__env->make('admin::scripts.select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script require="@select2?lang=<?php echo e(config('app.locale') === 'en' ? '' : str_replace('_', '-', config('app.locale')), false); ?>">
    var configs = <?php echo admin_javascript_json($configs); ?>;

    <?php echo $__env->yieldContent('admin.select-ajax'); ?>

    <?php if(isset($remote)): ?>
    $.ajax(<?php echo admin_javascript_json($remote['ajaxOptions']); ?>).done(function(data) {
        $("<?php echo e($selector, false); ?>").select2($.extend(<?php echo admin_javascript_json($configs); ?>, {
            data: data,
        })).val(<?php echo json_encode($remote['values']); ?>).trigger("change");
    });
    <?php else: ?>
    $("<?php echo $selector; ?>").select2(configs);
    <?php endif; ?>
</script>
<?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/vendor/dcat/laravel-admin/src/../resources/views/filter/select.blade.php ENDPATH**/ ?>