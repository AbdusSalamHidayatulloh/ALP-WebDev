<?php

use App\Models\Card;
use App\Models\ListCard;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('boards', function () {
    return true;
});

Broadcast::channel('board.{boardId}', function ($user, $boardId) {
    return $user->memberBoards()->where('board_id', $boardId)->exists();
});

Broadcast::channel('list.{listId}', function($user, $listId) {
    return ListCard::where('id', $listId)->whereHas('board.members', fn ($q) => $q->where('users.id', $user->id));
});

Broadcast::channel('user.{userId}', function($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('card.{cardId}', function($user, $cardId){
    return Card::where('id', $cardId)->whereHas('list.board.members', function($q) use ($user) {
        $q->where('users.id', $user->id);
    })->exists();
});