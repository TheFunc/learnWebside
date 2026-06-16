@extends('layouts.admin')

@section('title', '管理荣誉墙')

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
        .table-container {
            overflow-x: auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
            width: 100%;
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
        .data-table td:nth-child(1),
        .data-table th:nth-child(1) {
            text-align: center;
            width: 50px;
            min-width: 50px;
        }
        .data-table td:nth-child(2),
        .data-table th:nth-child(2) {
            width: 180px;
            min-width: 140px;
        }
        .data-table td:nth-child(3),
        .data-table th:nth-child(3) {
            width: 180px;
            min-width: 120px;
        }
        .data-table td:nth-child(4),
        .data-table th:nth-child(4) {
            width: 250px;
            min-width: 150px;
        }
        .data-table td:nth-child(5),
        .data-table th:nth-child(5),
        .data-table td:nth-child(6),
        .data-table th:nth-child(6) {
            width: 150px;
            min-width: 120px;
        }
        .data-table td:nth-child(7),
        .data-table th:nth-child(7) {
            width: 200px;
            min-width: 170px;
        }
        .data-table td {
            padding: 16px 20px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 80px;
        }
        .data-table td:last-child {
            min-width: 170px;
        }
        .data-table tbody tr {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            background: transparent;
            transform: translateX(0);
        }
        .data-table tbody tr:hover {
            background: #f8fafc;
            border-left-color: #3b82f6;
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
        .thumb-img {
            width: 160px;
            max-width: 160px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .title-text {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .desc-text {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #64748b;
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
        .btn-blue-action {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }
        .btn-blue-action::before {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 50%);
        }
        .btn-blue-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
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
            max-width: 520px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            transform: scale(0.9) translateY(20px);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
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
            background: #ef4444;
            color: white;
            transform: rotate(90deg);
        }
        .modal-body {
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.25s ease;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.25s ease;
            resize: vertical;
            min-height: 80px;
            box-sizing: border-box;
        }
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-file {
            width: 100%;
            padding: 8px 0;
            font-size: 14px;
        }
        .current-img {
            max-width: 200px;
            max-height: 120px;
            border-radius: 8px;
            margin-top: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
                <input type="text" name="search" placeholder="搜索标题..." 
                       value="{{ request('search') }}"
                       class="search-input" id="searchInput">
                <button type="button" onclick="submitSearch()" class="btn btn-blue">
                    <i class="fa-solid fa-search"></i> 搜索
                </button>
                <a href="{{ route('admin.competition.manage') }}" class="btn btn-gray">
                    重置
                </a>
            </div>
        </div>

        <form id="searchForm" method="GET" action="{{ route('admin.competition.manage') }}">
            <input type="hidden" name="search" id="searchHidden">
        </form>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>封面</th>
                        <th>标题</th>
                        <th>描述</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($competitions as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->ImgUrl)
                                <img src="{{ $item->ImgUrl }}" alt="封面" class="thumb-img">
                            @else
                                <span class="text-gray-400">无</span>
                            @endif
                        </td>
                        <td>
                            <span class="title-text" title="{{ $item->Title }}">{{ $item->Title }}</span>
                        </td>
                        <td>
                            <span class="desc-text" title="{{ $item->Description }}">{{ $item->Description ?: '无描述' }}</span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $item->updated_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <button class="btn-action btn-blue-action btn-edit"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->Title }}"
                                    data-description="{{ $item->Description ?? '' }}"
                                    data-imgurl="{{ $item->ImgUrl ?? '' }}">
                                <i class="fa-solid fa-pen"></i> 编辑
                            </button>
                            <button class="btn-action btn-red btn-delete"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->Title }}">
                                <i class="fa-solid fa-trash"></i> 删除
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fa-solid fa-trophy empty-icon"></i>
                                <p>暂无比赛数据</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($competitions->hasPages())
            <div class="pagination">
                {{ $competitions->links() }}
            </div>
        @endif
    </div>

    {{-- 编辑弹窗 --}}
    <div id="editModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">编辑比赛</h3>
                <button class="modal-close" onclick="closeEditModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">标题</label>
                        <input type="text" name="Title" id="editTitle" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">描述</label>
                        <textarea name="Description" id="editDescription" class="form-textarea"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">封面图片</label>
                        <input type="file" name="ImgUrl" id="editImgUrl" class="form-file" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">
                        <div id="currentImgContainer" style="display: none;">
                            <p style="font-size:12px;color:#64748b;margin:8px 0 4px;">当前图片：</p>
                            <img id="currentImg" class="current-img">
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeEditModal()">
                        <i class="fa-solid fa-xmark"></i> 取消
                    </button>
                    <button type="submit" class="modal-btn modal-btn-primary">
                        <i class="fa-solid fa-save"></i> 保存修改
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 删除确认弹窗 --}}
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">确认删除</h3>
                <button class="modal-close" onclick="closeDeleteModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-description">
                    您确定要删除比赛 <strong id="deleteTitle"></strong> 吗？<br>
                    此操作不可撤销，关联的图片文件也将被删除。
                </p>
            </div>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-secondary" onclick="closeDeleteModal()">
                    <i class="fa-solid fa-xmark"></i> 取消
                </button>
                <form id="deleteForm" method="POST" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn modal-btn-danger" style="width: 100%;">
                        <i class="fa-solid fa-trash"></i> 确认删除
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast 提示 --}}
    @if(session('success'))
    <div id="toast" class="toast toast-success">
        <i class="fa-solid fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <script>
        // 编辑功能 - 通过 data 属性
        document.addEventListener('click', function(e) {
            const editBtn = e.target.closest('.btn-edit');
            if (editBtn) {
                const id = editBtn.dataset.id;
                const title = editBtn.dataset.title;
                const description = editBtn.dataset.description;
                const imgUrl = editBtn.dataset.imgurl;

                document.getElementById('editTitle').value = title;
                document.getElementById('editDescription').value = description;
                document.getElementById('editForm').action = '/competition/manage/' + id;

                const imgContainer = document.getElementById('currentImgContainer');
                const currentImg = document.getElementById('currentImg');
                if (imgUrl) {
                    imgContainer.style.display = 'block';
                    currentImg.src = imgUrl;
                } else {
                    imgContainer.style.display = 'none';
                }

                document.getElementById('editModal').classList.add('active');
                return;
            }

            const deleteBtn = e.target.closest('.btn-delete');
            if (deleteBtn) {
                const id = deleteBtn.dataset.id;
                const title = deleteBtn.dataset.title;

                document.getElementById('deleteTitle').textContent = title;
                document.getElementById('deleteForm').action = '/competition/manage/' + id;
                document.getElementById('deleteModal').classList.add('active');
                return;
            }
        });

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // 点击遮罩关闭
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // ESC 关闭
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closeDeleteModal();
            }
        });

        // 搜索
        function submitSearch() {
            const value = document.getElementById('searchInput').value.trim();
            document.getElementById('searchHidden').value = value;
            document.getElementById('searchForm').submit();
        }

        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                submitSearch();
            }
        });

        // Toast 自动消失
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(function() {
                toast.classList.add('show');
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 3000);
            }, 100);
        }
    </script>
@endsection