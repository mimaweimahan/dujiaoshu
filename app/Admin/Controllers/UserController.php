<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use App\Models\Goods;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     * 用户列表页面构建器
     *
     * @return Grid
     */
    protected function grid()
    {
        // 保存 $this 的引用
        $controller = $this;

        return Grid::make(new User(['invite_user']), function (Grid $grid) use ($controller) {
            // ID列
            $grid->column('id')->sortable();
            // 邮箱列
            $grid->column('email');
            // Telegram ID
            $grid->column('telegram_id');
            // Telegram 用户名（带链接）
            $grid->column('telegram_username')->display(function ($telegram) {
                // 如果有 telegram_username，生成链接
                return $this->telegram_username?"<a href='https://t.me/".$this->telegram_username."' target='_blank'>@".$this->telegram_username."</a>":"";
            });
            // Telegram 昵称
            $grid->column('telegram_nick');
            // 平台
            $grid->column('platform');
            // 余额列
            $grid->column('money', '余额');
            // 等级
            $grid->column('grade');
            // 最后登录IP
            $grid->column('last_ip');
            // 状态
            $grid->column('status');
            // 邀请码
            $grid->column('invite_code');
            // 上级ID
            $grid->column('pid');
            // 邀请者
            $grid->column('invite_user.email', '邀请者');
            // 创建时间
            $grid->column('created_at');

            // ========== 添加余额管理按钮 ==========

            // 行操作按钮 - 为每一行添加余额管理按钮
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                // 获取当前行的数据
                $mail = $this->email?$this->email:$this->telegram_username;
                // 添加余额管理按钮（使用模态框）
                $actions->append('<a href="javascript:void(0);" class="btn btn-xs btn-success manage-money-btn" data-user-id="'.$this->id.'" data-current-money="'.$this->money.'" data-user-email="'.$mail.'" title="管理余额"><i class="fa fa-dollar"></i> 余额</a>');
            });

            // 筛选器配置
            $grid->filter(function (Grid\Filter $filter) {
                // ID精确搜索
                $filter->equal('id');
                // Telegram ID搜索
                $filter->equal('telegram_id');
                // Telegram 用户名搜索
                $filter->equal('telegram_username');
                // Telegram 昵称搜索
                $filter->equal('telegram_nick');
                // 平台筛选
                $filter->equal('platform');
                // 邮箱搜索
                $filter->equal('email');
                // 邀请码搜索
                $filter->equal('invite_code');
                // 上级用户筛选
                $filter->equal('pid')->select(\App\Models\User::query()->pluck('email', 'id'));
                // 备注模糊搜索
                $filter->like('remark');
            });

            // 在页面底部添加余额管理的JavaScript和模态框HTML
            $grid->tools(function (Grid\Tools $tools) use ($controller) {
                // 添加自定义HTML（包含模态框和JavaScript）
                $tools->append($controller->getMoneyManagementModal());
            });
        });
    }

    /**
     * 获取余额管理模态框的HTML和JavaScript
     * 用于在列表页面显示余额管理对话框
     *
     * @return string
     */
    protected function getMoneyManagementModal()
    {
        return <<<'HTML'
<!-- 余额管理模态框 -->
<div class="modal fade" id="money-management-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-dollar"></i> 余额管理
                </h4>
            </div>
            <div class="modal-body">
                <!-- 用户信息 -->
                <div class="alert alert-info">
                    <strong>用户邮箱：</strong><span id="modal-user-email"></span><br>
                    <strong>当前余额：</strong><span id="modal-current-money" style="font-size: 18px; color: #00a65a;"></span> 元
                </div>

                <!-- 操作选择 -->
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">操作类型<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="money-operation-type">
                                <option value="">请选择操作</option>
                                <option value="add">➕ 增加余额</option>
                                <option value="subtract">➖ 减少余额</option>
                                <option value="clear">🗑️ 清空余额</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="money-amount-group" style="display: none;">
                        <label class="col-sm-3 control-label">金额<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="money-amount"
                                   placeholder="请输入金额" step="0.01" min="0.01">
                            <small class="text-muted">请输入要增加或减少的金额（精确到小数点后2位）</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="money-remark" rows="3"
                                      placeholder="请输入操作备注（可选）"></textarea>
                        </div>
                    </div>

                    <!-- 警告提示 -->
                    <div class="alert alert-warning" id="subtract-warning" style="display: none;">
                        <i class="fa fa-exclamation-triangle"></i>
                        <strong>注意：</strong>减少的金额不能大于当前余额！
                    </div>

                    <div class="alert alert-danger" id="clear-warning" style="display: none;">
                        <i class="fa fa-exclamation-circle"></i>
                        <strong>警告：</strong>此操作将清空用户余额，请谨慎操作！
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="confirm-money-operation">
                    <i class="fa fa-check"></i> 确认操作
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// 余额管理功能 JavaScript
(function() {
    'use strict';

    let currentUserId = null;
    let currentMoney = 0;

    // 绑定余额管理按钮点击事件
    $(document).on('click', '.manage-money-btn', function() {
        // 获取用户信息
        currentUserId = $(this).data('user-id');
        currentMoney = parseFloat($(this).data('current-money'));
        const userEmail = $(this).data('user-email');

        // 填充模态框信息
        $('#modal-user-email').text(userEmail);
        $('#modal-current-money').text(currentMoney.toFixed(2));

        // 重置表单
        $('#money-operation-type').val('');
        $('#money-amount').val('');
        $('#money-remark').val('');
        $('#money-amount-group').hide();
        $('#subtract-warning').hide();
        $('#clear-warning').hide();

        // 显示模态框
        $('#money-management-modal').modal('show');
    });

    // 操作类型改变事件
    $('#money-operation-type').on('change', function() {
        const operationType = $(this).val();

        // 隐藏所有警告
        $('#subtract-warning').hide();
        $('#clear-warning').hide();

        if (operationType === 'add' || operationType === 'subtract') {
            // 增加或减少需要输入金额
            $('#money-amount-group').show();
            $('#money-amount').prop('required', true);

            if (operationType === 'subtract') {
                // 显示减少余额的警告
                $('#subtract-warning').show();
                // 设置最大值为当前余额
                $('#money-amount').attr('max', currentMoney);
            } else {
                // 移除最大值限制
                $('#money-amount').removeAttr('max');
            }
        } else if (operationType === 'clear') {
            // 清空余额不需要输入金额
            $('#money-amount-group').hide();
            $('#money-amount').prop('required', false);
            // 显示清空余额的警告
            $('#clear-warning').show();
        } else {
            // 未选择操作
            $('#money-amount-group').hide();
            $('#money-amount').prop('required', false);
        }
    });

    // 确认操作按钮点击事件
    $('#confirm-money-operation').on('click', function() {
        const operationType = $('#money-operation-type').val();
        const amount = parseFloat($('#money-amount').val());
        const remark = $('#money-remark').val();

        // 验证操作类型
        if (!operationType) {
            Dcat.error('请选择操作类型');
            return;
        }

        // 验证金额（增加和减少操作需要）
        if ((operationType === 'add' || operationType === 'subtract') && (!amount || amount <= 0)) {
            Dcat.error('请输入有效的金额（大于0）');
            return;
        }

        // 验证减少操作的金额不能大于当前余额
        if (operationType === 'subtract' && amount > currentMoney) {
            Dcat.error('减少的金额不能大于当前余额（' + currentMoney.toFixed(2) + ' 元）');
            return;
        }

        // 清空余额需要二次确认
        if (operationType === 'clear') {
            if (!confirm('确定要清空用户余额吗？此操作不可恢复！')) {
                return;
            }
        }

        // 禁用按钮，防止重复提交
        $('#confirm-money-operation').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 处理中...');

        // 发送AJAX请求
        $.ajax({
            url: window.location.pathname.split('/').slice(0, 2).join('/') + '/user/manage-money',
            method: 'POST',
            data: {
                user_id: currentUserId,
                operation: operationType,
                amount: amount || 0,
                remark: remark,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === true || response.status === 200) {
                    Dcat.success(response.message || '操作成功');
                    // 关闭模态框
                    $('#money-management-modal').modal('hide');
                    // 刷新页面
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    Dcat.error(response.message || '操作失败');
                    // 恢复按钮
                    $('#confirm-money-operation').prop('disabled', false).html('<i class="fa fa-check"></i> 确认操作');
                }
            },
            error: function(xhr) {
                let errorMsg = '操作失败';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMsg = response.message || errorMsg;
                    } catch (e) {
                        errorMsg = '服务器错误';
                    }
                }
                Dcat.error(errorMsg);
                // 恢复按钮
                $('#confirm-money-operation').prop('disabled', false).html('<i class="fa fa-check"></i> 确认操作');
            }
        });
    });

    // 模态框关闭时重置表单
    $('#money-management-modal').on('hidden.bs.modal', function() {
        $('#money-operation-type').val('');
        $('#money-amount').val('');
        $('#money-remark').val('');
        $('#money-amount-group').hide();
        $('#subtract-warning').hide();
        $('#clear-warning').hide();
        $('#confirm-money-operation').prop('disabled', false).html('<i class="fa fa-check"></i> 确认操作');
    });
})();
</script>

