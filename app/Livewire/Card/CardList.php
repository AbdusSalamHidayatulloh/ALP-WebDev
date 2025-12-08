<?php

namespace App\Livewire\Card;

use App\Models\Board;
use App\Models\ListCard;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CardList extends Component
{

    public $list;
    public $listId;
    public $showCreateCardForm = false;
    public $cards = [];

    protected $listeners = [
        "echo-private:card.{$this->boardId},CardBroadcast" => 'refreshCards',
        'hideCreateFormCard' => 'createCancel',
    ];

    public function showForm()
    {
        $this->showCreateCardForm = true;
    }

    public function createCancel()
    {
        $this->showCreateCardForm = false;
    }

    public function mount(ListCard $list)
    {
        if (!$list) return;
        $this->listId = $list->id;
        $this->list = ListCard::find($this->listId);
        $this->refreshCards();
    }

    public function refreshCards()
    {
        $this->list = ListCard::with('cards')->find($this->listId);
        logger('Found list: ' . ($this->list ? $this->list->id : 'NULL'));

        if (!$this->list) {
            $this->cards = [];
            return;
        }

        if ($this->list->board->members->pluck('id')->doesntContain(Auth::id())) {
            abort(403, 'Unauthorized access, you are not part of the board');
        }

        $this->cards = $this->list->cards()->orderBy('position')->get();
    }

    public function render()
    {
        return view('livewire.card.card-list');
    }
}
