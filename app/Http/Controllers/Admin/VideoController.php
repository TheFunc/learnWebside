<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoType;
use App\Models\VideoInfo;
use App\Models\VideoCover;

class VideoController extends Controller
{
    public function course()
    {
        $types = VideoType::orderBy('created_at', 'desc')->get();
        return view('admin.video.course', compact('types'));
    }

    public function manage()
    {
        // 获取所有视频组（按GroupID分组）
        $videoGroups = VideoInfo::select('GroupID', 'title', 'TypeID', 'created_at')
            ->with(['cover', 'type'])
            ->groupBy('GroupID', 'title', 'TypeID', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.video.manage', compact('videoGroups'));
    }

    public function create()
    {
        $types = VideoType::all();
        $groupID = VideoInfo::max('GroupID') + 1;
        return view('admin.video.create', compact('types', 'groupID'));
    }

    public function uploadCover(Request $request)
    {
        try {
            $request->validate([
                'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'groupID' => 'required|integer',
                'title' => 'nullable|string|max:255',
            ]);

            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 根据标题创建文件夹
            $folderName = $request->title ? $this->sanitizeFolderName($request->title) : $request->groupID;
            
            // 确保目录存在
            $storagePath = storage_path('app/public/covers/' . $folderName);
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            $path = 'covers/' . $folderName . '/' . $filename;
            $file->move($storagePath, $filename);

            VideoCover::updateOrCreate(
                ['GroupID' => $request->groupID],
                ['path' => $path]
            );

            return response()->json([
                'success' => true,
                'path' => $path,
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            \Log::error('上传封面失败: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '上传失败: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function uploadVideo(Request $request)
    {
        try {
            $request->validate([
                'video' => 'required|mimes:mp4,avi,mov,wmv,flv|max:524288000',
                'groupID' => 'required|integer',
                'title' => 'nullable|string|max:255',
            ]);

            $file = $request->file('video');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 根据标题创建文件夹
            $folderName = $request->title ? $this->sanitizeFolderName($request->title) : $request->groupID;
            
            // 确保目录存在
            $storagePath = storage_path('app/public/videos/' . $folderName);
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            $path = 'videos/' . $folderName . '/' . $filename;
            $file->move($storagePath, $filename);

            return response()->json([
                'success' => true,
                'path' => $path,
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            \Log::error('上传视频失败: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '上传失败: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveVideoInfo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'typeID' => 'required|integer',
            'description' => 'nullable|string',
            'groupID' => 'required|integer',
            'videos' => 'required|array',
            'videos.*.path' => 'required|string',
            'videos.*.filename' => 'required|string',
        ]);

        foreach ($request->videos as $video) {
            VideoInfo::create([
                'title' => $request->title,
                'GroupID' => $request->groupID,
                'TypeID' => $request->typeID,
                'Path' => $video['path'],
                'Description' => $request->description,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => '视频信息保存成功',
        ]);
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'Type' => 'required|string|max:255|unique:video_types',
        ]);

        VideoType::create([
            'TypeID' => VideoType::max('TypeID') + 1,
            'Type' => $request->Type,
        ]);

        return redirect()->back()->with('success', '视频类型创建成功');
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'Type' => 'required|string|max:255|unique:video_types,Type,' . $id,
        ]);

        $type = VideoType::findOrFail($id);
        $type->Type = $request->Type;
        $type->save();

        return response()->json(['success' => true, 'message' => '视频类型更新成功']);
    }

    public function destroyType($id)
    {
        $type = VideoType::findOrFail($id);
        $type->delete();

        return redirect()->back()->with('success', '视频类型删除成功');
    }

    public function getGroupVideos($groupID)
    {
        $videos = VideoInfo::where('GroupID', $groupID)->get();
        $cover = VideoCover::where('GroupID', $groupID)->first();
        $videoGroup = VideoInfo::where('GroupID', $groupID)->with('type')->first();

        return view('admin.video.group', compact('videos', 'cover', 'videoGroup', 'groupID'));
    }

    public function destroyGroup($groupID)
    {
        // 先获取视频标题（用于删除文件夹），必须在删除之前获取
        $videoGroup = VideoInfo::where('GroupID', $groupID)->first();
        $folderName = $videoGroup ? $this->sanitizeFolderName($videoGroup->title) : null;

        // 获取封面并删除本地文件
        $cover = VideoCover::where('GroupID', $groupID)->first();
        if ($cover) {
            $coverPath = storage_path('app/public/' . $cover->path);
            if (file_exists($coverPath)) {
                unlink($coverPath);
            }
            $cover->delete();
        }

        // 获取视频并删除本地文件
        $videos = VideoInfo::where('GroupID', $groupID)->get();
        foreach ($videos as $video) {
            $videoPath = storage_path('app/public/' . $video->Path);
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
            $video->delete();
        }

        // 删除空文件夹（如果存在）
        if ($folderName) {
            $folderPath = storage_path('app/public/videos/' . $folderName);
            if (is_dir($folderPath) && count(scandir($folderPath)) == 2) {
                rmdir($folderPath);
            }
            $coverFolderPath = storage_path('app/public/covers/' . $folderName);
            if (is_dir($coverFolderPath) && count(scandir($coverFolderPath)) == 2) {
                rmdir($coverFolderPath);
            }
        }

        return response()->json([
            'success' => true,
            'message' => '视频组删除成功',
        ]);
    }

    private function sanitizeFolderName($name)
    {
        // 移除特殊字符，只保留字母、数字、中文和下划线
        $name = preg_replace('/[^\w\u4e00-\u9fa5\-]/u', '_', $name);
        // 移除连续的下划线
        $name = preg_replace('/_+/', '_', $name);
        // 移除首尾下划线
        $name = trim($name, '_');
        // 限制长度
        if (strlen($name) > 50) {
            $name = substr($name, 0, 50);
        }
        return $name ?: 'unknown';
    }

    public function streamVideo($path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, '视频文件不存在');
        }

        $fileSize = filesize($fullPath);
        $mimeType = mime_content_type($fullPath) ?: 'video/mp4';

        $headers = [
            'Content-Type' => $mimeType,
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $fileSize,
            'Cache-Control' => 'public, max-age=86400',
        ];

        // 检查是否有 Range 请求
        $range = request()->header('Range');

        if ($range) {
            // 解析 Range 头，例如: bytes=0-1023
            $range = str_replace('bytes=', '', $range);
            $range = explode('-', $range);

            $start = isset($range[0]) && $range[0] !== '' ? (int) $range[0] : 0;
            $end = isset($range[1]) && $range[1] !== '' ? (int) $range[1] : $fileSize - 1;

            // 验证范围
            if ($start > $end || $start >= $fileSize) {
                return response('Range Not Satisfiable', 416, [
                    'Content-Range' => 'bytes */' . $fileSize,
                ]);
            }

            $length = $end - $start + 1;

            $headers['Content-Length'] = $length;
            $headers['Content-Range'] = 'bytes ' . $start . '-' . $end . '/' . $fileSize;

            $stream = fopen($fullPath, 'rb');
            fseek($stream, $start);

            return response()->stream(function () use ($stream, $length) {
                $bufferSize = 1024 * 1024; // 1MB buffer
                $remaining = $length;

                while ($remaining > 0 && !feof($stream)) {
                    $readSize = min($bufferSize, $remaining);
                    echo fread($stream, $readSize);
                    $remaining -= $readSize;
                    flush();
                }

                fclose($stream);
            }, 206, $headers);
        }

        // 没有 Range 请求，返回完整文件
        return response()->file($fullPath, $headers);
    }
}
