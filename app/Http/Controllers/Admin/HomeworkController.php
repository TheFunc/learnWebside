<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
}
