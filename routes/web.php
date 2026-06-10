<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExternalController;
use App\Http\Controllers\Admin\HomeworkController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LearnLoginController;
use App\Http\Controllers\LearnController;

Route::get('/', function () {
    return view('welcome');
});

// 学习平台登录路由（无需认证）
Route::get('learnLogin', [LearnLoginController::class, 'showLoginForm'])->name('learn.login');
Route::post('learnLogin', [LearnLoginController::class, 'login'])->name('learn.login.post');
Route::post('learnLogout', [LearnLoginController::class, 'logout'])->name('learn.logout');

// 学习平台前台路由（需要认证）
Route::middleware('learn.auth')->prefix('learn')->name('learn.')->group(function () {
    Route::get('/', [LearnController::class, 'index'])->name('index');
    Route::get('/courses', [LearnController::class, 'courses'])->name('courses');
    Route::get('/watch/{groupId}', [LearnController::class, 'watchVideo'])->name('watch');
    Route::get('/video/stream/{path}', [LearnController::class, 'streamVideo'])->name('video.stream')->where('path', '.*');
    Route::get('/homework', [LearnController::class, 'homework'])->name('homework');
    Route::get('/homework/download/{id}', [LearnController::class, 'downloadHomework'])->name('homework.download');
    Route::post('/homework/upload/{id}', [LearnController::class, 'uploadHomework'])->name('homework.upload');
    Route::get('/navigation', [LearnController::class, 'navigation'])->name('navigation');
    Route::get('/external', [LearnController::class, 'external'])->name('external');
    Route::get('/change-password', [LearnController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [LearnController::class, 'changePassword'])->name('change-password.post');
    Route::post('/record-watch-time', [LearnController::class, 'recordWatchTime'])->name('record.watch.time');
});

Route::get('rootlogin', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('rootlogin', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// 首页视频流路由（无需认证，供学习平台使用）
Route::get('settings/video/{fileName}', [SettingsController::class, 'streamVideo'])->name('admin.settings.stream.video');

Route::middleware('admin.auth')->group(function () {
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

    Route::get('external/course', [ExternalController::class, 'course'])->name('admin.external.course');
    Route::get('external/manage', [ExternalController::class, 'manage'])->name('admin.external.manage');
    Route::get('external/create', [ExternalController::class, 'create'])->name('admin.external.create');
    Route::post('external/type', [ExternalController::class, 'storeType'])->name('admin.external.type.store');
    Route::put('external/type/{id}', [ExternalController::class, 'updateType'])->name('admin.external.type.update');
    Route::delete('external/type/{id}', [ExternalController::class, 'destroyType'])->name('admin.external.type.destroy');
    Route::post('external', [ExternalController::class, 'store'])->name('admin.external.store');
    Route::put('external/{id}', [ExternalController::class, 'update'])->name('admin.external.update');
    Route::delete('external/{id}', [ExternalController::class, 'destroy'])->name('admin.external.destroy');

    Route::get('homework/preview', [HomeworkController::class, 'preview'])->name('admin.homework.preview');
    Route::put('homework/{id}', [HomeworkController::class, 'update'])->name('admin.homework.update');
    Route::delete('homework/{id}', [HomeworkController::class, 'destroy'])->name('admin.homework.destroy');

    Route::get('homework/assign', [HomeworkController::class, 'assign'])->name('admin.homework.assign');
    Route::post('homework/assign', [HomeworkController::class, 'store'])->name('admin.homework.store');

    Route::get('homework/member', [HomeworkController::class, 'member'])->name('admin.homework.member');
    Route::get('homework/member/download/{id}', [HomeworkController::class, 'downloadHomework'])->name('admin.homework.member.download');
    Route::delete('homework/member/{id}', [HomeworkController::class, 'destroyMember'])->name('admin.homework.member.destroy');

    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::get('settings/videos', [SettingsController::class, 'getVideos'])->name('admin.settings.videos');
    Route::post('settings/upload-video', [SettingsController::class, 'uploadVideo'])->name('admin.settings.upload.video');
    Route::delete('settings/delete-video', [SettingsController::class, 'deleteVideo'])->name('admin.settings.delete.video');
});
