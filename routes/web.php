<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

// File
Route::post('/file/upload', [FileController::class, 'upload'])
    ->withoutMiddleware(VerifyCsrfToken::class);

// Response
Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);

// Route Group
Route::prefix('/response/type')->group(function () {
    // Response Type
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

// Route Group Controller
Route::controller(CookieController::class)->group(function () {
    // Cookie
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

// Redirect
Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);

Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name('redirect-hello');

// URL Generation
Route::get('/redirect/named', function () {
    // ada tiga cara seperti dibawah ini
    // return route('redirect-hello', ['name' => 'Evan']);
    // return url()->route('redirect-hello', ['name' => 'Evan']);
    return URL::route('redirect-hello', ['name' => 'Evan']);
});

// Redirect Action
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
// Redirect Away
Route::get('/redirect/away', [RedirectController::class, 'redirectAway']);


// Route Group Middleware dan Group Prefix (bisa jika ditambah controller jika ada controller yang sama)
Route::middleware(['contoh:PZN,401'])->prefix('/middleware')->group(function () {
    // Middleware
    Route::get('/api', function () {
        return "OK";
    });
    // bisa juga langsung classmiddlewarenya ->middleware([ContohMiddleware::class])

    // Middleware Group
    Route::get('/group', function () {
        return "GROUP";
    });
});

// URL Controller Action
Route::get('/url/action', function () {
    // ada tiga cara untuk menggunakan url action

    // return action([FormController::class, 'form']);
    // return url()->action([FormController::class, 'form']);
    return URL::action([FormController::class, 'form']);
});

// CSRF
Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

// URL
Route::get('/url/current', function () {
    return URL::full();
});

// Session
Route::get('/session/create', [SessionController::class, 'createSession']);
Route::get('/session/get', [SessionController::class, 'getSession']);

// Error Handling
Route::get('/error/sample', function () {
    throw new Exception("Sample Error");
});

Route::get('/error/manual', function () {
    report(new Exception("Sample Error"));
    return "OK";
});

Route::get('/error/validation', function () {
    throw new ValidationException("Validation Error");

    return "OK";
});

// HTTP Exception
Route::get('/abort/400', function () {
    abort(400, "Ups Validation Error");
});

Route::get('/abort/401', function () {
    abort(401);
});

Route::get('/abort/500', function () {
    abort(500);
});

// end