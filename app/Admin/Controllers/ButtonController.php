<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Button;
use App\Models\Lang;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ButtonController extends AdminController
{
    /**
     * Make a grid builder.
     * 列表页面构建器
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Button(), function (Grid $grid) {
            // 设置ID列，可排序
            $grid->column('id')->sortable();
            // 标题列
            $grid->column('title', '标题');
            // 关键词列
            $grid->column('keyword', '关键词');
            // 语言列
            $grid->column('lang', '语言');
            // 内容列，限制显示长度
            $grid->column('content', '内容')->limit(50);
            // 模式列
            $grid->column('mode', '模式')->using([
                'HTML' => 'HTML',
                'MarkDown' => 'MarkDown',
                'MarkDownV2' => 'MarkDownV2',
            ])->label([
                'HTML' => 'primary',
                'MarkDown' => 'success',
                'MarkDownV2' => 'info',
            ]);
            // 是否展示URL列
            $grid->column('is_show', '展示URL')->switch();
            // 按钮JSON列，显示按钮数量
            $grid->column('button_json', '按钮配置')->display(function ($value) {
                // 解析JSON获取按钮数量
                $buttons = json_decode($value, true);
                if (is_array($buttons)) {
                    $count = count($buttons);
                    return "<span class='label label-success'>$count 行按钮</span>";
                }
                return "<span class='label label-default'>无按钮</span>";
            });
            // 创建时间列
            $grid->column('created_at', '创建时间');
            // 更新时间列，可排序
            $grid->column('updated_at', '更新时间')->sortable();

            // 筛选器配置
            $grid->filter(function (Grid\Filter $filter) {
                // ID精确搜索
                $filter->equal('id');
                // 标题模糊搜索
                $filter->like('title', '标题');
                // 关键词模糊搜索
                $filter->like('keyword', '关键词');
                // 语言筛选
                $filter->equal('lang', '语言');
            });
        });
    }

    /**
     * Make a show builder.
     * 详情页面构建器
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Button(), function (Show $show) {
            // 显示ID
            $show->field('id');
            // 显示标题
            $show->field('title', '标题');
            // 显示关键词
            $show->field('keyword', '关键词');
            // 显示语言
            $show->field('lang', '语言');
            // 显示内容
            $show->field('content', '内容');
            // 显示模式
            $show->field('mode', '模式');
            // 显示是否展示URL
            $show->field('is_show', '展示URL');
            // 显示按钮JSON，格式化展示
            $show->field('button_json', '按钮配置')->json();
            // 显示创建时间
            $show->field('created_at', '创建时间');
            // 显示更新时间
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * Make a form builder.
     * 表单构建器 - 包含可视化按钮编辑器
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Button(), function (Form $form) {
            // 显示ID（仅编辑时）
            $form->display('id');

            // 标题输入框（必填）
            $form->text('title', '标题')
                ->required()
                ->help('按钮组的标题，用于识别这组按钮的用途');

            // 关键词输入框（必填）
            $form->text('keyword', '关键词')
                ->required()
                ->help('用于程序中调用这组按钮，例如: start, shoplist, my 等');

            // 语言选择（必填）
            $langs = Lang::query()->pluck('title', 'code')->toArray();
            if (empty($langs)) {
                // 如果没有语言数据，使用默认选项
                $langs = [
                    'zh-CN' => '简体中文',
                    'zh-TW' => '繁体中文',
                    'en' => 'English',
                ];
            }
            $form->select('lang', '语言')
                ->options($langs)
                ->default('zh-CN')
                ->required()
                ->help('此按钮组适用的语言');

            // 内容输入框（必填）
            $form->textarea('content', '消息内容')
                ->rows(5)
                ->required()
                ->help('发送给用户的文本内容，支持变量替换，如: {username}, {amount} 等');

            // 模式选择
            $form->radio('mode', '消息模式')
                ->options([
                    'HTML' => 'HTML',
                    'MarkDown' => 'MarkDown',
                    'MarkDownV2' => 'MarkDownV2',
                ])
                ->default('HTML')
                ->help('选择消息文本的格式化方式');

            // 是否展示URL
            $form->switch('is_show', '展示URL预览')
                ->default(0)
                ->help('是否在消息中展示URL的预览');

            // 分隔线
            $form->divider();

            // ========== 可视化按钮编辑器 ==========
            $form->html('<h4 style="margin-top: 20px; margin-bottom: 15px;">
                <i class="fa fa-keyboard-o"></i> Telegram 按钮可视化编辑器
            </h4>');

            // 按钮类型选择
            $form->radio('button_type', '按钮类型')
                ->options([
                    'inline' => 'Inline Keyboard（内联按钮 - 显示在消息下方）',
                    'reply' => 'Reply Keyboard（回复键盘 - 替换输入框上方的键盘）',
                ])
                ->default('inline')
                ->help('内联按钮：带有callback_data或url的交互按钮；回复键盘：直接发送文本的键盘按钮')
                ->attribute('id', 'button_type_selector');

            // 可视化按钮编辑器容器
            $form->html($this->buildButtonEditorHtml());

            // 隐藏的JSON字段（用于存储最终的按钮JSON）
            $form->textarea('button_json', '按钮JSON配置')
                ->rows(10)
                ->help('按钮的JSON配置，可以通过上方的可视化编辑器生成，也可以手动编辑')
                ->attribute('id', 'button_json_field');

            // 显示创建时间（仅编辑时）
            $form->display('created_at', '创建时间');
            // 显示更新时间（仅编辑时）
            $form->display('updated_at', '更新时间');

            // 保存前处理
            $form->saving(function (Form $form) {
                // 确保 button_json 是有效的 JSON
                if ($form->button_json) {
                    $json = json_decode($form->button_json, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return $form->response()->error('按钮JSON格式错误: ' . json_last_error_msg());
                    }
                }
            });
        });
    }

    /**
     * 构建按钮编辑器的HTML和JavaScript
     * 创建可视化的按钮编辑界面
     *
     * @return string
     */
    protected function buildButtonEditorHtml()
    {
        return <<<HTML
<div class="button-visual-editor" style="margin-bottom: 20px;">
    <div class="button-editor-container" style="border: 1px solid #d2d6de; border-radius: 3px; padding: 15px; background: #f7f7f7;">

        <!-- 按钮编辑区域 -->
        <div id="button-rows-container" style="min-height: 100px; background: white; padding: 10px; border-radius: 3px; margin-bottom: 15px;">
            <!-- 按钮行将动态添加到这里 -->
        </div>

        <!-- 操作按钮区 -->
        <div class="button-editor-actions" style="text-align: center; margin-top: 15px;">
            <button type="button" class="btn btn-primary btn-sm" id="add-button-row">
                <i class="fa fa-plus"></i> 添加新行
            </button>
            <button type="button" class="btn btn-success btn-sm" id="preview-buttons">
                <i class="fa fa-eye"></i> 预览效果
            </button>
            <button type="button" class="btn btn-warning btn-sm" id="import-json">
                <i class="fa fa-upload"></i> 从JSON导入
            </button>
            <button type="button" class="btn btn-danger btn-sm" id="clear-all-buttons">
                <i class="fa fa-trash"></i> 清空所有
            </button>
        </div>

        <!-- 预览区域 -->
        <div id="button-preview-area" style="margin-top: 20px; padding: 15px; background: white; border-radius: 3px; display: none;">
            <h5><i class="fa fa-mobile"></i> 预览效果：</h5>
            <div id="button-preview-content" style="padding: 10px; border: 1px solid #ddd; border-radius: 3px; background: #e8f5e9;">
                <!-- 预览内容将显示在这里 -->
            </div>
        </div>
    </div>
</div>

<style>
/* 按钮行样式 */
.button-row {
    background: #fff;
    border: 1px dashed #ccc;
    border-radius: 3px;
    padding: 10px;
    margin-bottom: 10px;
    position: relative;
}

.button-row:hover {
    border-color: #3c8dbc;
    box-shadow: 0 0 5px rgba(60, 141, 188, 0.3);
}

/* 按钮项样式 */
.button-item {
    display: inline-block;
    background: #3c8dbc;
    color: white;
    padding: 8px 15px;
    margin: 5px;
    border-radius: 3px;
    position: relative;
    cursor: move;
}

.button-item:hover {
    background: #357ca5;
}

/* 按钮项的删除按钮 */
.button-item .remove-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 20px;
    height: 20px;
    background: #dd4b39;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    cursor: pointer;
    font-size: 12px;
}

.button-item .remove-btn:hover {
    background: #c23321;
}

/* 行操作按钮 */
.row-actions {
    text-align: right;
    margin-top: 5px;
}

/* 预览区按钮样式 */
.preview-button {
    display: inline-block;
    background: #0088cc;
    color: white;
    padding: 8px 15px;
    margin: 5px;
    border-radius: 3px;
    text-decoration: none;
}

.preview-button:hover {
    background: #006699;
    color: white;
}

/* 表单项样式 */
.form-inline-group {
    margin-bottom: 10px;
}

.form-inline-group input, .form-inline-group select {
    margin-right: 5px;
}
</style>

<script>
// Telegram 按钮可视化编辑器 JavaScript
(function() {
    'use strict';

    // 按钮数据存储
    let buttonRows = [];
    let currentButtonType = 'inline';

    // 初始化编辑器
    function initEditor() {
        // 绑定按钮类型切换事件
        $('#button_type_selector input').on('change', function() {
            const newType = $(this).val();

            // 如果有按钮且类型发生变化，提示用户
            if (buttonRows.length > 0 && newType !== currentButtonType) {
                if (confirm('切换按钮类型会清理现有按钮的额外字段（如 callback_data 或 url），确定要切换吗？')) {
                    currentButtonType = newType;
                    // 清理所有按钮的额外字段
                    cleanButtonsForType(newType);
                    renderButtonRows();
                    updateButtonTypeHints();
                } else {
                    // 用户取消，恢复原选项
                    $(this).prop('checked', false);
                    $('#button_type_selector input[value="' + currentButtonType + '"]').prop('checked', true);
                }
            } else {
                currentButtonType = newType;
                updateButtonTypeHints();
            }
        });

        // 绑定添加行按钮
        $('#add-button-row').on('click', addNewButtonRow);

        // 绑定预览按钮
        $('#preview-buttons').on('click', previewButtons);

        // 绑定导入JSON按钮
        $('#import-json').on('click', importFromJson);

        // 绑定清空按钮
        $('#clear-all-buttons').on('click', clearAllButtons);

        // 监听button_json字段变化，自动导入
        $('#button_json_field').on('blur', function() {
            if ($(this).val().trim()) {
                tryAutoImport();
            }
        });

        // 页面加载时，如果有JSON数据则自动导入
        setTimeout(function() {
            tryAutoImport();
        }, 500);
    }

    // 尝试自动导入JSON
    function tryAutoImport() {
        const jsonStr = $('#button_json_field').val();
        if (jsonStr && jsonStr.trim()) {
            try {
                const data = JSON.parse(jsonStr);
                if (Array.isArray(data) && data.length > 0) {
                    buttonRows = data;
                    renderButtonRows();
                }
            } catch (e) {
                // 忽略解析错误
            }
        }
    }

    // 添加新的按钮行
    function addNewButtonRow() {
        const row = [];
        buttonRows.push(row);
        renderButtonRows();
        // 自动添加一个按钮
        addButtonToRow(buttonRows.length - 1);
    }

    // 添加按钮到指定行
    function addButtonToRow(rowIndex) {
        // 根据按钮类型创建不同的默认按钮
        let button;
        if (currentButtonType === 'inline') {
            // Inline Keyboard 按钮需要 callback_data 或 url
            button = {
                text: '新按钮',
                callback_data: 'callback_data'
            };
        } else {
            // Reply Keyboard 按钮只需要 text
            button = {
                text: '新按钮'
            };
        }
        buttonRows[rowIndex].push(button);
        renderButtonRows();
    }

    // 渲染所有按钮行
    function renderButtonRows() {
        const container = $('#button-rows-container');
        container.empty();

        if (buttonRows.length === 0) {
            container.html('<div style="text-align: center; color: #999; padding: 30px;">点击下方"添加新行"按钮开始创建 Telegram 按钮</div>');
            return;
        }

        buttonRows.forEach(function(row, rowIndex) {
            const rowDiv = $('<div class="button-row"></div>');
            const rowId = 'row-' + rowIndex;
            rowDiv.attr('id', rowId);

            // 行标题
            const rowHeader = $('<div style="margin-bottom: 10px; color: #666; font-weight: bold;">第 ' + (rowIndex + 1) + ' 行</div>');
            rowDiv.append(rowHeader);

            // 按钮容器
            const buttonsContainer = $('<div class="buttons-container"></div>');

            row.forEach(function(button, btnIndex) {
                const btnDiv = $('<div class="button-item"></div>');
                btnDiv.attr('data-row', rowIndex);
                btnDiv.attr('data-btn', btnIndex);

                // 显示按钮文字，如果是链接按钮则添加图标
                let btnText = button.text || '未命名按钮';
                btnDiv.text(btnText);

                // 如果是链接按钮，添加外链图标
                if (button.url) {
                    btnDiv.append(' <i class="fa fa-external-link" style="font-size: 10px;"></i>');
                }

                // 删除按钮
                const removeBtn = $('<span class="remove-btn" title="删除此按钮">×</span>');
                removeBtn.on('click', function(e) {
                    e.stopPropagation(); // 阻止事件冒泡
                    removeButton(rowIndex, btnIndex);
                });
                btnDiv.append(removeBtn);

                // 点击编辑按钮
                btnDiv.on('click', function(e) {
                    if (!$(e.target).hasClass('remove-btn') && !$(e.target).parent().hasClass('remove-btn')) {
                        editButton(rowIndex, btnIndex);
                    }
                });

                // 添加标题提示
                btnDiv.attr('title', '点击编辑按钮');

                buttonsContainer.append(btnDiv);
            });

            rowDiv.append(buttonsContainer);

            // 行操作按钮
            const rowActions = $('<div class="row-actions"></div>');
            const addBtn = $('<button type="button" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> 添加按钮</button>');
            addBtn.on('click', function() {
                addButtonToRow(rowIndex);
            });
            const removeRowBtn = $('<button type="button" class="btn btn-xs btn-danger" style="margin-left: 5px;"><i class="fa fa-trash"></i> 删除此行</button>');
            removeRowBtn.on('click', function() {
                removeButtonRow(rowIndex);
            });
            rowActions.append(addBtn);
            rowActions.append(removeRowBtn);
            rowDiv.append(rowActions);

            container.append(rowDiv);
        });

        // 更新JSON字段
        updateJsonField();
    }

    // 编辑按钮
    function editButton(rowIndex, btnIndex) {
        const button = buttonRows[rowIndex][btnIndex];

        // 构建编辑表单HTML
        let formHtml = '<div class="form-horizontal" style="padding: 15px;">';
        formHtml += '<div class="form-group">';
        formHtml += '<label class="col-sm-3 control-label">按钮文字<span style="color:red;">*</span></label>';
        formHtml += '<div class="col-sm-9"><input type="text" class="form-control" id="edit-btn-text" value="' + (button.text || '') + '" placeholder="请输入按钮显示的文字"></div>';
        formHtml += '</div>';

        // 如果是 Inline Keyboard，显示额外的字段
        if (currentButtonType === 'inline') {
            formHtml += '<div class="form-group">';
            formHtml += '<label class="col-sm-3 control-label">回调数据</label>';
            formHtml += '<div class="col-sm-9"><input type="text" class="form-control" id="edit-btn-callback" value="' + (button.callback_data || '') + '" placeholder="例如: shoplist, goods_123"></div>';
            formHtml += '<div class="col-sm-9 col-sm-offset-3"><small class="text-muted">用于按钮点击后的回调处理</small></div>';
            formHtml += '</div>';

            formHtml += '<div class="form-group">';
            formHtml += '<label class="col-sm-3 control-label">URL链接</label>';
            formHtml += '<div class="col-sm-9"><input type="text" class="form-control" id="edit-btn-url" value="' + (button.url || '') + '" placeholder="https://example.com"></div>';
            formHtml += '<div class="col-sm-9 col-sm-offset-3"><small class="text-muted">可选，如果设置URL则按钮变为链接按钮（会忽略回调数据）</small></div>';
            formHtml += '</div>';
        }

        formHtml += '</div>';

        // 创建模态对话框
        const modalId = 'edit-button-modal-' + Date.now();
        const saveButtonId = 'save-button-edit-' + Date.now();

        // 构建模态框HTML（使用字符串拼接避免PHP解析问题）
        let modalHtml = '<div class="modal fade" id="' + modalId + '" tabindex="-1" role="dialog">';
        modalHtml += '<div class="modal-dialog" role="document">';
        modalHtml += '<div class="modal-content">';
        modalHtml += '<div class="modal-header">';
        modalHtml += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modalHtml += '<span aria-hidden="true">&times;</span>';
        modalHtml += '</button>';
        modalHtml += '<h4 class="modal-title">编辑按钮 - 第 ' + (rowIndex + 1) + ' 行，第 ' + (btnIndex + 1) + ' 个按钮</h4>';
        modalHtml += '</div>';
        modalHtml += '<div class="modal-body">' + formHtml + '</div>';
        modalHtml += '<div class="modal-footer">';
        modalHtml += '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
        modalHtml += '<button type="button" class="btn btn-primary" id="' + saveButtonId + '">保存</button>';
        modalHtml += '</div>';
        modalHtml += '</div>';
        modalHtml += '</div>';
        modalHtml += '</div>';

        // 移除可能存在的旧模态框
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');

        // 添加模态框到页面
        $('body').append(modalHtml);

        // 显示模态框
        $('#' + modalId).modal('show');

        // 绑定保存按钮事件
        $('#' + saveButtonId).off('click').on('click', function() {
            // 获取表单数据
            const newText = $('#edit-btn-text').val().trim();

            // 验证按钮文字
            if (!newText) {
                alert('按钮文字不能为空！');
                return;
            }

            // 更新按钮数据
            button.text = newText;

            // 如果是 Inline Keyboard，处理额外字段
            if (currentButtonType === 'inline') {
                const callbackData = $('#edit-btn-callback').val().trim();
                const url = $('#edit-btn-url').val().trim();

                if (url) {
                    // 如果有URL，删除callback_data，添加url
                    delete button.callback_data;
                    button.url = url;
                } else {
                    // 如果没有URL，删除url，添加callback_data
                    delete button.url;
                    button.callback_data = callbackData || 'callback_data';
                }
            } else {
                // Reply Keyboard 只需要 text 字段
                // 删除可能存在的其他字段
                delete button.callback_data;
                delete button.url;
            }

            // 关闭模态框
            $('#' + modalId).modal('hide');

            // 重新渲染按钮
            renderButtonRows();

            // 显示成功提示
            if (typeof Dcat !== 'undefined' && Dcat.success) {
                Dcat.success('按钮已更新');
            }
        });

        // 模态框关闭后移除DOM元素
        $('#' + modalId).on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }

    // 删除按钮
    function removeButton(rowIndex, btnIndex) {
        buttonRows[rowIndex].splice(btnIndex, 1);
        // 如果行为空，删除整行
        if (buttonRows[rowIndex].length === 0) {
            buttonRows.splice(rowIndex, 1);
        }
        renderButtonRows();
    }

    // 删除按钮行
    function removeButtonRow(rowIndex) {
        buttonRows.splice(rowIndex, 1);
        renderButtonRows();
    }

    // 更新JSON字段
    function updateJsonField() {
        const json = JSON.stringify(buttonRows, null, 2);
        $('#button_json_field').val(json);
    }

    // 预览按钮
    function previewButtons() {
        const previewArea = $('#button-preview-area');
        const previewContent = $('#button-preview-content');

        previewContent.empty();

        if (buttonRows.length === 0) {
            previewContent.html('<div style="text-align: center; color: #999;">暂无按钮</div>');
            previewArea.show();
            return;
        }

        buttonRows.forEach(function(row, rowIndex) {
            const rowDiv = $('<div style="margin-bottom: 5px;"></div>');

            row.forEach(function(button) {
                const btnSpan = $('<span class="preview-button"></span>');
                btnSpan.text(button.text);

                if (button.url) {
                    btnSpan.append(' <i class="fa fa-external-link" style="font-size: 10px;"></i>');
                }

                rowDiv.append(btnSpan);
            });

            previewContent.append(rowDiv);
        });

        previewArea.show();
    }

    // 从JSON导入
    function importFromJson() {
        const jsonStr = $('#button_json_field').val();

        if (!jsonStr || !jsonStr.trim()) {
            Dcat.error('请先在下方的"按钮JSON配置"字段中输入或粘贴JSON数据');
            return;
        }

        try {
            const data = JSON.parse(jsonStr);

            if (!Array.isArray(data)) {
                Dcat.error('JSON格式错误：根元素必须是数组');
                return;
            }

            buttonRows = data;
            renderButtonRows();
            Dcat.success('导入成功！');
        } catch (e) {
            Dcat.error('JSON解析失败：' + e.message);
        }
    }

    // 清空所有按钮
    function clearAllButtons() {
        if (confirm('确定要清空所有按钮吗？')) {
            buttonRows = [];
            renderButtonRows();
            Dcat.success('已清空');
        }
    }

    // 根据按钮类型清理按钮字段
    function cleanButtonsForType(type) {
        buttonRows.forEach(function(row) {
            row.forEach(function(button) {
                if (type === 'reply') {
                    // Reply Keyboard 只需要 text 字段
                    delete button.callback_data;
                    delete button.url;
                } else {
                    // Inline Keyboard 需要 callback_data 或 url
                    if (!button.callback_data && !button.url) {
                        button.callback_data = 'callback_data';
                    }
                }
            });
        });
    }

    // 更新按钮类型提示
    function updateButtonTypeHints() {
        // 显示当前按钮类型的提示信息
        const hintText = currentButtonType === 'inline'
            ? '内联按钮：显示在消息下方，支持回调和链接'
            : '回复键盘：替换输入框键盘，只需设置按钮文字';

        // 可以在编辑器上方显示提示（如果需要的话）
        console.log('当前按钮类型：' + hintText);
    }

    // 页面加载完成后初始化
    $(document).ready(function() {
        initEditor();
    });
})();
</script>
HTML;
    }
}

