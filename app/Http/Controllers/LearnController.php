<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Menber;
use App\Models\VideoType;
use App\Models\VideoInfo;
use App\Models\VideoCover;

class LearnController extends Controller
{
    /**
     * 学习平台首页
     */
    public function index()
    {
        $homepageVideo = $this->getHomepageVideo();

        return view('learn.home', compact('homepageVideo'));
    }

    /**
     * 获取后台设置的首页视频
     */
    private function getHomepageVideo(): ?string
    {
        $files = Storage::disk('public')->files('homepage');

        if (empty($files)) {
            return null;
        }

        $fileName = basename($files[0]);
        return route('admin.settings.stream.video', ['fileName' => $fileName]);
    }

    /**
     * 课程学习页面
     */
    public function courses(Request $request)
    {
        $typeId = $request->integer('type_id');

        $videoTypes = VideoType::all();

        $query = VideoInfo::with('cover');

        if ($typeId) {
            $query->where('TypeID', $typeId);
        }

        $videoGroups = $query->get()
            ->groupBy('GroupID')
            ->map(function ($group, $groupId) {
                $firstVideo = $group->first();
                return [
                    'group_id' => (int) $groupId,
                    'type_id' => $firstVideo->TypeID,
                    'cover' => $firstVideo->cover?->path,
                    'video_count' => $group->count(),
                    'videos' => $group,
                ];
            })->values();

        return view('learn.courses', compact('videoTypes', 'videoGroups', 'typeId'));
    }

    /**
     * 视频观看页面
     */
    public function watchVideo(int $groupId)
    {
        $videos = VideoInfo::where('GroupID', $groupId)
            ->with('cover')
            ->get()
            ->map(function ($video) {
                $filename = basename($video->Path);
                $video->display_name = preg_replace('/^\d+_/', '', $filename);
                return $video;
            });

        if ($videos->isEmpty()) {
            abort(404, '视频组不存在');
        }

        $typeId = $videos->first()->TypeID;
        $videoTypes = VideoType::all();

        return view('learn.watch', compact('videos', 'groupId', 'typeId', 'videoTypes'));
    }

    /**
     * 获取视频流地址
     */
    public function streamVideo(string $path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->file($fullPath, [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    /**
     * 作业页面
     */
    public function homework()
    {
        return view('learn.homework');
    }

    /**
     * 网站导航页面
     */
    public function navigation()
    {
        return view('learn.navigation');
    }

    /**
     * 修改密码页面
     */
    public function showChangePassword()
    {
        return view('learn.change-password');
    }

    /**
     * 执行修改密码
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $adminId = Session::get('learn_user_id');
        $menber = Menber::find($adminId);

        if (!$menber) {
            return back()->withErrors(['error' => '用户不存在']);
        }

        if ($menber->Password !== $request->old_password) {
            return back()->withErrors(['error' => '旧密码不正确']);
        }

        $menber->Password = $request->new_password;
        $menber->save();

        return back()->with('success', '密码修改成功');
    }
}
