<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pzn', function () {
    return "Hello Programmer Zaman Now";
});

Route::redirect('/youtube', '/pzn');

Route::fallback(function () {
    return "404 By Evan"; // Digunakan jika route tidak ditemukan
});

Route::view('/hello', 'hello', ['name' => 'Evan']); // jika langsung menampilkan view

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Evan Pangau']);
}); // menampilkan view memakai function closure

Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'Evan']);
});


// Route Parameter
Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

// Route Parameter Optional
Route::get('categories/{id}', function ($categoryId) {
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail'); // tambahkan ini jika parameternya memiliki nilai tertentu

Route::get('/users/{id?}', function ($userId = '404') {
    return "User $userId";
})->name('user.detail');

// Route Konflik
Route::get('/conflict/evan', function () {
    return "Conflict evan";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

// Coba Route Name
Route::get('produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

// Controller
Route::get('controller/hello/request', [HelloController::class, 'request']); // Request
Route::get('controller/hello/{name}', [HelloController::class, 'hello']);

// Request Input
Route::get('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello', [InputController::class, 'hello']);

// Request Nested Input
Route::post('/input/hello/first', [InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/hello/array', [InputController::class, 'helloArray']);

// Input Type
Route::post('/input/type', [InputController::class, 'inputType']);

// Input Filter
Route::post('/input/filter/only', [InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);
