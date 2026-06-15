<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competition;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    public function scenery()
    {
        return view('admin.competition.scenery');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'ImgUrl' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'Description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('ImgUrl')) {
            $path = $request->file('ImgUrl')->store('competitions', 'public');
            $validated['ImgUrl'] = '/storage/' . $path;
        }

        // 描述为空时设默认空字符串
        if (!isset($validated['Description']) || $validated['Description'] === null) {
            $validated['Description'] = '';
        }

        Competition::create($validated);

        return back()->with('success', '比赛添加成功');
    }

    public function manage(Request $request)
    {
        $query = Competition::query();
        
        if ($request->filled('search')) {
            $query->where('Title', 'like', '%' . $request->search . '%');
        }
        
        $competitions = $query->oldest()->paginate(20);
        return view('admin.competition.manage', compact('competitions'));
    }

    public function update(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);

        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'ImgUrl' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'Description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('ImgUrl')) {
            // 删除旧图片
            if ($competition->ImgUrl) {
                $oldPath = str_replace('/storage/', '', $competition->ImgUrl);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('ImgUrl')->store('competitions', 'public');
            $validated['ImgUrl'] = '/storage/' . $path;
        } else {
            unset($validated['ImgUrl']);
        }

        // 描述为空时设默认空字符串
        if (!isset($validated['Description']) || $validated['Description'] === null) {
            $validated['Description'] = '';
        }

        $competition->update($validated);

        return back()->with('success', '比赛更新成功');
    }

    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);

        // 删除关联的图片文件
        if ($competition->ImgUrl) {
            $path = str_replace('/storage/', '', $competition->ImgUrl);
            Storage::disk('public')->delete($path);
        }

        $competition->delete();

        return back()->with('success', '删除成功');
    }
}
