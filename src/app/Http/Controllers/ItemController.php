<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the new item screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('add');
    }

    /**
     * Create a new item.
     */
    public function create(Request $request)
    {
        Item::create([
            'user_id' => Auth::id(),
            'url' => $request->input('url')
        ]);

        return redirect()->route('home');
    }

    /**
     * Update a given item.
     */
    public function patch(int $id, Request $request)
    {
        $item = Item::findOrFail($id);
        $input = $request->all();
        $item->update($input);

        return redirect()->back();
    }

    /**
     * Delete a given item.
     */
    public function delete(int $id)
    {
        $item = Item::findOrFail($id);
        $item->meta()->delete();
        $item->delete();

        return redirect()->route('home');
    }
}