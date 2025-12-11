<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            
            <h4 class="page-title"><?php echo e(__('hyper.searchOrder_title'), false); ?></h4>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php echo e(__('hyper.searchOrder_query_tips'), false); ?>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-body">
            <div class="tab-pane show active" id="bordered-tabs-preview">
                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#dingdanhao" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            
                            <span><?php echo e(__('hyper.searchOrder_order_search_by_number'), false); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#youxiang" data-toggle="tab" aria-expanded="true" class="nav-link">
                            
                            <span><?php echo e(__('hyper.searchOrder_order_search_by_email'), false); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#liulanqi" data-toggle="tab" aria-expanded="false" class="nav-link">
                            
                            <span><?php echo e(__('hyper.searchOrder_order_search_by_ie'), false); ?></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="dingdanhao">
                        <form class="needs-validation" action="<?php echo e(url('search-order-by-sn'), false); ?>" method="post">
                        	<?php echo e(csrf_field(), false); ?>

                            <div class="form-group mb-3">
                                
                                <label for="validationCustom01"><?php echo e(__('hyper.searchOrder_order_number'), false); ?></label>
                                <input type="text" class="form-control" name="order_sn" required  placeholder="<?php echo e(__('hyper.searchOrder_input_order_number'), false); ?>">
                            </div>
                            <div class="form-group mb-3">
                                
                                <button class="btn btn-primary" type="submit"><?php echo e(__('hyper.searchOrder_search_now'), false); ?></button>
                                
                                <button type="reset" class="btn btn-primary"><?php echo e(__('hyper.searchOrder_reset_order'), false); ?></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="youxiang">
                        <form class="needs-validation" action="<?php echo e(url('search-order-by-email'), false); ?>" method="post">
                        	<?php echo e(csrf_field(), false); ?>

                            <div class="form-group mb-3">
                                
                                <label for="validationCustom01"><?php echo e(__('hyper.searchOrder_email'), false); ?></label>
                                  <?php if(dujiaoka_config_get('is_open_mail') == \App\Models\BaseModel::STATUS_OPEN): ?>
                                <input type="text" class="form-control" name="email" required  placeholder="根据你下单的格式填写">
                               <?php else: ?>
                                    <input type="email" class="form-control" name="email" required  placeholder="<?php echo e(__('hyper.searchOrder_input_email'), false); ?>">
                                         <?php endif; ?>
                            </div>
                            <?php if(dujiaoka_config_get('is_open_search_pwd', \App\Models\BaseModel::STATUS_CLOSE) == \App\Models\BaseModel::STATUS_OPEN): ?>
                            <div class="form-group mb-3">
                                
                                <label for="validationCustom01"><?php echo e(__('hyper.searchOrder_search_password'), false); ?></label>
                                <input type="password" class="form-control" name="search_pwd" required  placeholder="<?php echo e(__('hyper.searchOrder_input_query_password'), false); ?>">
                            </div>
                            <?php endif; ?>
                            <div class="form-group mb-3">
                                
                                <button class="btn btn-primary" type="submit"><?php echo e(__('hyper.searchOrder_search_now'), false); ?></button>
                                
                                <button type="reset" class="btn btn-primary"><?php echo e(__('hyper.searchOrder_reset_order'), false); ?></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="liulanqi">
                        <form class="needs-validation" action="<?php echo e(url('search-order-by-browser'), false); ?>" method="post">
                        	<?php echo e(csrf_field(), false); ?>

                            <div class="form-group mb-3">
                                
                                <button class="btn btn-primary" type="submit"><?php echo e(__('hyper.searchOrder_search_now'), false); ?></button>
                            </div>
                        </form>
                    </div>
                </div>                                          
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/kphyper/static_pages/searchOrder.blade.php ENDPATH**/ ?>