@extends('layouts.admin')

@section('title', '布置作业')

@section('content')
    <div style="padding: 30px; max-width: 600px; margin: 0 auto;">
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 30px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1e293b; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-edit" style="color: #3b82f6;"></i>
                布置作业
            </h2>

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.homework.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        <i class="fa-solid fa-file-text" style="margin-right: 6px;"></i>
                        作业标题 <span style="color: #ef4444;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title"
                        value="{{ old('title') }}"
                        placeholder="请输入作业标题"
                        style="width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: border-color 0.2s, box-shadow 0.2s; outline: none;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                    />
                    @error('title')
                        <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        <i class="fa-solid fa-star" style="margin-right: 6px;"></i>
                        难度选择 <span style="color: #ef4444;">*</span>
                        <span style="font-weight: 400; color: #9ca3af; font-size: 12px; margin-left: 8px;">(最高5分)</span>
                    </label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                id="decreaseBtn"
                                style="position: absolute; left: 0; top: 0; height: 100%; width: 40px; background: #f3f4f6; border: 1px solid #e5e7eb; border-right: none; border-radius: 8px 0 0 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #6b7280; transition: background 0.2s;"
                                onclick="changeDifficulty(-1)"
                            >
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input 
                                type="text" 
                                name="difficulty" 
                                id="difficulty"
                                value="{{ old('difficulty', 3) }}"
                                style="width: 120px; padding: 12px 48px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 16px; font-weight: 600; text-align: center; transition: border-color 0.2s, box-shadow 0.2s; outline: none;"
                                onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'; validateDifficulty()"
                                onchange="validateDifficulty()"
                            />
                            <button 
                                type="button" 
                                id="increaseBtn"
                                style="position: absolute; right: 0; top: 0; height: 100%; width: 40px; background: #f3f4f6; border: 1px solid #e5e7eb; border-left: none; border-radius: 0 8px 8px 0; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #6b7280; transition: background 0.2s;"
                                onclick="changeDifficulty(1)"
                            >
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <div style="display: flex; gap: 4px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i 
                                    class="fa-solid fa-star difficulty-star" 
                                    style="font-size: 20px; cursor: pointer; transition: color 0.2s;"
                                    data-value="{{ $i }}"
                                    onclick="setDifficulty({{ $i }})"
                                ></i>
                            @endfor
                        </div>
                    </div>
                    @error('difficulty')
                        <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        <i class="fa-solid fa-file-archive" style="margin-right: 6px;"></i>
                        作业文件 <span style="color: #ef4444;">*</span>
                        <span style="font-weight: 400; color: #9ca3af; font-size: 12px; margin-left: 8px;">(支持 zip, 7z, rar, tar, gz, bz2)</span>
                    </label>
                    <div 
                        id="fileDropZone"
                        style="border: 2px dashed #d1d5db; border-radius: 12px; padding: 30px; text-align: center; cursor: pointer; transition: border-color 0.2s, background 0.2s;"
                        ondragover="event.preventDefault(); this.style.borderColor='#3b82f6'; this.style.background='rgba(59, 130, 246, 0.05)'"
                        ondragleave="this.style.borderColor='#d1d5db'; this.style.background='transparent'"
                        ondrop="event.preventDefault(); this.style.borderColor='#d1d5db'; this.style.background='transparent'; handleFileDrop(event)"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <i class="fa-solid fa-cloud-upload" style="font-size: 40px; color: #9ca3af; margin-bottom: 12px;"></i>
                        <p style="font-size: 14px; color: #6b7280; margin-bottom: 4px;">点击或拖拽文件到此处上传</p>
                        <p style="font-size: 12px; color: #9ca3af;">支持压缩包格式：.zip, .7z, .rar, .tar, .gz, .bz2</p>
                    </div>
                    <input 
                        type="file" 
                        name="file" 
                        id="fileInput"
                        accept=".zip,.7z,.rar,.tar,.gz,.bz2"
                        style="display: none;"
                        onchange="handleFileSelect(this)"
                    />
                    <div id="filePreview" style="display: none; margin-top: 12px; padding: 12px; background: #f9fafb; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-file-archive" style="font-size: 24px; color: #3b82f6;"></i>
                            <div style="flex: 1;">
                                <p style="font-size: 14px; font-weight: 500; color: #1f2937; margin: 0;">
                                    <span id="fileName"></span>
                                </p>
                                <p style="font-size: 12px; color: #6b7280; margin: 2px 0 0 0;">
                                    <span id="fileSize"></span>
                                </p>
                            </div>
                            <button 
                                type="button"
                                style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px;"
                                onclick="clearFile()"
                            >
                                <i class="fa-solid fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    @error('file')
                        <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px;">
                    <button 
                        type="submit"
                        style="flex: 1; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='#2563eb'"
                        onmouseout="this.style.background='#3b82f6'"
                    >
                        <i class="fa-solid fa-check"></i>
                        提交
                    </button>
                    <button 
                        type="reset"
                        style="padding: 12px 24px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='#e5e7eb'"
                        onmouseout="this.style.background='#f3f4f6'"
                    >
                        <i class="fa-solid fa-rotate-right"></i>
                        重置
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function changeDifficulty(delta) {
            const input = document.getElementById('difficulty');
            let value = parseInt(input.value) || 1;
            value = Math.max(1, Math.min(5, value + delta));
            input.value = value;
            updateStars();
        }

        function setDifficulty(value) {
            document.getElementById('difficulty').value = value;
            updateStars();
        }

        function validateDifficulty() {
            const input = document.getElementById('difficulty');
            let value = parseInt(input.value) || 1;
            value = Math.max(1, Math.min(5, value));
            input.value = value;
            updateStars();
        }

        function updateStars() {
            const value = parseInt(document.getElementById('difficulty').value) || 0;
            const stars = document.querySelectorAll('.difficulty-star');
            stars.forEach((star, index) => {
                if (index < value) {
                    star.style.color = '#fbbf24';
                } else {
                    star.style.color = '#d1d5db';
                }
            });
        }

        function handleFileDrop(event) {
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('fileInput').files = files;
                showFilePreview(files[0]);
            }
        }

        function handleFileSelect(input) {
            if (input.files.length > 0) {
                showFilePreview(input.files[0]);
            }
        }

        function showFilePreview(file) {
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = formatFileSize(file.size);
            document.getElementById('filePreview').style.display = 'block';
            document.getElementById('fileDropZone').style.borderStyle = 'solid';
            document.getElementById('fileDropZone').style.borderColor = '#3b82f6';
        }

        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function clearFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('filePreview').style.display = 'none';
            document.getElementById('fileDropZone').style.borderStyle = 'dashed';
            document.getElementById('fileDropZone').style.borderColor = '#d1d5db';
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateStars();
        });
    </script>
@endsection