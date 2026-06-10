<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalType;
use App\Models\ExternalInfo;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    public function course()
    {
        $types = ExternalType::orderBy('created_at', 'desc')->get();
        return view('admin.external.course', compact('types'));
    }

    public function manage()
    {
        $externals = ExternalInfo::with('externalType')->orderBy('created_at', 'desc')->get();
        $types = ExternalType::all();
        return view('admin.external.manage', compact('externals', 'types'));
    }

    public function create()
    {
        $types = ExternalType::all();
        return view('admin.external.create', compact('types'));
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:external_types',
        ]);

        ExternalType::create([
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', '外部类型创建成功');
    }

    public function updateType(Request $request, int $id)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:external_types,type,' . $id,
        ]);

        $type = ExternalType::findOrFail($id);
        $type->type = $request->type;
        $type->save();

        return response()->json(['success' => true, 'message' => '外部类型更新成功']);
    }

    public function destroyType(int $id)
    {
        $type = ExternalType::findOrFail($id);
        $type->delete();

        return redirect()->back()->with('success', '外部类型删除成功');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        ExternalInfo::create([
            'type' => $request->type,
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return redirect()->back()->with('success', '外部链接添加成功');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $external = ExternalInfo::findOrFail($id);
        $external->update([
            'type' => $request->type,
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return response()->json(['success' => true, 'message' => '外部链接更新成功']);
    }

    public function destroy(int $id)
    {
        $external = ExternalInfo::findOrFail($id);
        $external->delete();

        return response()->json(['success' => true, 'message' => '外部链接删除成功']);
    }
}
