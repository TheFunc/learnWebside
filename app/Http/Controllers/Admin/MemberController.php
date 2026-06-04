<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menber;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Menber::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('Name', 'like', "%{$search}%");
        }

        if ($request->has('status_sort')) {
            $statusSort = $request->input('status_sort');
            if ($statusSort == 'online') {
                $query->orderBy('Status', 'desc');
            } elseif ($statusSort == 'offline') {
                $query->orderBy('Status', 'asc');
            }
        }

        if ($request->has('permission_sort')) {
            $permissionSort = $request->input('permission_sort');
            if ($permissionSort == 'admin') {
                $query->orderBy('Permission', 'desc');
            } elseif ($permissionSort == 'member') {
                $query->orderBy('Permission', 'asc');
            }
        }

        $members = $query->paginate(10);

        return view('admin.member.index', compact('members'));
    }

    public function create()
    {
        return view('admin.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|confirmed',
            'permission' => 'required|integer|in:0,1',
        ]);

        Menber::create([
            'Name' => $request->name,
            'Password' => $request->password,
            'Permission' => $request->permission,
            'Status' => 0,
            'LearnTime' => 0,
        ]);

        return redirect()->route('admin.member.index')->with('success', '成员添加成功');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $member = Menber::findOrFail($id);
        $member->password = $request->password;
        $member->save();

        return response()->json(['success' => true, 'message' => '密码修改成功']);
    }

    public function destroy($id)
    {
        $member = Menber::findOrFail($id);
        
        if (strtolower($member->Name) == 'admin') {
            return response()->json(['success' => false, 'message' => 'admin 用户受保护，不能被删除']);
        }
        
        $member->delete();

        return response()->json(['success' => true, 'message' => '删除成功']);
    }
}
