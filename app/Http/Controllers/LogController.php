<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Board $board, Request $request) {
        $query = $board->logs()->with('user')->latest();

        if($request->filled('searchLogs')) {
            $query->where('details', 'like', '%' . $request->searchLogs . '%');
        }

        return view ('boards.logs', [
            'board' => $board,
            'logs' => $query->paginate(10)->withQueryString(),
            'searchData' => $request->searchLogs ?? ''
        ]);
    }
}
