<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkMen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class HomeworkController extends Controller
{
    public function assign()
    {
        return view('admin.homework.assign');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'difficulty' => 'required|integer|min:1|max:5',
            'file' => 'required|file|mimes:zip,7z,rar,tar,gz,bz2|max:50000',
        ]);

        $title = $request->input('title');
        $difficulty = $request->input('difficulty');
        
        $folderName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $title);
        $folderName = trim($folderName, '_');
        
        if (empty($folderName)) {
            $folderName = 'homework_' . time();
        }

        $path = 'homework/' . $folderName;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');
        }

        Homework::create([
            'Title' => $title,
            'Difficulty' => $difficulty,
            'Path' => $path,
        ]);

        return redirect()->route('admin.homework.assign')->with('success', '作业布置成功！');
    }

    public function preview()
    {
        $homeworks = Homework::orderBy('created_at', 'desc')->get();
        return view('admin.homework.preview', compact('homeworks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $homework = Homework::findOrFail($id);
        $oldPath = $homework->Path;
        $newTitle = $request->input('title');
        
        $newFolderName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $newTitle);
        $newFolderName = trim($newFolderName, '_');
        
        if (empty($newFolderName)) {
            $newFolderName = 'homework_' . time();
        }

        $newPath = 'homework/' . $newFolderName;

        if ($oldPath !== $newPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->move($oldPath, $newPath);
        }

        $homework->update([
            'Title' => $newTitle,
            'Path' => $newPath,
        ]);

        return response()->json(['success' => true, 'message' => '作业名称修改成功！']);
    }

    public function destroy($id)
    {
        $homework = Homework::findOrFail($id);
        
        if (Storage::disk('public')->exists($homework->Path)) {
            Storage::disk('public')->deleteDirectory($homework->Path);
        }
        
        $homework->delete();

        return response()->json(['success' => true, 'message' => '作业删除成功！']);
    }

    public function member()
    {
        $homeworkMens = HomeworkMen::orderBy('created_at', 'desc')->get();
        return view('admin.homework.member', compact('homeworkMens'));
    }

    public function downloadHomework($id)
    {
        $homeworkMen = HomeworkMen::findOrFail($id);
        $path = $homeworkMen->Path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, '文件不存在');
        }

        $fileContents = Storage::disk('public')->get($path);
        $fileName = basename($path);

        return Response::make($fileContents, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function destroyMember($id)
    {
        $homeworkMen = HomeworkMen::findOrFail($id);

        if (Storage::disk('public')->exists($homeworkMen->Path)) {
            Storage::disk('public')->delete($homeworkMen->Path);
        }

        $folderPath = dirname($homeworkMen->Path);
        if (Storage::disk('public')->exists($folderPath)) {
            $remainingFiles = Storage::disk('public')->files($folderPath);
            if (empty($remainingFiles)) {
                Storage::disk('public')->deleteDirectory($folderPath);
            }
        }

        $homeworkMen->delete();

        return response()->json(['success' => true, 'message' => '作业删除成功！']);
    }
}
