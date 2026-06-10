<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $themes = [
            ['id' => 'original', 'name' => '经典雅致', 'description' => '网站原始风格，简洁大方'],
            ['id' => 'aurora', 'name' => '极光幻境', 'description' => '深邃紫蓝渐变，如梦似幻'],
            ['id' => 'midnight', 'name' => '暗夜鎏金', 'description' => '漆黑深邃，金色点缀'],
            ['id' => 'dawn', 'name' => '晨曦迷雾', 'description' => '柔和粉橙，清新淡雅'],
            ['id' => 'galaxy', 'name' => '星河漫步', 'description' => '浩瀚星空，神秘深邃'],
            ['id' => 'forest', 'name' => '绿野仙踪', 'description' => '翠翠绿意，自然生机'],
            ['id' => 'ocean', 'name' => '深海秘境', 'description' => '碧蓝深海，宁静致远'],
        ];

        $homepageVideos = $this->getHomepageVideos();

        return view('admin.settings.index', compact('themes', 'homepageVideos'));
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:50000',
        ]);

        $existingFiles = Storage::disk('public')->files('homepage');
        foreach ($existingFiles as $file) {
            Storage::disk('public')->delete($file);
        }

        $video = $request->file('video');
        $fileName = time() . '_' . $video->getClientOriginalName();
        $video->storeAs('homepage', $fileName, 'public');

        return response()->json([
            'success' => true,
            'message' => '视频上传成功，已替换原有视频',
            'fileName' => $fileName,
            'url' => route('admin.settings.stream.video', ['fileName' => $fileName]),
        ]);
    }

    public function deleteVideo(Request $request)
    {
        $fileName = $request->input('fileName');
        $path = 'homepage/' . $fileName;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true, 'message' => '视频删除成功']);
        }

        return response()->json(['success' => false, 'message' => '视频不存在']);
    }

    public function getVideos()
    {
        $videos = $this->getHomepageVideos();

        return response()->json([
            'success' => true,
            'videos' => $videos,
            'total' => count($videos),
        ]);
    }

    private function getHomepageVideos()
    {
        $videos = [];
        $files = Storage::disk('public')->files('homepage');

        foreach ($files as $file) {
            $fileName = basename($file);
            $videos[] = [
                'name' => $fileName,
                'url' => route('admin.settings.stream.video', ['fileName' => $fileName]),
            ];
        }

        return $videos;
    }

    public function streamVideo($fileName)
    {
        $fullPath = storage_path('app/public/homepage/' . $fileName);

        if (!file_exists($fullPath)) {
            abort(404, '视频文件不存在');
        }

        $fileSize = filesize($fullPath);
        $mimeType = mime_content_type($fullPath) ?: 'video/mp4';

        // 关闭 session 锁，避免视频流传输阻塞其他页面请求
        if (session()->isStarted()) {
            session()->save();
        }

        $range = request()->header('Range');

        if ($range) {
            $range = str_replace('bytes=', '', $range);
            $range = explode('-', $range);

            $start = isset($range[0]) && $range[0] !== '' ? (int) $range[0] : 0;
            $end = isset($range[1]) && $range[1] !== '' ? (int) $range[1] : $fileSize - 1;

            if ($start > $end || $start >= $fileSize) {
                return response('Range Not Satisfiable', 416, [
                    'Content-Range' => 'bytes */' . $fileSize,
                ]);
            }

            $length = $end - $start + 1;

            $headers = [
                'Content-Type' => $mimeType,
                'Accept-Ranges' => 'bytes',
                'Content-Length' => $length,
                'Content-Range' => 'bytes ' . $start . '-' . $end . '/' . $fileSize,
                'Cache-Control' => 'public, max-age=86400',
            ];

            $stream = fopen($fullPath, 'rb');
            fseek($stream, $start);

            return response()->stream(function () use ($stream, $length) {
                $bufferSize = 1024 * 1024;
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

        // 无 Range 请求时，直接返回文件，让浏览器自行发起 Range 请求
        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}