<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapterController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Chapters page
Route::get('/chapters', [ChapterController::class, 'index'])->name('chapters');
Route::get('/chapters/{id}', [ChapterController::class, 'show'])->name('chapter.show');

// API Routes for chapters
Route::prefix('api')->group(function () {
    Route::get('/chapters/statistics', [ChapterController::class, 'statistics'])->name('api.chapters.statistics');
    Route::get('/chapters/search', [ChapterController::class, 'search'])->name('api.chapters.search');
    Route::post('/chapters/clear-cache', [ChapterController::class, 'clearCache'])->name('api.chapters.clear-cache');
});

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Edit profile page
Route::get('/edit-profile', function () {
    return view('edit-profile');
})->name('edit-profile');

// Exam paper page
Route::get('/exam-paper', function () {
    return view('exam-paper');
})->name('exam-paper');

// FAQ page
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Leaderboard page
Route::get('/leaderboard', function () {
    return view('leaderboard');
})->name('leaderboard');

// Model test summary page
Route::get('/model-test-summary', function () {
    return view('model-test-summary');
})->name('model-test-summary');

// Model tests page
Route::get('/model-tests', function () {
    return view('model-tests');
})->name('model-tests');

// Privacy page
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Student dashboard page
Route::get('/student-dashboard', function () {
    return view('student-dashboard');
})->name('student-dashboard');
