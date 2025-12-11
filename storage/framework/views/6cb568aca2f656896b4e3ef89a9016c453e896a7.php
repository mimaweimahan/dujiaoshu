<?php $__env->startSection('content'); ?>

<div class="row mt-3">
    <div class="col-sm">
        <div class="card stats-card">
            <div class="stats-icon"><i class="uil uil-user"></i></div>
            <div class="stats-detail"><span>用户名</span>
            
                <div class="stats-member">
                    <h6 class="h6 mt-0"><?php echo e(Auth::user()->email?Auth::user()->email:Auth::user()->telegram_nick, false); ?></h6>
                  

                </div>
                <div class="malus-invite-tips">ID: <?php echo e(Auth::user()->id, false); ?></div>
                  <button class="btn btn-sm btn-warning btn-pill" data-toggle="modal" data-target="#changePasswordModal">修改密码</button>
            </div>
        </div>
    </div>
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">修改密码</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form id="change-password-form" action="<?php echo e(url('/user/change-password'), false); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="current-password">当前密码</label>
                        <input type="password" class="form-control" id="current-password" name="current_password" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="new-password">新密码</label>
                        <input type="password" class="form-control" id="new-password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-new-password">确认新密码</label>
                        <input type="password" class="form-control" id="confirm-new-password" name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">提交更改</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
    
    <div class="col-sm">
        <div class="card stats-card">
            <div class="stats-icon stats-icon-time"><i class="uil uil-yen"></i></div>
            <div class="stats-detail"><span>账户余额</span>
                <div class="stats-member">
                    <h6 class="h6 mt-0">￥<?php echo e(Auth::user()->money, false); ?></h6>
                </div>
            </div>
            <button class="btn btn-sm btn-primary btn-pill" data-toggle="modal" data-target="#rechargeModal">充值</button>
            <div class="malus-invite-tips">充值可得更多好礼哦</div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card stats-card">
            <div class="stats-icon stats-icon-time"><i class="uil"></i></div>
            <div class="stats-detail"><span>代理等级</span>
                <div class="stats-member">
                    <h6 class="h6 mt-0"><?php echo e(Auth::user()->grade, false); ?>级代理</h6>
                </div>
            </div>

        </div>
    </div>
    <div class="col-sm">
        <div class="card stats-card">
            <div class="stats-icon stats-icon-user"><i class="uil uil-user-plus"></i></div>
            <div class="stats-detail"><span>返利订单数</span>
                <div class="stats-member">
                    <h6 class="h6 mt-0"><?php echo e($invite_count, false); ?> 单</h6>
                </div>
            </div>
            <a href="<?php echo e(url('/user/invite'), false); ?>" class="btn btn-sm btn-outline-orange btn-pill">查看邀请</a>
            <div class="malus-invite-tips">邀请好友注册，购买还返现金</div>
        </div>
    </div>
</div>
   <div class="row">
    <div class="col">
        <div class="text-center my-3"> <!-- 'my-3' 是为了添加一些垂直间距 -->
            <p style="color: red;"><?php echo dujiaoka_config_get('daili_text'); ?></p>
        </div>
    </div>
</div>
    <div class="card vip-center">
        <div class="card-header">
            <h3 class="card-title">订单列表</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive order-table">
         <table class="table table-hover">
    <thead>
    <tr>
        <th>
            <input type="checkbox" id="selectAll"> <!-- 添加全选复选框 -->
        </th>
        <th>订单号</th>
        <th>订单名称</th>
        <th>支付金额</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
</thead>
<tbody>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>
            <?php if($order->status === \App\Models\Order::STATUS_WAIT_PAY): ?>
            <!-- 仅当订单状态为待支付时显示复选框 -->
            <input type="checkbox" class="order-checkbox" data-order-sn="<?php echo e($order->order_sn, false); ?>">
            <?php endif; ?>
        </td>
        <td><?php echo e($order->order_sn, false); ?></td>
        <td><?php echo e($order->title, false); ?></td>
        <td class="text-primary">￥<?php echo e($order->actual_price, false); ?></td>
        <td>
            <?php switch($order->status):
            case (\App\Models\Order::STATUS_EXPIRED): ?>
            
            <label class="badge badge-secondary">已过期</label>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_WAIT_PAY): ?>
            
            <label class="badge badge-primary">待支付</label>
            <!-- 为未支付的订单添加"重新结算"按钮 -->
            <?php if($order->status === \App\Models\Order::STATUS_WAIT_PAY): ?>
            <a class="badge badge-warning" href="/bill/<?php echo e($order->order_sn, false); ?>">重新结算</a>
            <?php endif; ?>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_PENDING): ?>
            
            <label class="badge badge-warning">待处理</label>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_PROCESSING): ?>
            
            <label class="badge badge-success">已处理</label>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_COMPLETED): ?>
            
            <label class="badge badge-success">已完成</label>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_FAILURE): ?>
            
            <label class="badge badge-danger">已失败</label>
            <?php break; ?>
            <?php case (\App\Models\Order::STATUS_FAILURE): ?>
            
            <label class="badge badge-dark">状态异常</label>
            <?php break; ?>
            <?php endswitch; ?>
        </td>
        <td><?php echo e($order->created_at, false); ?></td>
        <td>
            <a class="btn btn-link" href="/search-order-by-sn?order_sn=<?php echo e($order->order_sn, false); ?>">查看订单</a>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>