<style>
/* 余额管理按钮样式 */
.manage-money-btn {
    margin-left: 3px;
}

.manage-money-btn:hover {
    opacity: 0.8;
}

/* 模态框内的金额显示 */
#modal-current-money {
    font-weight: bold;
}
</style>
HTML;
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('email');
            $show->field('password');
            $show->field('money');
            $show->field('grade');
            $show->field('last_ip');
            $show->field('last_login');
            $show->field('register_at');
            $show->field('status');
            $show->field('invite_code');
            $show->field('pid');
            $show->field('remark');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->email('email')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'unique:users,email';
                }
            });
            $form->text('password')->value('')->placeholder('留空代表不改变');
            $form->decimal('money')->required()->default(0);

            $form->decimal('grade')->required()->default(0)->help(admin_trans('代理等级默认为0不开启商品批发功能,最高到3级'));
            $form->switch('status');
            $form->text('invite_code');
            $form->select('pid')->options(
                \App\Models\User::query()->pluck('email', 'id')
            )->default(0);
            $form->text('remark');
            $form->saving(function (Form $form) {

                if ($form->isEditing() && $form->password) {
                    $form->password = bcrypt($form->password);
                } elseif ($form->isCreating()) {
                    $form->password = $form->password ? bcrypt($form->password) : bcrypt(123456);
                    if(is_null($form->invite_code)){
                        $form->invite_code = Str::random(8);
                    }
                } else {
                    $form->deleteInput('password');
                }
                if (is_null($form->username)) {
                    $form->username = $form->email;
                }
                if (is_null($form->pid)) {
                    $form->pid = 0;
                }
            });
        });
    }

    /**
     * 余额管理处理方法
     * 处理增加、减少、清空余额的操作
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manageMoney(Request $request)
    {
        try {
            // 获取请求参数
            $userId = $request->input('user_id');
            $operation = $request->input('operation'); // add, subtract, clear
            $amount = $request->input('amount', 0);
            $remark = $request->input('remark', '');

            // 验证用户ID
            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => '用户ID不能为空'
                ], 400);
            }

            // 验证操作类型
            if (!in_array($operation, ['add', 'subtract', 'clear'])) {
                return response()->json([
                    'status' => false,
                    'message' => '无效的操作类型'
                ], 400);
            }

            // 查询用户
            $user = \App\Models\User::find($userId);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => '用户不存在'
                ], 404);
            }

            // 获取当前余额
            $currentMoney = floatval($user->money);
            $newMoney = $currentMoney;
            $operationText = '';

            // 根据操作类型处理余额
            switch ($operation) {
                case 'add':
                    // 增加余额
                    if ($amount <= 0) {
                        return response()->json([
                            'status' => false,
                            'message' => '增加金额必须大于0'
                        ], 400);
                    }
                    $newMoney = bcadd($currentMoney, $amount, 2);
                    $operationText = '增加余额 ' . number_format($amount, 2) . ' 元';
                    break;

                case 'subtract':
                    // 减少余额
                    if ($amount <= 0) {
                        return response()->json([
                            'status' => false,
                            'message' => '减少金额必须大于0'
                        ], 400);
                    }

                    // 验证减少后余额不能小于0
                    if ($amount > $currentMoney) {
                        return response()->json([
                            'status' => false,
                            'message' => '减少金额（' . number_format($amount, 2) . ' 元）不能大于当前余额（' . number_format($currentMoney, 2) . ' 元）'
                        ], 400);
                    }

                    $newMoney = bcsub($currentMoney, $amount, 2);

                    // 再次验证结果不能小于0（保险起见）
                    if ($newMoney < 0) {
                        return response()->json([
                            'status' => false,
                            'message' => '操作失败：余额不能为负数'
                        ], 400);
                    }

                    $operationText = '减少余额 ' . number_format($amount, 2) . ' 元';
                    break;

                case 'clear':
                    // 清空余额
                    $newMoney = 0.00;
                    $operationText = '清空余额（原余额：' . number_format($currentMoney, 2) . ' 元）';
                    break;
            }

            // 更新用户余额
            $user->money = $newMoney;
            $user->save();

            // 记录操作日志（可选）
            $logMessage = "管理员操作用户余额：用户ID={$userId}, 邮箱={$user->email}, 操作={$operationText}";
            if ($remark) {
                $logMessage .= ", 备注={$remark}";
            }
            \Illuminate\Support\Facades\Log::info($logMessage);

            // 返回成功响应
            return response()->json([
                'status' => true,
                'message' => '操作成功！' . $operationText,
                'data' => [
                    'user_id' => $userId,
                    'old_money' => number_format($currentMoney, 2),
                    'new_money' => number_format($newMoney, 2),
                    'operation' => $operation
                ]
            ]);

        } catch (\Exception $e) {
            // 记录错误日志
            \Illuminate\Support\Facades\Log::error('余额管理操作失败：' . $e->getMessage(), [
                'user_id' => $request->input('user_id'),
                'operation' => $request->input('operation'),
                'amount' => $request->input('amount'),
                'trace' => $e->getTraceAsString()
            ]);

            // 返回错误响应
            return response()->json([
                'status' => false,
                'message' => '操作失败：' . $e->getMessage()
            ], 500);
        }
    }
}
