<div class="header-navbar">
    <div class="container header-flex">
        <!-- LOGO -->
        <a href="/" class="topnav-logo" style="float: none;">
            <img src="<?php echo e(picture_ulr(dujiaoka_config_get('img_logo')), false); ?>" height="36">
            <div class="logo-title"><?php echo e(dujiaoka_config_get('text_logo'), false); ?></div>
        </a>
        
        <div class="header-right">
   
            <a class="btn btn-outline-primary" href="<?php echo e(url('order-search'), false); ?>">
                <i class="noti-icon uil-file-search-alt search-icon"></i>
                查询订单
            </a>
            <?php if(Auth::check()): ?>
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                <i class="uil uil-user"></i>
                <?php echo e(Auth::user()->email?Auth::user()->email:Auth::user()->telegram_nick, false); ?>

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="<?php echo e(url('user'), false); ?>">个人中心</a>
                <?php if(Auth::user()->grade > 0): ?>
                <a class="dropdown-item" href="<?php echo e(url('/user/wholesale'), false); ?>">商品批发</a>
                <?php endif; ?>
                <a class="dropdown-item" href="<?php echo e(url('logout'), false); ?>">退出登录</a>
            </div>
            <?php else: ?>
            <a class="btn btn-outline-primary" href="<?php echo e(url('login'), false); ?>">
                <i class="uil uil-user"></i>
                登录
            </a>
  
            <?php endif; ?>
          
        </div>
    </div>
</div>
<?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/layouts/_nav.blade.php ENDPATH**/ ?>