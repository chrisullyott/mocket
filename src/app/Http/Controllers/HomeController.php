<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Item;

class HomeController extends Controller
{
    /**
     * How many items to show per page.
     *
     * @var int
     */
    private static $perPage = 5;

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
                ->orderBy('created_at', 'DESC');

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
        $result = $items->paginate(static::$perPage);

        // Redirect if empty.
        if ($result->isEmpty()) {
            $filtered = $request->favorites || $request->host || $request->page;
            return $filtered ? redirect()->route('home') : redirect()->route('add');
        }

        return view('home', ['items' => $result]);
    }
}
