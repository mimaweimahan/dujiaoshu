<div class="input-group input-group-sm">
    <select style="width: 100%;" class="grid-column-select" data-reload="<?php echo e($refresh, false); ?>" data-url="<?php echo e($url, false); ?>" data-name="<?php echo e($column, false); ?>">
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($selected = Dcat\Admin\Support\Helper::equal($k, $value)  ? 'selected' : ''); ?>

            <option value="<?php echo e($k, false); ?>" <?php echo e($selected, false); ?>><?php echo e($v, false); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </select>
</div>

<script require="@select2?lang=<?php echo e(config('app.locale') === 'en' ? '' : str_replace('_', '-', config('app.locale')), false); ?>">
    $('.grid-column-select').off('change').select2().on('change', function(){
        var value = $(this).val(),
            name = $(this).data('name'),
            url = $(this).data('url'),
            data = {},
            reload = $(this).data('reload');

        if (name.indexOf('.') === -1) {
            data[name] = value;
        } else {
            name = name.split('.');

            data[name[0]] = {};
            data[name[0]][name[1]] = value;
        }

        Dcat.NP.start();
        $.put({
            url: url,
            data: data,
            success: function (d) {
                Dcat.NP.done();
                if (d.status) {
                    Dcat.success(d.data.message);
                    reload && Dcat.reload();
                } else {
                    Dcat.error(d.data.message);
                }
            }
        });
    });
</script>
<?php /**PATH /www/wwwroot/session.dpdns.org/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/select.blade.php ENDPATH**/ ?>