<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Item;

class HomeController extends Controller
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
     * Show the items.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $items = Item::where('user_id', Auth::id())
                ->orderBy('created_at', 'DESC')
                ->limit(10);

        // Filter by favorites.
        if ($request->favorites) {
            $items->where('is_favorite', $request->favorites);
        }

        // Filter by host.
        if ($host = $request->host) {
            $items->whereHas('meta', function($query) use ($host) {
                $query->where('host', $host);
            });
        }

        // Fetch.
        $result = $items->get();

        // Redirect if empty.
        if ($result->isEmpty() && ($favorites || $host)) {
            return redirect()->route('home');
        } elseif ($result->isEmpty()) {
            return redirect()->route('add');
        }

        return view('home', ['items' => $result]);
    }
}
