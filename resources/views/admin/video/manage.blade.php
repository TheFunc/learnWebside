@extends('layouts.admin')

@section('title', '视频管理')

@section('content')
    <div class="video-manage-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="video-table">
            <thead>
                <tr>
                    <th>上传日期</th>
                    <th>封面</th>
                    <th>视频名称</th>
                    <th>课程类型</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videoGroups as $group)
                    <tr>
                        <td>{{ $group->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($group->cover)
                                <img src="{{ asset('storage/' . $group->cover->path) }}" alt="封面" class="cover-image">
                            @else
                                <div class="no-cover">暂无封面</div>
                            @endif
                        </td>
                        <td>{{ $group->title }}</td>
                        <td>{{ $group->type ? $group->type->Type : '未分类' }}</td>
                        <td>
                            <a href="{{ route('admin.video.group', $group->GroupID) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> 编辑
                            </a>
                            <button class="btn-delete" onclick="showDeleteConfirm({{ $group->GroupID }})">
                                <i class="fas fa-trash"></i> 删除
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 删除确认弹窗 -->
    <div id="deleteModal" class="modal">
        <div class="modal-overlay" onclick="hideDeleteConfirm()"></div>
        <div class="modal-wrapper">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title">确认删除</h3>
            <p class="modal-message">确定要删除这个视频组吗？此操作不可恢复，所有相关视频将被永久删除。</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="hideDeleteConfirm()">取消</button>
                <button class="btn-confirm" onclick="confirmDelete()">确认删除</button>
            </div>
        </div>
    </div>

    <style>
        .video-manage-container {
            padding: 0;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .video-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .video-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .video-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .video-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .cover-image {
            width: 200px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .no-cover {
            width: 200px;
            height: 120px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #6c757d;
            font-size: 14px;
        }

        .btn-edit, .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            margin-right: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        /* ===== 现代化确认弹窗 ===== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        /* 背景遮罩 - 毛玻璃效果 */
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            animation: fadeIn 0.25s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* 弹窗主体 */
        .modal-wrapper {
            position: relative;
            z-index: 1001;
            width: 90%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* 图标 */
        .modal-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-icon i {
            font-size: 32px;
            color: #d97706;
        }

        /* 标题 */
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 12px;
        }

        /* 消息 */
        .modal-message {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 24px;
        }

        /* 按钮组 */
        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .modal-actions button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        .btn-confirm:active {
            transform: translateY(0);
        }
    </style>

    <script>
        let deleteGroupID = null;

        function showDeleteConfirm(groupID) {
            deleteGroupID = groupID;
            document.getElementById('deleteModal').classList.add('active');
        }

        function hideDeleteConfirm() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteGroupID = null;
        }

        function confirmDelete() {
            if (!deleteGroupID) return;

            // 先保存 groupID，因为 hideDeleteConfirm() 会把 deleteGroupID 设为 null
            const currentGroupID = deleteGroupID;
            
            // 立即关闭弹窗，给用户即时反馈
            hideDeleteConfirm();
            
            fetch(`/video/group/${currentGroupID}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('删除成功');
                    // 直接从DOM中移除被删除的行，立即反馈给用户
                    const deleteBtn = document.querySelector(`button[onclick="showDeleteConfirm(${currentGroupID})"]`);
                    if (deleteBtn) {
                        const row = deleteBtn.closest('tr');
                        if (row) {
                            row.style.transition = 'opacity 0.3s ease';
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                            }, 300);
                        }
                    }
                } else {
                    showToast('删除失败', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('删除失败', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }
    </script>

    <style>
        /* Toast 提示样式 */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            z-index: 9999;
            opacity: 0;
            transform: translateX(120%);
            transition: all 0.3s ease;
        }

        .toast-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .toast-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
@endsection
