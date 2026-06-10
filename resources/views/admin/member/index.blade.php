@extends('layouts.admin')

@section('title', '成员管理')

@section('content')
    <style>
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }
        .search-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            width: 100%;
            max-width: 1200px;
            justify-content: center;
        }
        .search-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .search-input {
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.25s ease;
            min-width: 200px;
        }
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-blue {
            background: #3b82f6;
            color: white;
        }
        .btn-blue:hover {
            background: #2563eb;
        }
        .btn-gray {
            background: #f1f5f9;
            color: #475569;
        }
        .btn-gray:hover {
            background: #e2e8f0;
        }
        .filter-label {
            font-size: 13px;
            color: #64748b;
            margin-right: 8px;
        }
        .filter-select {
            padding: 8px 32px 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            background: #fff;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            min-width: 120px;
            transition: all 0.25s ease;
        }
        .filter-select:hover {
            border-color: #cbd5e1;
        }
        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .table-container {
            overflow-x: hidden;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .data-table thead tr {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .data-table th {
            padding: 16px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            border-bottom: 3px solid #e2e8f0;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
            -webkit-transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -moz-transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -ms-transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -o-transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .data-table tbody tr {
            -webkit-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -moz-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -ms-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            -o-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            background: transparent;
            -webkit-transform: translateX(0);
            -moz-transform: translateX(0);
            -ms-transform: translateX(0);
            -o-transform: translateX(0);
            transform: translateX(0);
        }
        .data-table tbody tr:hover {
            background: #f8fafc;
            border-left-color: #3b82f6;
            -webkit-transform: translateX(2px);
            -moz-transform: translateX(2px);
            -ms-transform: translateX(2px);
            -o-transform: translateX(2px);
            transform: translateX(2px);
        }
        .data-table tbody tr:hover td {
            color: #1e293b;
        }
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        .data-table tbody tr:nth-child(even) {
            background: #fafbfc;
        }
        .data-table tbody tr:nth-child(even):hover {
            background: #f8fafc;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-online {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-offline {
            background: #f3f4f6;
            color: #6b7280;
        }
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }
        .role-admin {
            background: #fef3c7;
            color: #d97706;
        }
        .role-member {
            background: #eff6ff;
            color: #3b82f6;
        }
        .btn-action {
            padding: 7px 14px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 8px;
            position: relative;
            overflow: hidden;
        }
        .btn-action::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .btn-action:hover::before {
            opacity: 1;
        }
        .btn-yellow {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
        }
        .btn-yellow::before {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 50%);
        }
        .btn-yellow:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
        }
        .btn-red {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }
        .btn-red::before {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 50%);
        }
        .btn-red:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        .btn-protected {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.8;
        }
        .empty-state {
            text-align: center;
            padding: 48px;
            color: #94a3b8;
        }
        .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }
        .pagination a, .pagination span {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .pagination a {
            color: #3b82f6;
            border: 1px solid #e2e8f0;
        }
        .pagination a:hover {
            background: #eff6ff;
            border-color: #3b82f6;
        }
        .pagination span.current {
            background: #3b82f6;
            color: white;
            border: 1px solid #3b82f6;
        }
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            transform: scale(0.9) translateY(20px);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }
        .modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa, #3b82f6);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-top: 8px;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: #3b82f6;
            border-radius: 2px;
        }
        .modal-close {
            width: 36px;
            height: 36px;
            background: #f1f5f9;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }
        .modal-close:hover {
            background: #3b82f6;
            color: white;
            transform: rotate(90deg);
        }
        .modal-body {
            margin-bottom: 24px;
        }
        .modal-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .modal-description strong {
            color: #1e293b;
            font-weight: 600;
        }
        .modal-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .modal-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.25s ease;
            background: #f8fafc;
        }
        .modal-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }
        .modal-input::placeholder {
            color: #94a3b8;
        }
        .modal-actions {
            display: flex;
            gap: 12px;
        }
        .modal-btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }
        .modal-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .modal-btn:hover::before {
            opacity: 1;
        }
        .modal-btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }
        .modal-btn-secondary::before {
            background: linear-gradient(135deg, rgba(0,0,0,0.05) 0%, transparent 50%);
        }
        .modal-btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }
        .modal-btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        .modal-btn-primary::before {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
        }
        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
        }
        .modal-btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.4);
        }
        .password-text {
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 13px;
        }
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            z-index: 2000;
            transform: translateX(120%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast.show {
            transform: translateX(0);
        }
        .toast-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .toast-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }
    </style>

    <div class="main-container">
        <div class="search-bar">
            <div class="search-group">
                <input type="text" name="search" placeholder="搜索姓名..." 
                       value="{{ request('search') }}"
                       class="search-input" id="searchInput">
                <button type="button" onclick="submitSearch()" class="btn btn-blue">
                    <i class="fa-solid fa-search"></i> 搜索
                </button>
                <a href="{{ route('admin.member.index') }}" class="btn btn-gray">
                    重置
                </a>
            </div>
        </div>

        <form id="searchForm" method="GET" action="{{ route('admin.member.index') }}">
            <input type="hidden" name="search" id="searchHidden">
        </form>

        <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>创建时间</th>
                    <th>姓名</th>
                    <th>密码</th>
                    <th>权限</th>
                    <th>状态</th>
                    <th>学习时间</th>
                    <th>登录时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $member->Name }}</td>
                    <td class="password-text">{{ $member->Password }}</td>
                    <td>
                        <span class="role-badge {{ $member->Permission == 1 ? 'role-admin' : 'role-member' }}">
                            <i class="fa-solid fa-user"></i> {{ $member->Permission == 1 ? '管理员' : '成员' }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $member->Status == 1 ? 'status-online' : 'status-offline' }}">
                            <i class="fa-solid fa-circle" style="font-size: 8px;"></i> {{ $member->Status == 1 ? '在线' : '离开' }}
                        </span>
                    </td>
                    <td>
                        @php
                            $seconds = $member->LearnTime ?? 0;
                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);
                            $secs = $seconds % 60;
                        @endphp
                        {{ sprintf('%d:%02d:%02d', $hours, $minutes, $secs) }}
                    </td>
                    <td>{{ $member->LoginTime ? $member->LoginTime->format('Y-m-d H:i') : '从未登录' }}</td>
                    <td>
                        <button onclick="openPasswordModal({{ $member->id }}, '{{ $member->Name }}')" 
                                class="btn-action btn-yellow">
                            <i class="fa-solid fa-key"></i> 修改密码
                        </button>
                        @if(strtolower($member->Name) != 'admin')
                        <button onclick="deleteMember({{ $member->id }}, '{{ $member->Name }}')" 
                                class="btn-action btn-red">
                            <i class="fa-solid fa-trash"></i> 删除
                        </button>
                        @else
                        <span class="btn-action btn-protected">
                            <i class="fa-solid fa-shield"></i> 受保护
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($members->isEmpty())
        <div class="empty-state">
            <i class="fa-solid fa-users empty-icon"></i>
            <p>暂无成员数据</p>
        </div>
    @endif

    @if($members->hasPages())
        <div class="pagination">
            {{ $members->links() }}
        </div>
    @endif

    </div>

    <div id="passwordModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">修改密码</h3>
                <button onclick="closePasswordModal()" class="modal-close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-description">
                    为 <strong id="modalMemberName"></strong> 设置新的登录密码。请确保密码安全且便于记忆。
                </p>
                <form id="passwordForm" method="POST">
                    @csrf
                    <label class="modal-label">新密码</label>
                    <input type="text" name="password" id="newPassword" 
                           class="modal-input" placeholder="请输入新密码" required>
                    <div class="modal-actions" style="margin-top: 24px;">
                        <button type="button" onclick="closePasswordModal()" class="modal-btn modal-btn-secondary">
                            <i class="fa-solid fa-xmark"></i> 取消
                        </button>
                        <button type="submit" class="modal-btn modal-btn-primary">
                            <i class="fa-solid fa-check"></i> 确认修改
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script>
        function submitSearch() {
            document.getElementById('searchHidden').value = document.getElementById('searchInput').value;
            document.getElementById('searchForm').submit();
        }

        function openPasswordModal(id, name) {
            document.getElementById('modalMemberName').textContent = name;
            document.getElementById('passwordForm').action = `/root/${id}/password`;
            document.getElementById('passwordModal').classList.add('active');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
            document.getElementById('passwordForm').reset();
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `toast toast-${type}`;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = form.querySelector('.modal-btn-primary');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> 修改中...';
            submitBtn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('密码修改成功！');
                    closePasswordModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast('修改失败，请重试', 'error');
                }
            })
            .catch(error => {
                showToast('网络错误，请重试', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        function deleteMember(id, name) {
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay active';
            modalOverlay.innerHTML = `
                <div class="modal" style="max-width: 420px;">
                    <div class="modal-header">
                        <h3 class="modal-title">确认删除</h3>
                        <button class="modal-close cancel-btn">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                            <div style="width: 48px; height: 48px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-exclamation-triangle" style="color: #dc2626; font-size: 24px;"></i>
                            </div>
                            <div>
                                <p style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">删除成员</p>
                                <p style="color: #64748b; font-size: 14px;">此操作不可撤销，请谨慎操作。</p>
                            </div>
                        </div>
                        <p class="modal-description" style="margin-top: 0;">确定要删除成员 <strong>${name}</strong> 吗？</p>
                        <div class="modal-actions">
                            <button class="modal-btn modal-btn-secondary cancel-btn">
                                <i class="fa-solid fa-xmark"></i> 取消
                            </button>
                            <button class="modal-btn confirm-delete-btn" data-id="${id}" data-name="${name}" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);">
                                <i class="fa-solid fa-trash"></i> 确认删除
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modalOverlay);
            
            const cancelBtns = modalOverlay.querySelectorAll('.cancel-btn');
            const confirmBtn = modalOverlay.querySelector('.confirm-delete-btn');
            
            cancelBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    modalOverlay.remove();
                });
            });
            
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    modalOverlay.remove();
                }
            });
            
            confirmBtn.addEventListener('click', () => {
                confirmDelete(id, name, modalOverlay);
            });
        }

        function confirmDelete(id, name, modal) {
            const btn = modal.querySelector('.modal-btn:last-child');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> 删除中...';
            btn.disabled = true;

            fetch(`/root/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('删除成功！');
                    modal.remove();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast('删除失败，请重试', 'error');
                }
            })
            .catch(error => {
                showToast('网络错误，请重试', 'error');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        document.getElementById('passwordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordModal();
            }
        });
    </script>
@endsection