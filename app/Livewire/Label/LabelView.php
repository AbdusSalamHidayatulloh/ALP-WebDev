<?php

namespace App\Livewire\Label;

use App\Models\Label;
use Livewire\Component;

class LabelView extends Component
{

    public $board;
    public $labels = [];
    protected $listeners = [
        'label-saved' => 'loadLabels',
        'label-deleted' => 'loadLabels'
    ];

    public function mount($board) {
        $this->board = $board;
        $this->loadLabels();
    }

    public function loadLabels() {
        $this->labels = $this->board->labels()->get();
    }

    public function render()
    {
        return view('livewire.label.label-view');
    }
}
