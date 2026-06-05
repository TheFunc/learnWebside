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
Route::get('video/group/{groupID}', [VideoController::class, 'getGroupVideos'])->name('admin.video.group');
Route::delete('video/group/{groupID}', [VideoController::class, 'destroyGroup'])->name('admin.video.group.destroy');
Route::post('video/type', [VideoController::class, 'storeType'])->name('admin.video.type.store');
Route::put('video/type/{id}', [VideoController::class, 'updateType'])->name('admin.video.type.update');
Route::delete('video/type/{id}', [VideoController::class, 'destroyType'])->name('admin.video.type.destroy');
Route::post('video/upload-cover', [VideoController::class, 'uploadCover'])->name('admin.video.upload.cover');
Route::post('video/upload-video', [VideoController::class, 'uploadVideo'])->name('admin.video.upload.video');
Route::post('video/save-info', [VideoController::class, 'saveVideoInfo'])->name('admin.video.save.info');
Route::get('video/stream/{path}', [VideoController::class, 'streamVideo'])->name('admin.video.stream')->where('path', '.*');

Route::get('homework/preview', function () {
    return view('admin.homework.preview');
})->name('admin.homework.preview');

Route::get('homework/assign', function () {
    return view('admin.homework.assign');
})->name('admin.homework.assign');

Route::get('homework/member', function () {
    return view('admin.homework.member');
})->name('admin.homework.member');
