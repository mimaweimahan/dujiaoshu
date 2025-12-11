<?php $__env->startSection('content'); ?>
<style>.btn-disabled {
    background-color: #ccc;
    color: #666;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            
            <h4 class="page-title"><?php echo e(__('hyper.buy_title'), false); ?></h4>
        </div>
    </div>
</div>
<div class="buy-grid">
    <div class="buy-shop hyper-sm-last">
        <div class="card card-body sticky">
            <form id="buy-form" action="<?php echo e(url('create-order'), false); ?>" method="post">
                <?php echo e(csrf_field(), false); ?>

                <div class="form-group">
                    <h3>
                        
                        <?php echo e($gd_name, false); ?>

                    </h3>
                </div>
                <div class="form-group">
                    <?php if($type == \App\Models\Goods::AUTOMATIC_DELIVERY): ?>
                        
                        <span class="badge badge-outline-primary"><?php echo e(__('hyper.buy_automatic_delivery'), false); ?></span>
                    <?php else: ?>
                        
                        <span class="badge badge-outline-danger"><?php echo e(__('hyper.buy_charge'), false); ?></span>
                    <?php endif; ?>
                    
                    <span class="badge badge-outline-primary"><?php echo e(__('hyper.buy_in_stock'), false); ?>(<?php echo e($in_stock, false); ?>)</span>
                    <?php if($buy_limit_num > 0): ?>
                        <span class="badge badge-outline-dark"> <?php echo e(__('hyper.buy_purchase_restrictions'), false); ?>(<?php echo e($buy_limit_num, false); ?>)</span>
                    <?php endif; ?>
                  <?php if($open_rebate > 0 && $rebate_rate > 0): ?>
    <span class="badge badge-outline-success">返利<?php echo e($rebate_rate, false); ?>%</span>
<?php endif; ?>

                </div>
                <?php if(!empty($wholesale_price_cnf) && is_array($wholesale_price_cnf)): ?>
                    <div class="form-group">
                        <div class="alert alert-dark bg-white text-dark mb-0" role="alert">
                            
                            <?php $__currentLoopData = $wholesale_price_cnf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ws): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <span>
                                    <?php echo e(__('hyper.buy_purchase'), false); ?> <?php echo e($ws['number'], false); ?> <?php echo e(__('hyper.buy_the_above'), false); ?>，<?php echo e($ws['price'], false); ?> <?php echo e((dujiaoka_config_get('global_currency')), false); ?>/件。
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <!--<div class="buy-title"><?php echo e(__('hyper.buy_price'), false); ?></div>-->
                    <h3>
                        
                        <span class="buy-price"><?php echo e($actual_price, false); ?>  <?php echo e((dujiaoka_config_get('global_currency')), false); ?> </span>
                        
                        <small><del>¥ <?php echo e($retail_price, false); ?>  <?php echo e((dujiaoka_config_get('global_currency')), false); ?></del></small>
                    </h3>
                </div>
                <div class="form-group">
                    

                    
                    <?php if(Auth::check()): ?>
                     <div class="buy-title"><?php echo e(__('hyper.buy_email'), false); ?></div>
                    <input type="hidden" name="gid" value="<?php echo e($id, false); ?>">
                    <input type="text" name="email" class="form-control" value="<?php echo e(Auth::user()->email?Auth::user()->email:Auth::user()->telegram_id, false); ?>" disabled>
                    <?php else: ?>
                 <?php if(dujiaoka_config_get('is_open_mail') == \App\Models\BaseModel::STATUS_OPEN): ?>
                  <div class="buy-title">随意填写</div>
                    <input type="hidden" name="gid" value="<?php echo e($id, false); ?>">
                   <input type="text" name="email" class="form-control" placeholder="随意填写">
                   <?php else: ?>
                    <div class="buy-title"><?php echo e(__('hyper.buy_email'), false); ?></div>
                    <input type="hidden" name="gid" value="<?php echo e($id, false); ?>">
                   <input type="email" name="email" class="form-control" placeholder="<?php echo e(__('hyper.buy_input_account'), false); ?>">
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    
                    <div class="buy-title"><?php echo e(__('hyper.buy_purchase_quantity'), false); ?></div>
                    <div class="input-group">
                        <input data-toggle="touchspin" type="text" name="by_amount" value="1" data-bts-max="99999">
                    </div>
                </div>
                <?php if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN): ?>
                <div class="form-group">
                    
                    <div class="buy-title"><?php echo e(__('hyper.buy_search_password'), false); ?></div>
                    
                    <input type="text" name="search_pwd" value="" class="form-control" placeholder="<?php echo e(__('hyper.buy_input_search_password'), false); ?>">
                </div>
                <?php endif; ?>
                <?php if(isset($open_coupon)): ?>
                    <div class="form-group">
                        
                        <div class="buy-title"><?php echo e(__('hyper.buy_promo_code'), false); ?></div>
                        
                        <input type="text" name="coupon_code" class="form-control" placeholder="<?php echo e(__('hyper.buy_input_promo_code'), false); ?>">
                    </div>
                <?php endif; ?>
                <?php if($type == \App\Models\Goods::MANUAL_PROCESSING && is_array($other_ipu)): ?>
                    <?php $__currentLoopData = $other_ipu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ipu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <div class="buy-title"><?php echo e($ipu['desc'], false); ?></div>
                            <input type="text" name="<?php echo e($ipu['field'], false); ?>" <?php if($ipu['rule'] !== false): ?> required <?php endif; ?> class="form-control" placeholder="<?php echo e($ipu['placeholder'], false); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN ): ?>
                    <div class="form-group">
                        
                        <div class="buy-title"><?php echo e(__('hyper.buy_behavior_verification'), false); ?></div>
                        <div id="geetest-captcha"></div>
                        <p id="wait-geetest-captcha" class="show">loading...</p>
                    </div>
                <?php endif; ?>
                <?php if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN): ?>
                    
                    <div class="form-group">
                        <div class="buy-title"><?php echo e(__('hyper.buy_verify_code'), false); ?></div>
                        <div class="input-group">
                            <input type="text" name="img_verify_code" value="" class="form-control" placeholder="<?php echo e(__('hyper.buy_verify_code'), false); ?>">
                            <div class="input-group-append">
                                <div class="buy-captcha">
                                    <img class="captcha-img"  src="<?php echo e(captcha_src('buy') . time(), false); ?>" onclick="refresh()" style="cursor: pointer;">
                                </div>
                            </div>
                        </div>
                        <script>
                            function refresh(){
                                $('img[class="captcha-img"]').attr('src','<?php echo e(captcha_src('buy'), false); ?>'+Math.random());
                            }
                        </script>
                    </div>
                <?php endif; ?>
                
                <?php if($preselection >= 0 && !empty($selectable)): ?>
          <div class="form-group">
        <?php
            $foundInfo = false;
        ?>

        <div class="buy">
            <?php $__currentLoopData = $selectable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carmi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($carmi['info'])): ?>
                    <?php if(!$foundInfo): ?>
                        <div>
                            <label class="col-form-label"><?php echo e(__('dujiaoka.preselection'), false); ?> <b><?php echo e($preselection, false); ?>  <?php echo e((dujiaoka_config_get('global_currency')), false); ?><span class="buy-price"></b></span> </label>
                        </div>
                        <?php
                            $foundInfo = true;
                        ?>
                    <?php endif; ?>

                    <div>
                        <label>
                            <input type="radio" name="carmi_id" value="<?php echo e($carmi['id'], false); ?>">
                            <?php echo e($carmi['info'], false); ?>

                        </label>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>



                <div class="form-group">
                    
                    <div class="buy-title"><?php echo e(__('hyper.buy_payment_method'), false); ?></div>
                    <div class="input-group">
                        <input type="hidden" name="payway" value="<?php echo e(Auth::check() ? 0 : $payways[0]['id'] ?? 0, false); ?>">
                        <?php if(Auth::check()): ?>
                        <div class="pay-type active" data-type="balance" data-id="0" data-name="余额支付">
                        </div>
                        <?php endif; ?>
                        <div class="pay-grid">
                        <?php $__currentLoopData = $payways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $way): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="btn pay-type <?php if($key == 0 && !Auth::check()): ?> active <?php endif; ?>"
                                         data-type="<?php echo e($way['pay_check'], false); ?>" data-id="<?php echo e($way['id'], false); ?>" data-name="<?php echo e($way['pay_name'], false); ?>">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <input type="hidden" name="aff" value="">
                    
                    <button type="submit" class="btn btn-danger" id="submit">
                        <i class="mdi mdi-truck-fast mr-1"></i>
                            <?php echo e(__('hyper.buy_order_now'), false); ?>

                    </button>
                </div>
            </form>
        </div> <!-- end card-->
    </div>
    <div class="card card-body buy-product">

        <?php echo $description; ?>

    </div>
