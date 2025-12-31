<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function directCreate() {
        return view('boards.board-create');
    }

    public function accessBoard(?Board $board) {
        if(! $board->members()->where('user_id', Auth::user()->id)->exists()) {
            abort(403, 'You are not part of this board');
        }
        return view('boards.board', [
            'board' => $board
        ]);
    }
}