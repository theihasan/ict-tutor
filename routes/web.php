<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\TestController;

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
Route::get('/chapters/{id}/model-tests', [ChapterController::class, 'modelTests'])->name('chapter.model-tests');

// API Routes for chapters
Route::prefix('api')->group(function () {
    Route::get('/chapters/statistics', [ChapterController::class, 'statistics'])->name('api.chapters.statistics');
    Route::get('/chapters/search', [ChapterController::class, 'search'])->name('api.chapters.search');
    Route::post('/chapters/clear-cache', [ChapterController::class, 'clearCache'])->name('api.chapters.clear-cache');
    
    // API Routes for tests
    Route::get('/tests/statistics', [TestController::class, 'statistics'])->name('api.tests.statistics');
    Route::get('/tests/search', [TestController::class, 'search'])->name('api.tests.search');
    Route::post('/tests/clear-cache', [TestController::class, 'clearCache'])->name('api.tests.clear-cache');
});

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Edit profile page
Route::get('/edit-profile', function () {
    return view('edit-profile');
})->name('edit-profile');

// Dynamic exam paper routes - moved to tests section

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

// Model tests routes (dynamic) - specific routes first
Route::get('/model-tests', [TestController::class, 'index'])->name('model-tests');
Route::get('/model-tests/featured', [TestController::class, 'featured'])->name('model-tests.featured');
Route::get('/model-tests/chapter/{chapterId}', [TestController::class, 'byChapter'])->name('model-tests.chapter');
Route::get('/model-tests/type/{type}', [TestController::class, 'byType'])->name('model-tests.type');
Route::get('/model-tests/{id}', [TestController::class, 'show'])->where('id', '[0-9]+')->name('model-tests.show');

// Test/Exam routes with middleware for authentication where needed
Route::group(['prefix' => 'tests'], function () {
    Route::get('/{testId}/preview', [TestController::class, 'preview'])->name('tests.preview');
    Route::get('/{testId}/exam-paper', [TestController::class, 'examPaper'])->middleware('auth')->name('tests.exam-paper');
    Route::post('/{testId}/start', [TestController::class, 'startAttempt'])->middleware('auth')->name('tests.start');
    Route::post('/save-answer', [TestController::class, 'saveAnswer'])->middleware('auth')->name('tests.save-answer');
    Route::post('/attempts/{attemptId}/submit', [TestController::class, 'submitAttempt'])->middleware('auth')->name('tests.submit');
    Route::get('/attempts/{attemptId}/results', [TestController::class, 'results'])->middleware('auth')->name('tests.results');
});

// Backward compatibility route for static exam paper (redirects to dynamic)
Route::get('/exam-paper', function () {
    // Redirect to test selection or show error
    return redirect()->route('model-tests')->with('info', 'Please select a test to begin the exam.');
})->name('exam-paper');

// Privacy page
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Student dashboard page
Route::get('/student-dashboard', function () {
    return view('student-dashboard');
})->name('student-dashboard');
