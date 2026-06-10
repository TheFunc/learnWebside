@extends('layouts.admin')

@section('title', '外部管理')

@section('content')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 2px;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 15px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-edit:hover {
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            transform: translateY(-1px);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .url-link {
            color: #3b82f6;
            text-decoration: none;
            word-break: break-all;
        }

        .url-link:hover {
            text-decoration: underline;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.2s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #e2e8f0;
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 2px;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #64748b;
            transition: all 0.25s ease;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #334155;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-primary {
            padding: 14px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
        }

        .btn-secondary {
            padding: 14px 32px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

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

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fa-solid fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card">
            <h3 class="card-title">外部链接列表</h3>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>类型</th>
                            <th>名称</th>
                            <th>链接</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($externals as $external)
                            <tr>
                                <td>{{ $external->id }}</td>
                                <td>{{ $external->externalType ? $external->externalType->type : '未分类' }}</td>
                                <td>{{ $external->name }}</td>
                                <td><a href="{{ $external->url }}" target="_blank" class="url-link">{{ $external->url }}</a></td>
                                <td>{{ $external->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-edit" onclick="openEditModal({{ $external->id }}, '{{ $external->type }}', '{{ $external->name }}', '{{ $external->url }}')">
                                            <i class="fa-solid fa-pencil"></i> 编辑
                                        </button>
                                        <button class="btn btn-delete" onclick="showDeleteConfirm({{ $external->id }})">
                                            <i class="fa-solid fa-trash"></i> 删除
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fa-solid fa-link-slash"></i>
                                    <p>暂无外部链接，请先添加</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">编辑外部链接</h3>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">外部类型</label>
                        <select id="editTypeSelect" name="type" required class="form-select">
                            @foreach($types as $type)
                                <option value="{{ $type->type }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">名称</label>
                        <input type="text" id="editNameInput" name="name" required class="form-input" placeholder="请输入外部名称">
                    </div>
                    <div class="form-group">
                        <label class="form-label">链接</label>
                        <input type="url" id="editUrlInput" name="url" required class="form-input" placeholder="请输入外部链接">
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
                            <i class="fa-solid fa-x"></i> 取消
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i> 保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 删除确认弹窗 -->
    <div id="deleteModal" class="delete-modal">
        <div class="delete-modal-overlay" onclick="hideDeleteConfirm()"></div>
        <div class="delete-modal-wrapper">
            <div class="delete-modal-icon">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <h3 class="delete-modal-title">确认删除</h3>
            <p class="delete-modal-message">确定要删除这个外部链接吗？此操作不可恢复。</p>
            <div class="delete-modal-actions">
                <button class="delete-btn-cancel" onclick="hideDeleteConfirm()">取消</button>
                <button class="delete-btn-confirm" onclick="confirmDelete()">确认删除</button>
            </div>
        </div>
    </div>

    <style>
        .delete-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .delete-modal.active {
            display: flex;
        }

        .delete-modal-overlay {
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

        .delete-modal-wrapper {
            position: relative;
            z-index: 2001;
            width: 90%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .delete-modal-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-modal-icon i {
            font-size: 32px;
            color: #d97706;
        }

        .delete-modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 12px;
        }

        .delete-modal-message {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 24px;
        }

        .delete-modal-actions {
            display: flex;
            gap: 12px;
        }

        .delete-modal-actions button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .delete-btn-cancel {
            background: #f1f5f9;
            color: #64748b;
        }

        .delete-btn-cancel:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .delete-btn-confirm {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .delete-btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        .delete-btn-confirm:active {
            transform: translateY(0);
        }
    </style>

    <script>
        let currentEditId = null;
        let deleteExternalId = null;

        function showDeleteConfirm(id) {
            deleteExternalId = id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function hideDeleteConfirm() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteExternalId = null;
        }

        function confirmDelete() {
            if (!deleteExternalId) return;

            const currentId = deleteExternalId;
            hideDeleteConfirm();

            fetch('{{ route('admin.external.destroy', ':id') }}'.replace(':id', currentId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then(response => {
                if (response.ok) {
                    showToast('删除成功');
                    const deleteBtn = document.querySelector(`button[onclick="showDeleteConfirm(${currentId})"]`);
                    if (deleteBtn) {
                        const row = deleteBtn.closest('tr');
                        if (row) {
                            row.style.transition = 'opacity 0.3s ease';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
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

        function openEditModal(id, type, name, url) {
            currentEditId = id;
            document.getElementById('editTypeSelect').value = type;
            document.getElementById('editNameInput').value = name;
            document.getElementById('editUrlInput').value = url;
            document.getElementById('editModal').classList.add('active');
            document.getElementById('editNameInput').focus();
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            currentEditId = null;
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = new URLSearchParams();
            for (const pair of formData.entries()) {
                data.append(pair[0], pair[1]);
            }

            fetch('{{ route('admin.external.update', ':id') }}'.replace(':id', currentEditId), {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data.toString(),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    showToast('更新成功');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('更新失败，请重试', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('更新失败，请重试', 'error');
            });
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('editModal').classList.contains('active')) {
                closeEditModal();
            }
        });

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
@endsection
