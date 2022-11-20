<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Models\SearchingTime;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = isset($request->query->all()['query']) ? $request->query->all()['query'] : null;

        $result = [];
        $search_result = [];
        if ($query) {
            // search data based on keyword
            $search_result = SearchHistory::where('search_keyword', 'like', '%' . $query . '%')->orWhere('search_result', 'like', '%' . $query . '%')->get();
            if (!count($search_result)) {
                return back()->with('status', 'Not Found');
            }


            foreach ($search_result as $result) {
                // update hits
                SearchHistory::where('id', $result->id)->update([
                    'hits' => $result->hits + 1,
                ]);

                // insert time when searched
                SearchingTime::insert([
                    'search_history_id' => $result->id,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        $search_histories = SearchHistory::latest()->get();
        return view('home', compact('search_histories', 'search_result'));
    }
}
