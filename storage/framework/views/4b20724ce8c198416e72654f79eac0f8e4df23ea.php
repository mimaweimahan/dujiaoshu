<div class="<?php echo e($viewClass['form-group'], false); ?>" >

    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <input type="hidden" name="<?php echo e($name, false); ?>">

        <?php echo $radio; ?>


        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>

<?php if(! empty($loads)): ?>
<script once>
    var selector = '<?php echo $selector; ?>',
        fields = '<?php echo $loads['fields']; ?>'.split('^'),
        urls = '<?php echo $loads['urls']; ?>'.split('^');

    $(document).off('change', selector);
    $(document).on('change', selector, function () {
        var values = this.value;

        Dcat.helpers.loadFields(this, {
            group: '.fields-group',
            urls: urls,
            fields: fields,
            textField: "<?php echo e($loads['textField'], false); ?>",
            idField: "<?php echo e($loads['idField'], false); ?>",
            values: values,
        });
    });
    $(selector+':checked').trigger('change')
</script>
<?php endif; ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/vendor/dcat/laravel-admin/src/../resources/views/form/radio.blade.php ENDPATH**/ ?>