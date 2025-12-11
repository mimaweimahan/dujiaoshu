<span class="ie-wrap">
    <a
        href="javascript:void(0);"
        class="<?php echo e($class, false); ?>"
        data-editinline="popover"
        data-temp="grid-editinline-<?php echo e($type, false); ?>-<?php echo e($name, false); ?>"
        data-value="<?php echo e($value, false); ?>"
        data-original="<?php echo e($value, false); ?>"
        data-key="<?php echo e($key, false); ?>"
        data-name="<?php echo e($name, false); ?>"
        data-url="<?php echo $url; ?>"
        data-refresh="<?php echo e($refresh, false); ?>"
    >
        <span class="ie-display">
            <?php echo e($display, false); ?>

            <?php if(! $display): ?>
                <i class="feather icon-edit-2"></i>
            <?php endif; ?>
        </span>
    </a>
</span>

<template>
    <template id="grid-editinline-<?php echo e($type, false); ?>-<?php echo e($name, false); ?>">
        <div class="ie-content ie-content-<?php echo e($name, false); ?>" data-type="<?php echo e($type, false); ?>">
            <div class="ie-container">
                <?php echo $__env->yieldContent('field'); ?>
                <div class="error"></div>
            </div>
            <div class="ie-action">
                <button class="btn btn-primary btn-sm ie-submit"><?php echo e(__('admin.submit'), false); ?></button>
                <button class="btn btn-white btn-sm ie-cancel"><?php echo e(__('admin.cancel'), false); ?></button>
            </div>
        </div>
    </template>
</template>

<style>
    .ie-action button {
        margin: 10px 0 10px 10px;
        float: right;
    }
    [data-editinline="popover"] {
        border-bottom:dashed 1px <?php echo admin_color()->primary(); ?>;
        color: <?php echo admin_color()->primary(); ?>;
        display: inline-block;
    }
    body.dark-mode [data-editinline="popover"] {
        color: <?php echo admin_color()->primary(); ?>;
        border-color: <?php echo admin_color()->primary(); ?>;
    }
</style>

<script>
    function hide() {
        $('[data-editinline="popover"]').popover('hide');
    }

    $('.<?php echo e($class, false); ?>').popover({
        html: true,
        container: 'body',
        trigger: 'manual',
        sanitize: false,
        placement: function (context, source) {
            var position = $(source).position();
            if (position.left < 100) return "right";
            if (position.top < 110) return "bottom";
            if ($(window).height() - $(source).offset().top < 370) {
                return 'top';
            }
            return "bottom";
        },
        content: function () {
            var $trigger = $(this);
            var $template = $($('template#'+$(this).data('temp')).html());

            <?php echo $__env->yieldContent('popover-content'); ?>

            return $template.prop("outerHTML");
        }
    }).on('shown.bs.popover', function (e) {

        var $popover = $($(this).data('bs.popover').tip).find('.ie-content');
        var $display = $(this).parents('.ie-wrap').find('.ie-display');
        var $trigger = $(this);

        $popover.data('display', $display);
        $popover.data('trigger', $trigger);

        <?php echo $__env->yieldContent('popover-shown'); ?>

    }).click(function () {
        hide();
        $(this).popover('toggle');
    });
</script>

<script>
    function hide() {
        $('[data-editinline="popover"]').popover('hide');
    }

    $(document).off('click', '.ie-content .ie-cancel').on('click', '.ie-content .ie-cancel', hide)

    $(document).off('click', '.ie-content .ie-submit').on('click', '.ie-content .ie-submit', function () {
        var $popover = $(this).closest('.ie-content'),
            $trigger = $popover.data('trigger'),
            name = $trigger.data('name'),
            original = $trigger.data('original'),
            refresh = $trigger.data('refresh'),
            val,
            label;

        switch($popover.data('type')) {
            case 'input':
            case 'textarea':
                val = $popover.find('.ie-input').val();
                label = val;
                break;
            case 'checkbox':
                val = [];
                label = [];
                $popover.find('.ie-input:checked').each(function(){
                    val.push($(this).val());
                    label.push($(this).parent().text());
                });
                label = label.join(';');
                break;
            case 'radio':
                val = $popover.find('.ie-input:checked').val();
                label = $popover.find('.ie-input:checked').parent().text();
                break;
        }

        if (val == original) {
            hide();
            return;
        }

        Dcat.NP.start();

        var data = {};

        if (name.indexOf('.') === -1) {
            data[name] = val;
        } else {
            name = name.split('.');

            data[name[0]] = {};
            data[name[0]][name[1]] = val;
        }
        data['_inline_edit_'] = 1;

        $.put({
            url: $trigger.data('url'),
            data: data,
            error:function(a,b,c) {
                Dcat.handleAjaxError(a, b, c);
            },
        }).done(function (res) {
            Dcat.NP.done();
            var data = res.data;
            if (res.status === true) {
                Dcat.success(data.message);
                var $display = $popover.data('display');
                $display.text(label);
                if (! label) {
                    $display.html('<i class="feather icon-edit-2"></i>');
                }
                $trigger.data('value', val).data('original', val);
                hide();
                refresh && Dcat.reload();
            } else {
                Dcat.error(data.message);
            }
        });
    });
</script>
<?php /**PATH /www/wwwroot/amd.youtoube563.top/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/editinline/template.blade.php ENDPATH**/ ?>