</div>
<div class="modal fade" id="buy_prompt" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title" id="myCenterModalLabel"><?php echo e(__('hyper.buy_purchase_tips'), false); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <?php echo $buy_prompt; ?>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: none;">
        <img id="img-zoom" style="border-radius: 5px;">
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    if (getCookie('aff') != '') {
        $("input[name='aff']").val(getCookie('aff'));
    }
    $('#submit').click(function(){
        if($("input[name='email']").val() == ''){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_empty_mailbox'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if($("input[name='by_amount']").val() == 0 ){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_zero_quantity'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        if($("input[name='by_amount']").val() > <?php echo e($in_stock, false); ?>){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_exceeds_stock'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        <?php if($buy_limit_num > 0): ?>
        if($("input[name='by_amount']").val() > <?php echo e($buy_limit_num, false); ?>){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_exceeds_limit'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        <?php endif; ?>
        <?php if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN): ?>
        if($("input[name='search_pwd']").val() == 0){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_empty_query_password'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        <?php endif; ?>
        <?php if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN): ?>
        if($("input[name='img_verify_code']").val() == ''){
            
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_empty_captcha'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        <?php endif; ?>
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化，设置提交按钮为不可点击状态
    updateSubmitButtonState();

    // 为每个支付类型按钮添加点击事件监听器
    const payTypes = document.querySelectorAll('.pay-type');
    payTypes.forEach(function(payType) {
        payType.addEventListener('click', function() {
            // 处理支付方式的点击事件
            handlePayTypeClick(this);
            // 当支付方式被选择时，更新提交按钮状态
            updateSubmitButtonState();
        });
    });

    // 为提交按钮添加点击事件监听器
    const submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', function(event) {
        const selectedPayType = document.querySelector('.pay-type.active');
        if (!selectedPayType) {
            // 如果没有选中支付方式，则显示提示并阻止表单提交
            event.preventDefault();
            alert('请选择支付方式后再提交订单');
        }
    });
});

function handlePayTypeClick(clickedPayType) {
    // 移除所有支付方式上的active类
    const payTypes = document.querySelectorAll('.pay-type');
    payTypes.forEach(function(payType) {
        payType.classList.remove('active');
    });

    // 为点击的支付方式添加active类
    clickedPayType.classList.add('active');
}

function updateSubmitButtonState() {
    const submitButton = document.getElementById('submit');
    const selectedPayType = document.querySelector('.pay-type.active');

    // 如果有选中的支付方式，启用提交按钮，否则禁用
    if (selectedPayType) {
        submitButton.disabled = false;
        submitButton.classList.remove('btn-disabled');
    } else {
        submitButton.disabled = true;
        submitButton.classList.add('btn-disabled');
    }
}

</script>


<script>
    <?php if(!empty($buy_prompt)): ?>
        $('#buy_prompt').modal();
    <?php endif; ?>
        $(function() {
        //点击图片放大
        $("#img-zoom").click(function(){
            $('#img-modal').modal("hide");
        });
        $("#img-dialog").click(function(){
            $('#img-modal').modal("hide");
        });
        $(".buy-product img").each(function(i){
            var src = $(this).attr("src");
            $(this).click(function () {
                $("#img-zoom").attr("src", src);
                var oImg = $(this);
                var img = new Image();
                img.src = $(oImg).attr("src");
                var realWidth = img.width;
                var realHeight = img.height;
                var ww = $(window).width();
                var hh = $(window).height();
                $("#img-content").css({"top":0,"left":0,"height":"auto"});
                $("#img-zoom").css({"height":"auto"});
                $("#img-zoom").css({"margin-left":"auto"});
                $("#img-zoom").css({"margin-right":"auto"});
                if((realWidth+20)>ww){
                    $("#img-content").css({"width":"100%"});
                    $("#img-zoom").css({"width":"100%"});
                }else{
                    $("#img-content").css({"width":realWidth+20, "height":realHeight+20});
                    $("#img-zoom").css({"width":realWidth, "height":realHeight});
                }
                if((hh-realHeight-40)>0){
                    $("#img-content").css({"top":(hh-realHeight-40)/2});
                }
                if((ww-realWidth-20)>0){
                    $("#img-content").css({"left":(ww-realWidth-20)/2});
                }
                $('#img-modal').modal();
            });
        });
    });
</script>
<?php if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN ): ?>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<script>
    var geetest = function(url) {
        var handlerEmbed = function(captchaObj) {
            $("#geetest-captcha").closest('form').submit(function(e) {
                var validate = captchaObj.getValidate();
                if (!validate) {
                    $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.buy_correct_verification'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
                    e.preventDefault();
                }
            });
            captchaObj.appendTo("#geetest-captcha");
            captchaObj.onReady(function() {
                $("#wait-geetest-captcha")[0].className = "d-none";
            });
            captchaObj.onSuccess(function () {$('#geetest-captcha').attr("placeholder",'<?php echo e(__('dujiaoka.success_behavior_verification'), false); ?>')})

            captchaObj.appendTo("#geetest-captcha");
        };
        $.ajax({
            url: url + "?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                initGeetest({
                    width: '100%',
                    gt: data.gt,
                    challenge: data.challenge,
                    product: "popup",
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    lang: '<?php echo e(dujiaoka_config_get('language') ?? 'zh-CN', false); ?>',
                    http: '<?php echo e((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://", false); ?>' + '://'
                }, handlerEmbed);
            }
        });
    };
    (function() {
        geetest('<?php echo e('/check-geetest', false); ?>');
    })();
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/static_pages/buy.blade.php ENDPATH**/ ?>