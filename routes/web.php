<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\VideoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('root', MemberController::class)->only(['index', 'create', 'store'])->names([
    'index' => 'admin.member.index',
    'create' => 'admin.member.create',
    'store' => 'admin.member.store',
]);

Route::post('root/{id}/password', [MemberController::class, 'updatePassword'])->name('admin.member.password');
Route::delete('root/{id}', [MemberController::class, 'destroy'])->name('admin.member.destroy');

Route::get('video/course', [VideoController::class, 'course'])->name('admin.video.course');
Route::get('video/manage', [VideoController::class, 'manage'])->name('admin.video.manage');
Route::get('video/create', [VideoController::class, 'create'])->name('admin.video.create');