</table>
<?php echo e($orders->links(), false); ?>


            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">余额充值</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="buy-form" action="<?php echo e(url('/user/recharge-money'), false); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="form-group buy-group">
                        <div class="buy-title">充值金额</div>
                        <div class="choose-tag">
                            <?php if($recharge_promotion): ?>
                            <?php $__currentLoopData = $recharge_promotion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tag" data-key="<?php echo e($key, false); ?>" data-amount="<?php echo e($item['amount'], false); ?>">
                                充￥<?php echo e($item['amount'], false); ?><div class="discount-tag">送￥<?php echo e($item['value'], false); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                       <input type="number" name="amount" min="1" class="form-control" placeholder="请输入需要充值的金额" autocomplete="off">

                    </div>
                    <div class="form-group buy-group">
                        
                        <input type="hidden" name="payway" lay-verify="payway"
                               value="<?php echo e($payways[0]['id'] ?? 0, false); ?>">
                        <div class="buy-title"><?php echo e(__('hyper.buy_payment_method'), false); ?>:</div>
                        <?php $__currentLoopData = $payways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $way): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="pay-type <?php if($key == 0): ?> active <?php endif; ?>"
                             data-type="<?php echo e($way['pay_check'], false); ?>" data-id="<?php echo e($way['id'], false); ?>"
                             data-name="<?php echo e($way['pay_name'], false); ?>">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-danger" id="submit">
                            <i class="mdi mdi-truck-fast mr-1"></i>
                            点击充值
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if(session('success')): ?>
        // 显示成功消息
        $.NotificationApp.send("Success", "<?php echo e(session('success'), false); ?>", "top-right", "rgba(0,0,0,0.2)", "success");
    <?php endif; ?>

    <?php if($errors->any()): ?>
        // 显示第一个错误消息
        var firstError = "<?php echo e($errors->all()[0], false); ?>"; // 仅示例，可能需要适当调整
        $.NotificationApp.send("Error", firstError, "top-right", "rgba(0,0,0,0.2)", "error");
    <?php endif; ?>
});
</script>


<script>
   $('.tag').each(function () {
        let t = $(this), key = t.data('key');
    }).click(function () {
        $('.tag').removeClass('active');
        $(this).toggleClass("active");
        $('input[name=amount]').val($(this).data('amount'));
    });
</script>
<script>
$(document).ready(function() {
    // 检查初始支付方式
    updateSubmitButtonState();

    // 支付方式点击事件
    $('.pay-type').click(function() {
        $('.pay-type').removeClass('active'); // 移除所有支付方式的active类
        $(this).addClass('active'); // 当前点击的支付方式添加active类
        $('input[name="payway"]').val($(this).data('id')); // 更新隐藏输入字段的值为当前支付方式的ID
        
        updateSubmitButtonState(); // 更新提交按钮的状态
    });

    // 更新提交按钮的状态
    function updateSubmitButtonState() {
        if ($('input[name="payway"]').val() == 0 || $('input[name="payway"]').val() == "") {
            $('#submit').prop('disabled', true).addClass('btn-disabled'); // 禁用充值按钮
        } else {
            $('#submit').prop('disabled', false).removeClass('btn-disabled'); // 启用充值按钮
        }
    }

    // 充值按钮点击事件
    $('#submit').click(function() {
        if ($("input[name='amount']").val() <= 0) {
            $.NotificationApp.send("警告！", "请输入正确的金额~", "top-center", "rgba(0,0,0,0.2)", "info");
            return false; // 阻止表单提交
        }
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/fk.oo-oo.eu.org/resources/views/hyper/static_pages/user.blade.php ENDPATH**/ ?>