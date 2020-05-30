<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Item;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Create an item.
// Route::put('item', function(Request $request) {
//     $model = Item::create([
//         'user_id' => 'NEED AUTH',
//         'url' => $request->input('url')
//     ]);

//     return $model;
// });

// Get an item by ID.
Route::get('items/{id}', function($id) {
    return Item::findOrFail($id);
});

// Get all items.
Route::get('items', function() {
    return Item::all();
});

// Update an item.
Route::put('items/{id}', function(Request $request, $id) {
    $model = Item::findOrFail($id);
    $model->update($request->all());
    return $model;
});

// Delete an item.
Route::delete('items/{id}', function(Request $request, $id) {
    $model = Item::findOrFail($id);
    $model->meta()->delete();
    $model->delete();
    return response()->json(null, 204);
});
