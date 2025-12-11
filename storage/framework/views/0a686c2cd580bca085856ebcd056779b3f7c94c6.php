<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="page-title-box">
            
            <h4 class="page-title"><?php echo e(__('hyper.bill_title'), false); ?></h4>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-body">
        	<div class="mx-auto">
        	    
                <div class="mb-1"><label><?php echo e(__('hyper.bill_order_number'), false); ?>：</label><span><?php echo e($order_sn, false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_product_name'), false); ?>：</label><span><?php echo e($title, false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_commodity_price'), false); ?>：</label><span><?php echo e($goods_price, false); ?>  <?php echo e((dujiaoka_config_get('global_currency')), false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_purchase_quantity'), false); ?>：</label><span>x <?php echo e($buy_amount, false); ?></span></div>
                 <?php if($preselection ?? ''): ?>
                                        <div class="mb-1"><label><?php echo e(__('order.fields.preselection'), false); ?>：</label><span><?php echo e($preselection, false); ?></span></div>
                                 <div class="mb-1"> <label>自选卡密价格:</label> <?php echo e($goods['preselection'], false); ?> <?php echo e((dujiaoka_config_get('global_currency')), false); ?></div>
                                        
                                    <?php endif; ?>
                <?php if(!empty($coupon)): ?>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_promo_code'), false); ?>：</label><span><?php echo e($coupon['coupon'], false); ?></span></div>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_discounted_price'), false); ?>：</label><span><?php echo e($coupon_discount_price, false); ?></span></div>
                <?php endif; ?>
            
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_email'), false); ?>：</label><span><?php echo e($email, false); ?></span></div>
                <?php if(!empty($info)): ?>
                
                <div class="mb-1"><label><?php echo e(__('hyper.bill_order_information'), false); ?>：</label><span><?php echo e($info, false); ?></span></div>
                <?php endif; ?>
                
                
              <?php if($pay_id > 0 && !empty(trim($pay['pay_name']))): ?>
    <div class="mb-1">
        <label><?php echo e(__('hyper.bill_payment_method'), false); ?>：</label>
        <span><?php echo e($pay['pay_name'], false); ?></span>
    </div>
    <?php if($pay['is_openfee'] > 0 && $pay['pay_fee'] > 0): ?>
        <div class="mb-1">
            <label><?php echo e(__('dujiaoka.payment_fee'), false); ?>：</label>
            <span><?php echo e($pay['pay_fee'], false); ?>%</span>
        </div>
    <?php endif; ?>

       <?php if($pay['is_openhui'] > 0 && $pay['pay_qhuilv'] > 1): ?>
        <div class="mb-1">
            <label><?php echo e(__('当前汇率'), false); ?>：<?php echo e($pay['pay_operation'], false); ?></label>
            <span><?php echo e($pay['pay_qhuilv'], false); ?></span>
        </div>
    <?php endif; ?>
   
                 <?php else: ?>
             <div class="mb-1"> <label><?php echo e(__('hyper.bill_payment_method'), false); ?>：</label> <span>余额支付</span></div>
                <?php endif; ?>
            
        
                
            <div class="mb-1"><label><?php echo e(__('hyper.bill_actual_payment'), false); ?>：</label><span><?php echo e($actual_price, false); ?></span></div>


            <div class="text-center">
                
                <?php if($pay_id > 0): ?>
                <a href="<?php echo e(url('pay-gateway', ['handle' => urlencode($pay['pay_handleroute']),'payway' => $pay['pay_check'], 'orderSN' => $order_sn]), false); ?>"
                   class="btn btn-danger">
                    <?php echo e(__('hyper.bill_pay_immediately'), false); ?>

                </a>
                <?php else: ?>
                <a href="<?php echo e(url('pay/wallet/'.$order_sn), false); ?>"
                   class="btn btn-danger">
                    <?php echo e(__('hyper.bill_pay_immediately'), false); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/static_pages/bill.blade.php ENDPATH**/ ?>