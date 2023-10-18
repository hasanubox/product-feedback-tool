<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FeedbackVoteController;
use App\Http\Controllers\FeedbackCommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('feedbacks')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::get('/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
        Route::post('/', [FeedbackController::class, 'store'])->name('feedbacks.store');
        Route::get('datatable', [FeedbackController::class, 'datatable'])->name('feedbacks.datatable');
        
        Route::get('vote', [FeedbackVoteController::class, 'index'])->name('feedbacks.vote');
        Route::post('vote', [FeedbackVoteController::class, 'store'])->name('feedbacks.vote');
        
        Route::get('comment/{feedback_id}', [FeedbackCommentController::class, 'index'])->name('feedbacks.comment');
        Route::post('comment', [FeedbackCommentController::class, 'store'])->name('feedbacks.comment');
    });
});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
