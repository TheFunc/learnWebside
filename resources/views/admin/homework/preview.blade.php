@extends('layouts.admin')

@section('title', '作业预览')

@section('content')
    <div style="padding: 30px; padding-left: 0; padding-right: 0;">
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 30px; padding-left: 0; padding-right: 0;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1e293b; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; padding-left: 30px;">
                <i class="fa-solid fa-eye" style="color: #3b82f6;"></i>
                作业预览
            </h2>

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; margin-left: 30px; margin-right: 30px;">
                    <i class="fa-solid fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($homeworks->isEmpty())
                <div style="text-align: center; padding: 60px 20px; color: #9ca3af;">
                    <i class="fa-solid fa-file-text" style="font-size: 48px; margin-bottom: 16px;"></i>
                    <p style="font-size: 14px;">暂无作业，请先布置作业</p>
                </div>
            @else
                <div style="overflow-x: auto; margin-left: 0; margin-right: 0;">
                    <table style="width: 100%; border-collapse: collapse; margin-left: 0; margin-right: 0;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 12px 16px; text-align: left; font-size: 14px; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0;">
                                    ID
                                </th>
                                <th style="padding: 12px 16px; text-align: left; font-size: 14px; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0;">
                                    <i class="fa-solid fa-clock" style="margin-right: 8px;"></i>上传时间
                                </th>
                                <th style="padding: 12px 16px; text-align: left; font-size: 14px; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0;">
                                    <i class="fa-solid fa-file-text" style="margin-right: 8px;"></i>标题
                                </th>
                                <th style="padding: 12px 16px; text-align: center; font-size: 14px; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0;">
                                    <i class="fa-solid fa-star" style="margin-right: 8px;"></i>难度
                                </th>
                                <th style="padding: 12px 16px; text-align: center; font-size: 14px; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0;">
                                    <i class="fa-solid fa-cog" style="margin-right: 8px;"></i>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($homeworks as $homework)
                                <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 16px; font-size: 14px; color: #6b7280;">
                                        {{ $homework->id }}
                                    </td>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #6b7280;">
                                        {{ $homework->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #1f2937; font-weight: 500;">
                                        {{ $homework->Title }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                            <span style="font-size: 16px; font-weight: 600; color: #3b82f6;">{{ $homework->Difficulty }}</span>
                                            <div style="display: flex; gap: 2px;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i 
                                                        class="fa-solid fa-star" 
                                                        style="font-size: 14px; {{ $i <= $homework->Difficulty ? 'color: #fbbf24;' : 'color: #e5e7eb;' }}"
                                                    ></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                            <button 
                                                type="button"
                                                onclick="openEditModal({{ $homework->id }}, '{{ addslashes($homework->Title) }}')"
                                                style="padding: 8px 12px; background: #fbbf24; color: #78350f; border: none; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; gap: 4px;"
                                                onmouseover="this.style.background='#f59e0b'"
                                                onmouseout="this.style.background='#fbbf24'"
                                            >
                                                <i class="fa-solid fa-pencil"></i>
                                                编辑
                                            </button>
                                            <button 
                                                type="button"
                                                onclick="confirmDelete({{ $homework->id }})"
                                                style="padding: 8px 12px; background: #fee2e2; color: #dc2626; border: none; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; gap: 4px;"
                                                onmouseover="this.style.background='#fecaca'"
                                                onmouseout="this.style.background='#fee2e2'"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                                删除
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div style="background: #fff; border-radius: 12px; padding: 30px; width: 400px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 600; color: #1e293b;">
                    <i class="fa-solid fa-pencil" style="margin-right: 8px; color: #3b82f6;"></i>
                    修改作业名称
                </h3>
                <button 
                    type="button"
                    onclick="closeEditModal()"
                    style="background: none; border: none; font-size: 20px; color: #9ca3af; cursor: pointer; padding: 4px;"
                    onmouseover="this.style.color='#6b7280'"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="editForm" onsubmit="submitEdit(event)">
                <input type="hidden" id="editId" name="id">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        <i class="fa-solid fa-file-text" style="margin-right: 6px;"></i>
                        作业标题 <span style="color: #ef4444;">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="editTitle" 
                        name="title"
                        required
                        style="width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: border-color 0.2s, box-shadow 0.2s; outline: none;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                    />
                </div>
                <div style="display: flex; gap: 12px;">
                    <button 
                        type="button"
                        onclick="closeEditModal()"
                        style="flex: 1; padding: 12px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#e5e7eb'"
                        onmouseout="this.style.background='#f3f4f6'"
                    >
                        取消
                    </button>
                    <button 
                        type="submit"
                        style="flex: 1; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#2563eb'"
                        onmouseout="this.style.background='#3b82f6'"
                    >
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div style="background: #fff; border-radius: 12px; padding: 30px; width: 400px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="width: 64px; height: 64px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-trash" style="font-size: 28px; color: #dc2626;"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">确认删除</h3>
                <p style="font-size: 14px; color: #6b7280;">确定要删除这个作业吗？此操作无法撤销，相关文件也将被删除。</p>
            </div>
            <input type="hidden" id="deleteId">
            <div style="display: flex; gap: 12px;">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    style="flex: 1; padding: 12px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#e5e7eb'"
                    onmouseout="this.style.background='#f3f4f6'"
                >
                    取消
                </button>
                <button 
                    type="button"
                    onclick="submitDelete()"
                    style="flex: 1; padding: 12px; background: #dc2626; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#b91c1c'"
                    onmouseout="this.style.background='#dc2626'"
                >
                    <i class="fa-solid fa-trash" style="margin-right: 4px;"></i>
                    删除
                </button>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, title) {
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = '';
            document.getElementById('editForm').reset();
        }

        function submitEdit(event) {
            event.preventDefault();
            const id = document.getElementById('editId').value;
            const title = document.getElementById('editTitle').value;
            
            fetch(`/homework/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ title: title })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function confirmDelete(id) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        function submitDelete() {
            const id = document.getElementById('deleteId').value;
            
            fetch(`/homework/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('click', function(event) {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });

            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('click', function(event) {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });
        });
    </script>
@endsection