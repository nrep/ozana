<?php

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/products/create', function (Request $request) {
    $product = new Product;

    $product->name = $request->name;
    $product->user_id = $request->user()->id;

    $product->save();
});

Route::get('/stocks', function (Request $request) {
    if ($request->has('term')) {
        $stockItems = Stock::where('available_quantity', '>', 0)
            ->with('product')
            ->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->term.'%');
                // dd($query);
            })
            ->get();
    } else {
        $stockItems = Stock::where('available_quantity', '>', 0)
            ->with('product')
            ->get();
    }
    return $stockItems;
});
