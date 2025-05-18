<?php

use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\TreeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TreeController::class, 'index'])
    ->name('dashboard');

    Route::get('/secure', [TreeController::class, 'secure'])
    ->name('secure');

    Route::get('/data', [TreeController::class, 'data'])
    ->name('data');

    Route::post('/trees/store', [TreeController::class, 'store'])
    ->name('trees.store');

    Route::get('/detail/{id}', [TreeController::class, 'detail'])->name('trees.show');

    Route::get('/trees/{tree_id}/detail', [TreeController::class, 'detail'])->name('trees.detail');
    
    Route::get('/trees/{id}/edit', [TreeController::class, 'edit'])->name('trees.edit');
    
    Route::delete('/trees/{id}/delete', [TreeController::class, 'delete'])->name('trees.delete');
    
    Route::put('/trees/{id}', [TreeController::class, 'update'])->name('trees.update');

    Route::post('/member/store', [FamilyController::class, 'store'])->name('family.store');

    Route::get('/family_members/{id}/edit', [FamilyController::class, 'edit'])->name('family_members.edit');

    Route::put('/family_members/{id}/update', [FamilyController::class, 'update'])->name('family_members.update');

    Route::delete('/family_members/{id}', [FamilyController::class, 'destroy'])->name('family_members.destroy');

    Route::get('/family-tree/{id}', [FamilyController::class, 'showFamilyTree']);

    Route::fallback([TreeController::class, 'notFound']);

    //route Dfs
    Route::post('/family/compare', [LogicController::class, 'compare'])->name('family.compare');

    


});


