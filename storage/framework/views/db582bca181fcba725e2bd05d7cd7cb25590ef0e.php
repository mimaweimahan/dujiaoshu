
<li class="nav-item">
    <a href="javascript:void(0);" id="telegram-broadcast-btn" class="nav-link" title="Telegram批量群发">
        <i class="feather icon-send"></i> 
        <span class="d-none d-md-inline">批量群发</span>
    </a>
</li>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// 等待页面加载完成
document.addEventListener('DOMContentLoaded', function() {
    // 获取按钮元素
    const broadcastBtn = document.getElementById('telegram-broadcast-btn');
    
    // 如果按钮不存在，直接返回
    if (!broadcastBtn) {
        return;
    }
    
    // 点击按钮时显示群发弹窗
    broadcastBtn.addEventListener('click', function() {
        showBroadcastDialog();
    });
    
    /**
     * 显示批量群发对话框
     */
    function showBroadcastDialog() {
        // 使用SweetAlert2显示弹窗
        Swal.fire({
            title: '<strong>Telegram批量群发</strong>',
            html: `
                <div style="text-align: left;">
                    <div class="form-group">
                        <label for="message-type" style="font-weight: bold;">消息类型：</label>
                        <select id="message-type" class="swal2-input" style="width: 100%; display: block;">
                            <option value="text">文本消息</option>
                            <option value="photo">图片消息</option>
                            <option value="video">视频消息</option>
                        </select>
                    </div>
                    <div class="form-group" id="media-url-group" style="display: none;">
                        <label for="media-url" style="font-weight: bold;">媒体URL：</label>
                        <input type="url" id="media-url" class="swal2-input" placeholder="请输入图片或视频的URL地址" style="width: 100%; display: block;">
                        <small style="color: #999;">提示：请输入可直接访问的图片或视频URL地址</small>
                    </div>
                    <div class="form-group">
                        <label for="message-content" style="font-weight: bold;">消息内容：</label>
                        <textarea id="message-content" class="swal2-textarea" placeholder="请输入要群发的消息内容（支持HTML格式）" style="width: 100%; min-height: 150px; display: block;"></textarea>
                        <small style="color: #999;">提示：支持HTML标签，如 &lt;b&gt;粗体&lt;/b&gt;、&lt;i&gt;斜体&lt;/i&gt;、&lt;a href="链接"&gt;超链接&lt;/a&gt;</small>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: '发送群发',
            cancelButtonText: '取消',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            didOpen: () => {
                // 监听消息类型选择变化
                const messageTypeSelect = document.getElementById('message-type');
                const mediaUrlGroup = document.getElementById('media-url-group');
                
                // 当选择图片或视频时，显示媒体URL输入框
                messageTypeSelect.addEventListener('change', function() {
                    if (this.value === 'photo' || this.value === 'video') {
                        mediaUrlGroup.style.display = 'block';
                    } else {
                        mediaUrlGroup.style.display = 'none';
                    }
                });
            },
            preConfirm: () => {
                // 获取表单数据
                const messageType = document.getElementById('message-type').value;
                const messageContent = document.getElementById('message-content').value;
                const mediaUrl = document.getElementById('media-url').value;
                
                // 验证消息内容
                if (!messageContent) {
                    Swal.showValidationMessage('请输入消息内容');
                    return false;
                }
                
                // 如果是图片或视频消息，验证媒体URL
                if ((messageType === 'photo' || messageType === 'video') && !mediaUrl) {
                    Swal.showValidationMessage('请输入媒体URL');
                    return false;
                }
                
                // 返回表单数据
                return {
                    message_type: messageType,
                    message: messageContent,
                    media_url: mediaUrl
                };
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            // 如果用户点击了确认按钮
            if (result.isConfirmed) {
                sendBroadcast(result.value);
            }
        });
    }
    
    /**
     * 发送批量群发请求
     * @param  {Object} data 表单数据
     */
    function sendBroadcast(data) {
        // 显示加载提示
        Swal.fire({
            title: '正在处理',
            html: '正在将消息加入发送队列，请稍候...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // 发送AJAX请求
        fetch('<?php echo e(admin_url("telegram-broadcast/send"), false); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token(), false); ?>',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            // 关闭加载提示
            Swal.close();
            
            // 根据返回结果显示提示
            if (result.status) {
                // 成功
                Swal.fire({
                    icon: 'success',
                    title: '发送成功',
                    html: result.message,
                    confirmButtonText: '确定'
                });
            } else {
                // 失败
                Swal.fire({
                    icon: 'error',
                    title: '发送失败',
                    html: result.message || '未知错误',
                    confirmButtonText: '确定'
                });
            }
        })
        .catch(error => {
            // 关闭加载提示
            Swal.close();
            
            // 显示错误提示
            Swal.fire({
                icon: 'error',
                title: '请求失败',
                html: '网络错误或服务器异常：' + error.message,
                confirmButtonText: '确定'
            });
            
            // 在控制台输出详细错误信息
            console.error('批量群发请求失败:', error);
        });
    }
});
</script>

<style>
/* 调整SweetAlert2弹窗内的表单样式 */
.swal2-input,
.swal2-textarea {
    margin: 8px 0 !important;
    padding: 10px !important;
    font-size: 14px !important;
    border: 1px solid #ddd !important;
    border-radius: 4px !important;
}

.swal2-textarea {
    resize: vertical !important;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.form-group small {
    display: block;
    margin-top: 5px;
    font-size: 12px;
}
</style>

<?php /**PATH /www/wwwroot/session.dpdns.org/resources/views/admin/telegram_broadcast_button.blade.php ENDPATH**/ ?>