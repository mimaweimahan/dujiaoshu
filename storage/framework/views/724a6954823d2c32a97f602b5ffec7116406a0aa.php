<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            
            <h4 class="page-title"><?php echo e(__('hyper.orderinfo_title'), false); ?></h4>
        </div>
    </div>
</div>
<div class="orderinfo-grid">
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
        <div class="col-md-12">
            <h3>
                <span class="badge badge-outline-primary">
                    订单号：<?php echo e($order['order_sn'], false); ?>

                </span>
            </h3>
        </div>
    </div>
    <div class="card card-body">
        <div class="orderinfo-card-grid">
            <div class="orderinfo-info">
                
                <div class="mb-1"><label><?php echo e(__('hyper.orderinfo_order_title'), false); ?>：</label><span><?php echo e($order['title'], false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.orderinfo_number_of_orders'), false); ?>：</label><span><?php echo e($order['buy_amount'], false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.orderinfo_order_time'), false); ?>：</label><span><?php echo e($order['created_at'], false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.orderinfo_email'), false); ?>：</label><span><?php echo e($order['email'], false); ?></span></div>
                <div class="mb-1">
                    
                    <label><?php echo e(__('hyper.orderinfo_order_class'), false); ?>：</label>
                    <span>
                        <?php if($order['type'] == \App\Models\Order::AUTOMATIC_DELIVERY): ?>
                            
                            <?php echo e(__('hyper.orderinfo_automatic_delivery'), false); ?>

                        <?php else: ?>
                            
                            <?php echo e(__('hyper.orderinfo_charge'), false); ?>

                        <?php endif; ?>
                    </span>
                </div>
                <div class="mb-1">
                    
                    <label><?php echo e(__('hyper.orderinfo_total_order_price'), false); ?>：</label>
                    <span><?php echo e($order['actual_price'], false); ?></span>
                </div>
                <div class="mb-1">
                    
                    <label><?php echo e(__('hyper.orderinfo_order_status'), false); ?>：</label>
                    <span>
                        <?php switch($order['status']):
                            case (\App\Models\Order::STATUS_EXPIRED): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_expired'), false); ?>

                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_WAIT_PAY): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_wait_pay'), false); ?>

                                  <a class="btn btn-primary" href="/bill/<?php echo e($order->order_sn, false); ?>">重新结算</a>
                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_PENDING): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_pending'), false); ?>

                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_PROCESSING): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_processed'), false); ?>

                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_COMPLETED): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_completed'), false); ?>

                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_FAILURE): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_failed'), false); ?>

                            <?php break; ?>
                            <?php case (\App\Models\Order::STATUS_FAILURE): ?>
                                
                                <?php echo e(__('hyper.orderinfo_status_abnormal'), false); ?>

                            <?php break; ?>
                        <?php endswitch; ?>
                    </span>
                </div>
                <div class="mb-1">
                    
                    <label><?php echo e(__('hyper.orderinfo_payment_method'), false); ?>：</label>
                    <?php if($order['pay_id'] > 0): ?>
                    <span><?php echo e($order['pay']['pay_name'] ?? '', false); ?></span>
                    <?php else: ?>
                    <span>余额支付</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="orderinfo-kami">
                <h5 class="card-title">
                    <?php echo e(__('hyper.orderinfo_carmi'), false); ?>

                </h5>
                <textarea class="form-control textarea-kami" rows="5"><?php echo e($order['info'], false); ?></textarea>
                <button class="btn btn-outline-primary kami-btn" data-clipboard-text="<?php echo e($order['info'], false); ?>">
                    <?php echo e(__('hyper.orderinfo_copy_carmi'), false); ?>

                </button>
                <a href="detail-order-sn/<?php echo e($order->order_sn, false); ?>/export-carmis" class="btn btn-primary">下载卡密信息</a>



            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php if(!count($orders)): ?>
<div class="row justify-content-center">
    <div class="col-lg-4">
		<div class="text-center">
			<h1 class="text-error mt-4">error</h1>
            <h4 class="text-uppercase text-danger mt-3"><?php echo e(__('hyper.orderinfo_order_information'), false); ?></h4>
            <a class="btn btn-info mt-3" href="javascript:history.back(-1);"><i class="mdi mdi-reply"></i> <?php echo e(__('hyper.error_back_btn'), false); ?></a>
        </div> <!-- end /.text-center-->
    </div> <!-- end col-->
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="/assets/hyper/js/clipboard.min.js"></script>
<script>
    var clipboard = new ClipboardJS('.kami-btn');
    clipboard.on('success', function(e){
        $.NotificationApp.send("<?php echo e(__('hyper.orderinfo_tips'), false); ?>","<?php echo e(__('hyper.orderinfo_copy_success'), false); ?>","top-center","rgba(0,0,0,0.2)","info");
    });
    clipboard.on('error', function(e){
        $.NotificationApp.send("<?php echo e(__('hyper.orderinfo_tips'), false); ?>","<?php echo e(__('hyper.orderinfo_copy_error'), false); ?>","top-center","rgba(0,0,0,0.2)","error");
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/static_pages/orderinfo.blade.php ENDPATH**/ ?>