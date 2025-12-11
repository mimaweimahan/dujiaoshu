<?php $__env->startSection('content'); ?>
<style>
    .purchase-info-container {
    overflow: hidden;
    white-space: nowrap;
}

.purchase-info {
    display: inline-block;
    animation: slideLeft 20s linear infinite;
}
.purchase-info div {
    color: red;
    font-weight: bold;
    font-size: 18px;
}


@keyframes  slideLeft {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <div class="app-search">
                    <div class="position-relative">
                        <input type="text" class="form-control" id="search" placeholder="<?php echo e(__('hyper.home_search_box'), false); ?>">
                        <span class="uil-search"></span>
                    </div>
                </div>
            </div>
            <h4 class="page-title d-none d-md-block"><?php echo e(__('hyper.home_title'), false); ?></h4>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
            	<h4 class="header-title mb-3"><?php echo e(__('hyper.notice_announcement'), false); ?></h4>
                <div class="notice"><?php echo dujiaoka_config_get('notice'); ?></div>
            </div>
        </div>
    </div>
</div>
  <?php if(dujiaoka_config_get('is_open_xn') == \App\Models\BaseModel::STATUS_OPEN): ?>  
<div class="purchase-info-container">
    <div class="purchase-info">
        <?php $__currentLoopData = $purchaseInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($info['email'], false); ?> 在 <?php echo e($info['time'], false); ?> 购买了 <?php echo e($info['quantity'], false); ?> 件 <?php echo e($info['product'], false); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
    <?php endif; ?>
<div class="nav nav-list">
    <a href="#group-all" class="tab-link active" data-bs-toggle="tab" aria-expanded="false" role="tab" data-toggle="tab">
        <span class="tab-title">
        
        <?php echo e(__('hyper.home_whole'), false); ?>

        </span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="#group-<?php echo e($group['id'], false); ?>" class="tab-link" data-bs-toggle="tab" aria-expanded="false" role="tab" data-toggle="tab">
        <span class="tab-title">
            <?php echo e($group['gp_name'], false); ?>

        </span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="group-all">
        <div class="hyper-wrapper">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $group['goods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goods): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($goods['in_stock'] > 0): ?>
                    <a href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>" class="home-card category">
                    <?php else: ?>
                    <a href="javascript:void(0);" onclick="sell_out_tip()" class="home-card category ribbon-box">
                        <div class="ribbon-two ribbon-two-danger">
                            
                            <span><?php echo e(__('hyper.home_out_of_stock'), false); ?></span>
                        </div>
                    <?php endif; ?>
                        <img class="home-img" src="/assets/hyper/images/loading.gif" data-src="<?php echo e(picture_ulr($goods['picture']), false); ?>">
                        <div class="flex">
                            <p class="name">
                                <?php echo e($goods['gd_name'], false); ?>

                            </p>
                          <div class="price">
                                <p>
                                <b><?php echo e($goods['actual_price'], false); ?></b> <?php echo e((dujiaoka_config_get('global_currency')), false); ?></b>
                                </p>
                                             <?php if($goods['open_rebate'] > 0 && $goods['rebate_rate'] > 0): ?>
    <small>
        
        返利<?php echo e($goods['rebate_rate'], false); ?>%
    </small>
<?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="tab-pane" id="group-<?php echo e($group['id'], false); ?>">
            <div class="hyper-wrapper">
                <?php $__currentLoopData = $group['goods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goods): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($goods['in_stock'] > 0): ?>
                    <a href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>" class="home-card category">
                    <?php else: ?>
                    <a href="javascript:void(0);" onclick="sell_out_tip()" class="home-card category ribbon-box">
                        <div class="ribbon-two ribbon-two-danger">
                            
                            <span><?php echo e(__('hyper.home_out_of_stock'), false); ?></span>
                        </div>
                    <?php endif; ?>
                        <img class="home-img" src="/assets/hyper/images/loading.gif" data-src="<?php echo e(picture_ulr($goods['picture']), false); ?>">
                        <div class="flex">
                            <p class="name">
                                <?php echo e($goods['gd_name'], false); ?>

                            </p>
                             <div class="price">
                                <p>
                                <b><?php echo e($goods['actual_price'], false); ?></b> <?php echo e((dujiaoka_config_get('global_currency')), false); ?></b>
                                </p>
                             <?php if($goods['open_rebate'] > 0 && $goods['rebate_rate'] > 0): ?>
    <small>
        
        返利<?php echo e($goods['rebate_rate'], false); ?>%
    </small>
<?php endif; ?>

                            </div>
                        </div>
                    
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

 
<?php if(dujiaoka_config_get('is_open_wenzhang') == \App\Models\BaseModel::STATUS_OPEN): ?>    
  <div class="row">
    <div class="col-md-12">
        <div class="card">
               <div class="card-header">
               <a href="/article" style="text-decoration: none;">
  <span class="btn badge-info" style="display: block; width: 100%;">文章教程</span>
</a>

            </div>
            <div class="card-body p-0">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                          
                        </tr>
                    </thead>
                    <tbody>
                         <?php $__currentLoopData = $articles->shuffle()->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="article/<?php echo e(!empty($article['link']) ? $article['link'] : $article['id'], false); ?>" class="text-body">
                                    <span><?php echo e($article['title'], false); ?></span>
                                </a>
                            </td>
                     <td class="article-updated-at"><?php echo e($article['updated_at'], false); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('js'); ?>
<script>
    $("#search").on("input",function(e){
        var txt = $("#search").val();
        if($.trim(txt)!="") {
            $(".category").hide().filter(":contains('"+txt+"')").show();
        } else {
            $(".category").show();
        }
    });
    function sell_out_tip() {
        $.NotificationApp.send("<?php echo e(__('hyper.home_tip'), false); ?>","<?php echo e(__('hyper.home_sell_out_tip'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const purchaseInfoContainer = document.querySelector('.purchase-info-container');
    const purchaseInfo = document.querySelector('.purchase-info');
    const purchaseInfoItems = document.querySelectorAll('.purchase-info div');
    let currentIndex = 0;
    let animationDuration = 0;

    function calculateAnimationDuration() {
        const containerWidth = purchaseInfoContainer.offsetWidth;
        const currentItemWidth = purchaseInfoItems[currentIndex].offsetWidth;
        const distanceToTravel = currentItemWidth + containerWidth;
        const pixelsPerSecond = distanceToTravel / 20; // 假设每秒移动的像素数为容器和当前项的宽度之和的20分之一
        animationDuration = distanceToTravel / pixelsPerSecond * 1000; // 将动画持续时间转换为毫秒
    }

    function showNextInfo() {
        // 计算当前购买信息的动画持续时间
        calculateAnimationDuration();

        // 隐藏所有购买信息
        purchaseInfoItems.forEach((item) => {
            item.style.display = 'none';
        });

        // 显示当前购买信息
        purchaseInfoItems[currentIndex].style.display = 'block';

        // 更新索引，循环显示购买信息
        currentIndex = (currentIndex + 1) % purchaseInfoItems.length;

        // 设置定时器，在动画完成后再滚动到下一条信息
        setTimeout(showNextInfo, animationDuration);
    }

    // 初始化
    showNextInfo();
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/hyper/static_pages/home.blade.php ENDPATH**/ ?>