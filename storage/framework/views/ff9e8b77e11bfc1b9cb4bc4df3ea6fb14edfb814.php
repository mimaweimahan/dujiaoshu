<input class="grid-column-switch" data-url="<?php echo e($url, false); ?>" data-reload="<?php echo e($refresh, false); ?>" data-size="small" name="<?php echo e($column, false); ?>" <?php echo e($checked, false); ?> type="checkbox" data-color="<?php echo e($color, false); ?>"/>

<script require="@switchery">
    var swt = $('.grid-column-switch'),
        that;
    function initSwitchery() {
        swt.parent().find('.switchery').remove();
        swt.each(function () {
            that = $(this);
            new Switchery(that[0], that.data())
        })
    }
    initSwitchery();

    swt.off('change').on('change', function(e) {
        var that = $(this),
            url = that.data('url'),
            reload = that.data('reload'),
            checked = that.is(':checked'),
            name = that.attr('name'),
            data = {},
            value = checked ? 1 : 0;

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
                var msg = d.data.message || d.message;

                if (d.status) {
                    Dcat.success(msg);
                    reload && Dcat.reload();
                } else {
                    Dcat.error(msg);
                }
            }
        });
    });
</script>
<?php /**PATH /www/wwwroot/amd.youtoube563.top/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/switch.blade.php ENDPATH**/ ?>