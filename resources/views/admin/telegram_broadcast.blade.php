{{-- Telegram批量群发管理页面 --}}
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Telegram批量群发</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fa fa-send"></i> Telegram批量群发
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            当前系统中共有 <strong>{{ $user_count }}</strong> 个绑定了Telegram的用户
                        </div>
                        
                        <form id="broadcast-form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="message-type">消息类型</label>
                                <select name="message_type" id="message-type" class="form-control" required>
                                    <option value="text">文本消息</option>
                                    <option value="photo">图片消息</option>
                                    <option value="video">视频消息</option>
                                </select>
                            </div>
                            
                            <div class="form-group" id="media-url-group" style="display: none;">
                                <label for="media-url">媒体URL</label>
                                <input type="url" name="media_url" id="media-url" class="form-control" 
                                       placeholder="请输入图片或视频的URL地址">
                                <small class="form-text text-muted">
                                    请输入可直接访问的图片或视频URL地址
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="message-content">消息内容</label>
                                <textarea name="message" id="message-content" class="form-control" rows="8" 
                                          placeholder="请输入要群发的消息内容（支持HTML格式）" required></textarea>
                                <small class="form-text text-muted">
                                    支持HTML标签，如 &lt;b&gt;粗体&lt;/b&gt;、&lt;i&gt;斜体&lt;/i&gt;、&lt;a href="链接"&gt;超链接&lt;/a&gt;
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fa fa-paper-plane"></i> 发送群发消息
                                </button>
                            </div>
                        </form>
                        
                        <div id="result-message" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // 监听消息类型选择变化
        $('#message-type').on('change', function() {
            var messageType = $(this).val();
            if (messageType === 'photo' || messageType === 'video') {
                $('#media-url-group').show();
                $('#media-url').prop('required', true);
            } else {
                $('#media-url-group').hide();
                $('#media-url').prop('required', false);
            }
        });
        
        // 提交表单
        $('#broadcast-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = {
                message_type: $('#message-type').val(),
                message: $('#message-content').val(),
                media_url: $('#media-url').val(),
                _token: $('input[name="_token"]').val()
            };
            
            // 禁用提交按钮
            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 发送中...');
            
            // 发送AJAX请求
            $.ajax({
                url: '{{ admin_url("telegram-broadcast/send") }}',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        showMessage('success', response.message);
                    } else {
                        showMessage('danger', response.message);
                    }
                },
                error: function(xhr) {
                    var errorMsg = '发送失败';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showMessage('danger', errorMsg);
                },
                complete: function() {
                    // 恢复提交按钮
                    submitBtn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> 发送群发消息');
                }
            });
        });
        
        // 显示消息
        function showMessage(type, message) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            $('#result-message')
                .removeClass('alert-success alert-danger')
                .addClass('alert ' + alertClass)
                .html('<i class="fa ' + icon + '"></i> ' + message)
                .show();
            
            // 3秒后自动隐藏
            setTimeout(function() {
                $('#result-message').fadeOut();
            }, 5000);
        }
    });
    </script>
</body>
</html>

