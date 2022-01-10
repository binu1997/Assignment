<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Models\Product;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class,'index'])->name('index');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $products = Product::latest()->get();;
    return view('dashboard',compact('products'));
})->name('dashboard');


Route::post('product/add', [MainController::class,'addproduct'])->name('product/add');
Route::get('product/status/{status}/{id}', [MainController::class,'updatestatus'])->name('product/add');
Route::post('product/delete/{id}', [MainController::class, 'deleteproduct'])->name('admin/brand/delete');
