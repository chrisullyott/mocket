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
        $page = $request->input('page');
        $host = $request->input('host');
        $favs = $request->input('favorites');

        $items = Item::where('user_id', Auth::id())
                ->orderBy('created_at', 'DESC');

        if ($host) {
            $items->whereHas('meta', function($query) use ($host) {
                $query->where('host', $host);
            });
        }

        if ($favs) {
            $items->where('is_favorite', $favs);
        }

        $result = $items->paginate(10);

        if ($result->isEmpty()) {
            $filtered = $page || $host || $favs;
            return $filtered ? redirect()->route('home') : redirect()->route('add');
        }

        $subTitle = static::subTitle($host, $favs);

        return view('home', ['subTitle' => $subTitle, 'items' => $result]);
    }

    /**
     * Build a subtitle for this page.
     *
     * @return string
     */
    protected static function subTitle($host = null, $favorites = null)
    {
        if ($host) {
            return ' : Filtered';
        } elseif ($favorites) {
            return ' : Favorites';
        }

        return '';
    }
}
