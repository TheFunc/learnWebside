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
use App\Models\Homework;
use App\Models\HomeworkMen;
use App\Models\ExternalType;
use App\Models\ExternalInfo;
use App\Models\Competition;

class LearnController extends Controller
{
    /**
     * 学习平台首页
     */
    public function index(Request $request)
    {
        $homepageVideo = $this->getHomepageVideo();
        $competitions = Competition::oldest()->paginate(8);

        return view('learn.home', compact('homepageVideo', 'competitions'));
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
            })
            ->sort(function ($a, $b) {
                return strnatcasecmp($a->display_name, $b->display_name);
            })
            ->values();

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
        $homeworks = Homework::paginate(10);

        return view('learn.homework', compact('homeworks'));
    }

    /**
     * 下载作业文件
     */
    public function downloadHomework(int $id)
    {
        $homework = Homework::findOrFail($id);

        $folderPath = storage_path('app/public/' . $homework->Path);

        if (!is_dir($folderPath)) {
            abort(404, '作业文件不存在');
        }

        $files = glob($folderPath . '/*');

        if (empty($files)) {
            abort(404, '作业文件夹为空');
        }

        $filePath = $files[0];
        $fileName = basename($filePath);

        return response()->download($filePath, $fileName);
    }

    /**
     * 上传作业
     */
    public function uploadHomework(Request $request, int $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip,7z,rar,tar,gz,bz2|max:52428800',
        ]);

        $homework = Homework::findOrFail($id);

        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();

        $userName = session('learn_user_name', '未知用户');
        $folderName = $userName . '_' . date('YmdHis') . '_' . $homework->Title;

        $storagePath = storage_path('app/public/homework/' . $folderName);
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $path = 'homework/' . $folderName . '/' . $originalFilename;
        $file->move($storagePath, $originalFilename);

        HomeworkMen::create([
            'Name' => $userName,
            'Title' => $homework->Title,
            'Path' => $path,
        ]);

        return back()->with('success', '作业上传成功');
    }

    /**
     * 网站导航页面
     */
    public function navigation()
    {
        return view('learn.navigation');
    }

    /**
     * 外部学习页面
     */
    public function external(Request $request)
    {
        $typeId = $request->integer('type_id');

        $externalTypes = ExternalType::all();

        $query = ExternalInfo::with('externalType');

        if ($typeId) {
            $query->where('type', ExternalType::find($typeId)?->type);
        }

        $externalLinks = $query->get()
            ->groupBy('type')
            ->map(function ($group, $type) {
                return [
                    'type' => $type,
                    'links' => $group,
                    'count' => $group->count(),
                ];
            })->values();

        return view('learn.external', compact('externalTypes', 'externalLinks', 'typeId'));
    }

    /**
     * 记录学习时间
     */
    public function recordWatchTime(Request $request)
    {
        $userId = Session::get('learn_user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => '未登录'], 401);
        }

        $seconds = $request->input('seconds', 0);
        if ($seconds <= 0) {
            return response()->json(['success' => false, 'message' => '无效的时间'], 400);
        }

        $menber = Menber::find($userId);
        if (!$menber) {
            return response()->json(['success' => false, 'message' => '用户不存在'], 404);
        }

        $menber->LearnTime += (int) $seconds;
        $menber->save();

        return response()->json(['success' => true, 'learn_time' => $menber->LearnTime]);
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
            return back()->with('pwd_error', '用户不存在');
        }

        if ($menber->Password !== $request->old_password) {
            return back()->with('pwd_error', '旧密码不正确');
        }

        $menber->Password = $request->new_password;
        $menber->save();

        return back()->with('pwd_success', '密码修改成功');
    }
}