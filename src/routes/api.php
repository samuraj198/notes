<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('clients', ClientController::class)->parameters([
    'clients' => 'id'
]);
Route::post('/clients/{clientId}/notes', [NoteController::class, 'store']);

Route::prefix('notes')->group(function () {
    Route::get('/{noteId}', [NoteController::class, 'show']);
    Route::put('/{noteId}', [NoteController::class, 'update']);
    Route::delete('/{noteId}', [NoteController::class, 'destroy']);
});
Route::get('/important-notes', [NoteController::class, 'importantNotes']);
