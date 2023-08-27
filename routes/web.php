<?php

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
use App\Http\Controllers\InvitationController;


Route::get('/add_invitation', [InvitationController::class, 'addInvitation'])->name('addInvitation');
Route::post('/add_invitation', [InvitationController::class, 'createInvitation'])->name('createInvitation');

Route::get('/change-status/{invitation}', [InvitationController::class, 'changeStatus'])->name('changeStatus');
Route::get('/delete-invitation/{unique_link}', [InvitationController::class, 'deleteInvitation'])->name('deleteInvitation');
Route::get('/thx', [InvitationController::class, 'thx'])->name('thx');

Route::get('/', function () {
    $uniqueLink = "1";
    return view('welcome', compact('uniqueLink'));
});

Route::get('/{unique_link?}', [InvitationController::class, 'showInvitation'])->name('invitation');
Route::post('/{unique_link?}', [InvitationController::class, 'checkPassword'])->name('checkPassword');
