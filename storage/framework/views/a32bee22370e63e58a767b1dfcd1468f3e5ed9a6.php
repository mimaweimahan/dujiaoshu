<?php $__env->startSection('content'); ?>
<style>
@media (max-width: 767.98px){
    .page-title-box .page-title-right {
        width: 100%;
    }
    .page-title-right {
        margin-bottom: 17px;
    }
    .app-search {
        width: 100%;
    }
    .phone {
        display: none;
    }
}

.text-body:hover {
    color: blue !important; /* 在鼠标悬停时改变颜色 */
}

 .link-no-decor {
        color: inherit; /* 使链接颜色继承自父元素，避免默认蓝色 */
        text-decoration: none; /* 移除下划线 */
    }
    .link-no-decor:hover {
        color: #007bff; /* 鼠标悬停时变为蓝色 */
    }
.notice img {
    max-width: 288px;
    height: auto;


}
</style>
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
  <!-- Tab Navigation -->
<div class="nav nav-list">
    <!-- 全部分类 -->
    <a href="#group-all" class="tab-link active" data-bs-toggle="tab" role="tab" aria-expanded="false" data-toggle="tab">
        <span class="tab-title"><?php echo e(__('hyper.home_whole'), false); ?></span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    
    <!-- 分类列表 -->
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="#group-<?php echo e($group['id'], false); ?>" class="tab-link" data-bs-toggle="tab" role="tab" aria-expanded="false" data-toggle="tab">
        <span class="tab-title"><?php echo e($group['gp_name'], false); ?></span>
        <div class="img-checkmark">
            <img src="/assets/hyper/images/check.png">
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Tab Content -->
<div class="tab-content" id="myTabContent">
    <!-- All Products Tab Pane -->
    <div class="tab-pane fade show active" id="group-all" role="tabpanel" aria-labelledby="home-tab">
          <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(count($group['goods']) > 0): ?>
    <div class="row category">
        <div class="col-md-12">
            <h3>
                
                <span class="btn badge-info"style="display: block; width: 100%;"><?php echo e($group['gp_name'], false); ?></span>
                
            </h3>
            
        </div>
        <div class="col-md-12">
            <div class="card pl-1 pr-1">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                            
                            <th width="30%"><?php echo e(__('hyper.home_product_name'), false); ?></th>
                            
                            <th width="10%" class="phone"><?php echo e(__('hyper.home_product_class'), false); ?></th>
                            
                            <th width="10%" class="phone"><?php echo e(__('hyper.home_in_stock'), false); ?></th>
                            
                            <th width="10%"><?php echo e(__('hyper.home_price'), false); ?></th>
                            <th width="10%">返利</th>
                            
                            <th width="10%" class="text-center"><?php echo e(__('hyper.home_place_an_order'), false); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $group['goods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goods): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="category">
                            <td class="d-none"><?php echo e($group['gp_name'], false); ?>-<?php echo e($goods['gd_name'], false); ?></td>
                             <td class="table-user">
            
           <?php if($goods['in_stock'] > 0): ?>
                <a href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>" class="text-body" >
                    <img src="<?php echo e(picture_ulr($goods['picture']), false); ?>" class="mr-2 avatar-sm">
                    <?php echo e($goods['gd_name'], false); ?>

                </a>
            <?php else: ?>
                <span class="text-body">
                    <img src="<?php echo e(picture_ulr($goods['picture']), false); ?>" class="mr-2 avatar-sm">
                    <?php echo e($goods['gd_name'], false); ?>

                    <span class="badge badge-outline-secondary"><?php echo e(__('hyper.home_out_of_stock'), false); ?></span>
                </span>
            <?php endif; ?>
                                <?php if($goods['wholesale_price_cnf']): ?>
                                    
                                    <span class="badge badge-outline-warning"><?php echo e(__('hyper.home_discount'), false); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="phone">
                                <?php if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY): ?>
                                    
                                    <span class="badge badge-outline-primary"><?php echo e(__('hyper.home_automatic_delivery'), false); ?></span>
                                <?php else: ?>
                                    
                                    <span class="badge badge-outline-danger"><?php echo e(__('hyper.home_charge'), false); ?></span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="phone">
                                <?php if($goods['in_stock'] > 0): ?>
                                    <span class="badge badge-outline-primary"><?php echo e($goods['in_stock'], false); ?></span>
                                <?php else: ?>
                                  <span class="badge badge-success"><?php echo e($goods['in_stock'], false); ?></span>

                                <?php endif; ?>
                            </td>
                            
                                <td><b style="color: red;"><?php echo e($goods['actual_price'], false); ?> <?php echo e((dujiaoka_config_get('global_currency')), false); ?></b></td>
                                        <td>
              <?php if($goods['open_rebate'] > 0 && $goods['rebate_rate'] > 0): ?>
               
             <span class="badge badge-outline-primary"><?php echo e($goods['rebate_rate'], false); ?>%</span>
             <?php else: ?>
                 无
                 <?php endif; ?>
                 </td>
                            <td class="text-center">
                              <?php if($goods['in_stock'] > 0): ?>
                      
                   <a class="btn btn-outline-primary" href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>"><?php echo e(__('hyper.home_buy'), false); ?></a>
               <?php else: ?>
                  
                    <a class="btn btn-outline-secondary disabled" href="javascript:void(0);"><?php echo e(__('hyper.home_out_of_stock'), false); ?></a>
                         <?php endif; ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    
                </table>
               
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <!-- Each Group Tab Pane -->
    <!-- Each Group Tab Pane -->
    
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="tab-pane fade " id="group-<?php echo e($group['id'], false); ?>" role="tabpanel" aria-labelledby="group-tab-<?php echo e($group['id'], false); ?>">
    <!-- 将每个分类的商品展示代码放在这里 -->
    <div class="col-md-12">
           <h3>
                
                <span class="btn badge-info"style="display: block; width: 100%;"><?php echo e($group['gp_name'], false); ?></span>
                
            </h3>
        <div class="card pl-1 pr-1">
            <table class="table table-centered mb-0">
                <thead>
                    <tr>
                        <th width="30%"><?php echo e(__('hyper.home_product_name'), false); ?></th>
                        <th width="10%" class="phone"><?php echo e(__('hyper.home_product_class'), false); ?></th>
                        <th width="10%" class="phone"><?php echo e(__('hyper.home_in_stock'), false); ?></th>
                        <th width="10%"><?php echo e(__('hyper.home_price'), false); ?></th>
                         <th width="10%">返利</th>
                        <th width="10%" class="text-center"><?php echo e(__('hyper.home_place_an_order'), false); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $group['goods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goods): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="category">
                        
                        <td>
                            
                            
                            <?php if($goods['in_stock'] > 0): ?>
                            <a href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>" class="text-body">
                                <img src="<?php echo e(picture_ulr($goods['picture']), false); ?>" class="mr-2 avatar-sm">
                                <?php echo e($goods['gd_name'], false); ?>

                            </a>
                            <?php else: ?>
                            <span class="text-body">
                                <img src="<?php echo e(picture_ulr($goods['picture']), false); ?>" class="mr-2 avatar-sm">
                                <?php echo e($goods['gd_name'], false); ?>

                                <span class="badge badge-outline-secondary"><?php echo e(__('hyper.home_out_of_stock'), false); ?></span>
                            </span>
                            <?php endif; ?>
                            <?php if($goods['wholesale_price_cnf']): ?>
                            
                            <span class="badge badge-outline-warning"><?php echo e(__('hyper.home_discount'), false); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="phone">
                            
                            <?php if($goods['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY): ?>
                            <span class="badge badge-outline-primary"><?php echo e(__('hyper.home_automatic_delivery'), false); ?></span>
                            <?php else: ?>
                            <span class="badge badge-outline-danger"><?php echo e(__('hyper.home_charge'), false); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="phone">
                            
                            <?php if($goods['in_stock'] > 0): ?>
                            <span class="badge badge-outline-primary"><?php echo e($goods['in_stock'], false); ?></span>
                            <?php else: ?>
                            <span class="badge badge-success"><?php echo e($goods['in_stock'], false); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            
                            <b style="color: red;"><?php echo e($goods['actual_price'], false); ?> <?php echo e((dujiaoka_config_get('global_currency')), false); ?></b>
                        </td>
                       <td>
              <?php if($goods['open_rebate'] > 0 && $goods['rebate_rate'] > 0): ?>
               
             <b style="color: green;"><?php echo e($goods['rebate_rate'], false); ?>%</b>
                 <?php endif; ?>
                 </td>

                        <td class="text-center">
                            
                            <?php if($goods['in_stock'] > 0): ?>
                            <a class="btn btn-outline-primary" href="<?php echo e(url("/buy/{$goods['id']}"), false); ?>"><?php echo e(__('hyper.home_buy'), false); ?></a>
                            <?php else: ?>
                            <a class="btn btn-outline-secondary disabled" href="javascript:void(0);"><?php echo e(__('hyper.home_out_of_stock'), false); ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(dujiaoka_config_get('is_open_wenzhang') == \App\Models\BaseModel::STATUS_OPEN): ?>  
<div class="tab-content" id="myTabContent">
    <!-- All Products Tab Pane -->
    <div class="tab-pane fade show active" id="group-all" role="tabpanel" aria-labelledby="home-tab">
        <div class="row category">
            <div class="col-md-12">
                <h3>                
                    <span class="btn badge-info" style="display: block; width: 100%;">文章教程</span>                
                </h3>            
            </div>
            <div class="col-md-12">
                <div class="card pl-1 pr-1">
                    <table class="table table-centered mb-0">
                        <thead>
                            <tr>
                                <th width="80%">文章标题</th>
                               <th width="20%">更新时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $articles->shuffle()->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="category">
                                <td class="table-user">
                                    <a href="article/<?php echo e(!empty($article['link']) ? $article['link'] : $article['id'], false); ?>" class="text-body">
                                        <img src="<?php echo e(picture_ulr($article['picture']), false); ?>" class="mr-2 avatar-sm">
                                        <span><?php echo e($article['title'], false); ?></span>
                                    </a>
                                </td>
                        <td class="text-center">
                            <a href="article/<?php echo e(!empty($article['link']) ? $article['link'] : $article['id'], false); ?>" class="link-no-decor">
                                        <?php echo e($article['updated_at'], false); ?>

                                                 </a>
                                      </td>


                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/kphyper/static_pages/home.blade.php ENDPATH**/ ?>