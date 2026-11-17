<?php

use Illuminate\Support\Facades\Route;
use App\Models\Business;
use App\Models\Category;

Route::get('/', function () {
    // This install serves one store: send visitors straight to its menu.
    $slug = config('app.menu_slug');
    if ($slug && Business::where('slug', $slug)->exists()) {
        return redirect()->route('menu.show', ['slug' => $slug]);
    }
    return view('welcome');
});
Route::get('/menu/{slug}', [App\Http\Controllers\MenuController::class, 'show'])->name('menu.show');
//Route::get('/generate-qr/{slug}', [App\Http\Controllers\MenuController::class, 'show'])->name('generate-qr');
 Route::get('/generate-qr/{slug}', [App\Http\Controllers\QRController::class, 'generate'])->name('generate-qr');
Route::get('/switch-language/{lang}', 
function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        session()->forget('locale');
        session()->push('locale', $lang);
        App::setLocale($lang);
    }
    return redirect()->back();
}
)->name('switch.language');
Route::get('/cat/{slug}', function ($slug) {

    $business = Business::where('slug', $slug)->first();
    $categories = Category::where('business_id', $business->id)->where('active', true)
        ->with(['products' => function ($query) {
            $query->where('active', true)
                ->orderBy('sort_order', 'asc')
                ->with(['garnishes' => function ($garnishQuery) {
                    $garnishQuery->orderBy('sort_order', 'asc');
                }]);
        }])
        ->orderBy('sort_order', 'asc')->get();
    return view('cat', ['business' => $business, 'categories' => $categories]);
})->name('menu');