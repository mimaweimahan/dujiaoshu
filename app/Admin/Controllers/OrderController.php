<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Admin\Repositories\Order;
use App\Models\Coupon;
use App\Models\Goods;
use App\Models\Pay;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Order as OrderModel;
use Illuminate\Http\Request;

class OrderController extends AdminController
{


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(['goods', 'coupon', 'pay']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            $grid->column('id')->sortable();
            $grid->column('order_sn')->copyable();
            $grid->column('title');
            $grid->column('type')->using(OrderModel::getTypeMap())
                ->label([
                    OrderModel::AUTOMATIC_DELIVERY => Admin::color()->success(),
                    OrderModel::MANUAL_PROCESSING => Admin::color()->info(),
                ]);
            $grid->column('email')->copyable();
            $grid->column('goods_price');
            $grid->column('buy_amount');
            $grid->column('total_price');
            $grid->column('actual_price');
           $grid->column('pay.pay_name', admin_trans('order.fields.pay_id'))
    ->display(function ($payName) {
        // 这里假设 $this->pay_id 访问的是当前行的pay_id值
        return $this->pay_id <= 0 ? '余额支付' : $payName;
    });

            $grid->column('status')
                ->select(OrderModel::getStatusMap());
            $grid->column('created_at')->sortable();
             $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('order_sn');
                $filter->like('title');
                $filter->equal('status')->select(OrderModel::getStatusMap());
                $filter->equal('email');
                $filter->equal('trade_no');
                $filter->equal('type')->select(OrderModel::getTypeMap());
                $filter->equal('goods_id')->select(Goods::query()->pluck('gd_name', 'id'));
                $filter->equal('coupon_id')->select(Coupon::query()->pluck('coupon', 'id'));
                $filter->equal('pay_id')->select(Pay::query()->pluck('pay_name', 'id'));
                $filter->whereBetween('created_at', function ($q) {
                    $start = $this->input['start'] ?? null;
                    $end = $this->input['end'] ?? null;
                    $q->where('created_at', '>=', $start)
                        ->where('created_at', '<=', $end);
                })->datetime();
                $filter->scope(admin_trans('dujiaoka.trashed'))->onlyTrashed();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $actions->append(new Restore(OrderModel::class));
                } else {
                    // 添加补单按钮
                    // 只对待支付、自动发货、info为空的订单显示补单按钮
                    if ($this->status == OrderModel::STATUS_WAIT_PAY 
                        && $this->type == OrderModel::AUTOMATIC_DELIVERY 
                        && empty($this->info)) {
                        $actions->append('<a href="javascript:void(0);" class="btn btn-xs btn-warning complete-order-btn" data-order-id="'.$this->id.'" data-order-sn="'.$this->order_sn.'" title="手动补单"><i class="fa fa-check-circle"></i> 补单</a>');
                    }
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == admin_trans('dujiaoka.trashed')) {
                    $batch->add(new BatchRestore(OrderModel::class));
                }
            });
            
            // 添加补单功能的JavaScript
            Admin::script($this->getCompleteOrderScript());
        });
    }
    
    /**
     * 获取补单功能的JavaScript代码
     * 用于处理补单按钮的点击事件
     *
     * @return string
     */
    protected function getCompleteOrderScript()
    {
        return <<<'SCRIPT'
// 补单功能 JavaScript
$(document).on('click', '.complete-order-btn', function() {
    var orderId = $(this).data('order-id');
    var orderSn = $(this).data('order-sn');
    var btn = $(this);
    
    // 确认对话框
    if (!confirm('确定要为订单 ' + orderSn + ' 进行补单吗？\n\n补单操作将：\n1. 将订单状态改为"已完成"\n2. 自动发货处理\n3. 此操作不可撤销')) {
        return;
    }
    
    // 禁用按钮
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 处理中...');
    
    // 发送AJAX请求
    $.ajax({
        url: window.location.pathname.split('/').slice(0, 2).join('/') + '/order/complete-order',
        method: 'POST',
        data: {
            order_id: orderId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === true || response.status === 200) {
                Dcat.success(response.message || '补单成功');
                // 刷新页面
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                Dcat.error(response.message || '补单失败');
                // 恢复按钮
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> 补单');
            }
        },
        error: function(xhr) {
            var errorMsg = '补单失败';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Dcat.error(errorMsg);
            // 恢复按钮
            btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> 补单');
        }
    });
});
SCRIPT;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Order(['goods', 'coupon', 'pay']), function (Show $show) {
            $show->field('id');
            $show->field('order_sn');
            $show->field('title');
            $show->field('email');
            $show->field('goods.gd_name', admin_trans('order.fields.goods_id'));
            $show->field('goods_price');
            $show->field('buy_amount');
            $show->field('pay_fee');
            $show->field('coupon.coupon', admin_trans('order.fields.coupon_id'));
            $show->field('coupon_discount_price');
            $show->field('wholesale_discount_price');
            $show->field('total_price');
            $show->field('actual_price');
            $show->field('buy_ip');
            $show->field('info')->unescape()->as(function ($info) {
                return  "<textarea class=\"form-control field_wholesale_price_cnf _normal_\"  rows=\"10\" cols=\"30\">" . $info . "</textarea>";
            });
            $show->field('pay.pay_name', admin_trans('order.fields.pay_id'));
            $show->field('status')->using(OrderModel::getStatusMap());
            $show->field('search_pwd');
            $show->field('trade_no');
            $show->field('type')->using(OrderModel::getTypeMap());
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableEditButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(['goods', 'coupon', 'pay']), function (Form $form) {
            $form->display('id');
            $form->display('order_sn');
            $form->text('title');
            $form->display('goods.gd_name', admin_trans('order.fields.goods_id'));
            $form->display('goods_price');
            $form->display('buy_amount');
            $form->display('pay_fee');
            $form->display('coupon.coupon', admin_trans('order.fields.coupon_id'));
            $form->display('coupon_discount_price');
            $form->display('wholesale_discount_price');
            $form->display('total_price');
            $form->display('actual_price');
            $form->display('email');
            $form->textarea('info');
            $form->display('buy_ip');
            $form->display('pay.pay_name', admin_trans('order.fields.pay_id'));
            $form->radio('status')->options(OrderModel::getStatusMap());
            $form->text('search_pwd');
            $form->display('trade_no');
            $form->radio('type')->options(OrderModel::getTypeMap());
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
    
    /**
     * 手动补单处理方法
     * 将待支付订单改为已完成状态，触发自动发货
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeOrder(Request $request)
    {
        try {
            // 获取订单ID
            $orderId = $request->input('order_id');
            
            // 验证订单ID
            if (!$orderId) {
                return response()->json([
                    'status' => false,
                    'message' => '订单ID不能为空'
                ], 400);
            }
            
            // 查询订单
            $order = OrderModel::find($orderId);
            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => '订单不存在'
                ], 404);
            }
            
            // 验证订单状态（只能补待支付的订单）
            if ($order->status != OrderModel::STATUS_WAIT_PAY) {
                return response()->json([
                    'status' => false,
                    'message' => '只能补待支付状态的订单，当前订单状态：' . OrderModel::getStatusMap()[$order->status]
                ], 400);
            }
            
            // 验证订单类型（只能补自动发货的订单）
            if ($order->type != OrderModel::AUTOMATIC_DELIVERY) {
                return response()->json([
                    'status' => false,
                    'message' => '只能补自动发货类型的订单'
                ], 400);
            }
            
            // 验证订单info是否为空（已发货的不能重复补单）
            if (!empty($order->info)) {
                return response()->json([
                    'status' => false,
                    'message' => '该订单已发货，不能重复补单'
                ], 400);
            }
            
            // 验证库存
            if ($order->goods) {
                $goods = $order->goods;
                $availableStock = \App\Models\Carmis::query()
                    ->where('goods_id', $goods->id)
                    ->where('status', \App\Models\Carmis::STATUS_UNSOLD)
                    ->count();
                    
                if ($availableStock < $order->buy_amount) {
                    return response()->json([
                        'status' => false,
                        'message' => '库存不足，无法补单。需要：' . $order->buy_amount . '，当前可用：' . $availableStock
                    ], 400);
                }
            }
            
            // 更新订单状态为已完成（会触发 setStatusAttribute 方法自动发货）
            $order->status = OrderModel::STATUS_COMPLETED;
            $order->save();
            
            // 记录操作日志
            \Illuminate\Support\Facades\Log::info('管理员手动补单：订单号=' . $order->order_sn . ', 订单ID=' . $orderId);
            
            // 返回成功响应
            return response()->json([
                'status' => true,
                'message' => '补单成功！订单已完成并自动发货'
            ]);
            
        } catch (\Exception $e) {
            // 记录错误日志
            \Illuminate\Support\Facades\Log::error('补单操作失败：' . $e->getMessage(), [
                'order_id' => $request->input('order_id'),
                'trace' => $e->getTraceAsString()
            ]);
            
            // 返回错误响应
            return response()->json([
                'status' => false,
                'message' => '补单失败：' . $e->getMessage()
            ], 500);
        }
    }
}
