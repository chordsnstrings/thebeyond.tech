<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CapabilityController as AdminCapabilityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ResearchController as AdminResearchController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/capabilities', [PageController::class, 'capabilities'])->name('capabilities');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');

Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
Route::get('/research/{article}', [ResearchController::class, 'show'])->name('research.show');

Route::get('/glossary', [GlossaryController::class, 'index'])->name('glossary');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/subscribe', [ContactController::class, 'subscribe'])->name('subscribe');

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/feed.xml', [DiscoveryController::class, 'feed'])->name('feed');
Route::get('/llms.txt', [DiscoveryController::class, 'llms']);

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('research', AdminResearchController::class)->except('show');
        Route::resource('portfolio', AdminPortfolioController::class)
            ->parameters(['portfolio' => 'company'])->except('show');
        Route::resource('capabilities', AdminCapabilityController::class)->except('show');

        Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::delete('submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
    });
});
