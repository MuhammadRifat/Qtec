<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Models\SearchingTime;
use Carbon\Carbon;
use Auth;

class SearchController extends Controller
{
    // search by search keywords
    function index($id = null)
    {
        $params = [];

        foreach (explode(',', $id) as $singleId) {
            array_push($params, $singleId);
        }
        $data = SearchHistory::whereIn('id', $params)->get();

        return response()->json($data);
    }

    // search by date
    function search_by_date(Request $request)
    {
        $start_date = isset($request->query->all()['start_date']) ? $request->query->all()['start_date'] : Carbon::now();
        $end_date = isset($request->query->all()['end_date']) ? $request->query->all()['end_date'] : Carbon::now();

        $data = SearchingTime::where('searching_times.created_at', '>=', $start_date)->where('searching_times.created_at', '<=', $end_date)->join('search_histories', 'searching_times.search_history_id', '=', 'search_histories.id')->get(['searching_times.created_at', 'search_histories.search_result']);
        return response()->json($data);
    }

    // view form to insert search results
    function insert_search_data()
    {
        return view('insert_search_data');
    }

    // insert action
    function insert(Request $request)
    {

        SearchHistory::insert([
            'search_keyword' => $request->search_keyword,
            'search_result' => $request->search_result,
            'added_by' => Auth::id(),
            'hits' => 0,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addStatus', 'successfully inserted');
    }
}
