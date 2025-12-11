<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="page-title-box">
            <h4 class="page-title"><?php echo e(__('hyper.login_title'), false); ?></h4>
        </div>
    </div>
</div>
<?php if(dujiaoka_config_get('is_open_login') == \App\Models\BaseModel::STATUS_OPEN): ?>
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card card-body sticky">
                <form id="login" action="<?php echo e(url('login'), false); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <!-- Existing email and password fields -->
                    <div class="form-group">
                        <div class="buy-title"><?php echo e(__('hyper.login_email'), false); ?></div>
                        <input type="email" name="email" class="form-control" placeholder="<?php echo e(__('hyper.login_email_input'), false); ?>">
                    </div>
                    <div class="form-group">
                        <div class="buy-title"><?php echo e(__('hyper.login_password'), false); ?></div>
                        <input type="password" name="password" class="form-control" placeholder="<?php echo e(__('hyper.login_password_input'), false); ?>">
                    </div>
                    
                    <!-- Math question field -->
                      <?php if(dujiaoka_config_get('is_openlogin_img_code') == \App\Models\Goods::STATUS_OPEN): ?>
                    <div class="form-group">
                        <div class="buy-title"><?php echo e(__('数学题必填'), false); ?> </div>
                        <label id="math-question"></label>
                        <input type="text" name="math_answer" class="form-control" placeholder="输入结果">
                    </div>
         
                    <!-- Refresh button -->
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" id="refresh">
                            <i class="mdi mdi-refresh mr-1"></i>
                            <?php echo e(__('换一个'), false); ?>

                        </button>
                    </div>
                    <?php endif; ?>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary" id="submit">
                            <i class="mdi mdi-login mr-1"></i>
                            <?php echo e(__('hyper.login_submit'), false); ?>

                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="<?php echo e(dujiaoka_config_get('telegram_bot_username'), false); ?>" data-size="large" data-auth-url="/logintg" data-request-access="write"></script>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <?php echo e(__('hyper.to_tip'), false); ?><a href="<?php echo e(url('register'), false); ?>"><?php echo e(__('hyper.to_register'), false); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row justify-content-center">
        <div class="col-lg-4">
                <div class="alert alert-warning">
                <?php echo e(__('hyper.login_title'), false); ?>关闭维护中......<a href="/">返回首页</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
       <?php if(dujiaoka_config_get('is_openlogin_img_code') == \App\Models\Goods::STATUS_OPEN): ?> 
    function generateMathQuestion() {
        var operator = Math.random() < 0.5 ? '+' : '-';
        var num1 = Math.floor(Math.random() * 100);
        var num2 = Math.floor(Math.random() * 100);


        $('#math-question').text(num1 + ' ' + operator + ' ' + num2 + ' =');

    
        $('#math-question').data('answer', operator === '+' ? num1 + num2 : num1 - num2);
    }


    generateMathQuestion();

  
    $('#refresh').click(function(){
     
        generateMathQuestion();
    });


    $('#submit').click(function(){
      
        var mathAnswer = $("input[name='math_answer']").val();
        if(mathAnswer == ''){
            $.NotificationApp.send("警告","答案不能为空","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }

        // 验证
        var correctAnswer = $('#math-question').data('answer');
        if (parseFloat(mathAnswer) !== correctAnswer) {
            $.NotificationApp.send("警告","答案不正确","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }

        // 随机
        generateMathQuestion();
        
        <?php endif; ?>
        
           $('#submit').click(function(){
        var email = $("input[name='email']").val();
        if(email == ''){
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.register_email_input'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        let reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
        if (!reg.test(email)) {
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.register_email_error'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
        var password = $("input[name='password']").val();
        if(password == ''){
            $.NotificationApp.send("<?php echo e(__('hyper.buy_warning'), false); ?>","<?php echo e(__('hyper.register_password_input'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
            return false;
        }
    });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/static_pages/login.blade.php ENDPATH**/ ?>