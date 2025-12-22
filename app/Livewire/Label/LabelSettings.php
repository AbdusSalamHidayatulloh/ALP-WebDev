<?php

namespace App\Livewire\Label;

use App\Models\Label;
use Livewire\Component;

class LabelSettings extends Component
{
    public $title;
    public $board;
    public ?int $labelId = null;
    public string $labelView = 'list';
    public $color = "#008cff";

    public function mount($board, $labelId = null) {
        $this->board = $board;
        if($labelId) {
            $this->loadLabel($labelId);
        }
    }

    public function loadLabel($labelId) {
        $label = Label::find($labelId);
        $this->labelId = $label->id;
        $this->title = $label->title;
        $this->color = $label->color;
    }

    public function resetForm() {
        $this->labelId = null;
        $this->title = '';
        $this->color = "#008cff";
    }

    public function deleteLabel() {
        if(! $this->labelId) {
            abort(404, 'Label not found');
        }
        $label = Label::find($this->labelId);
        $label::where('board_id', $this->board->id)
                ->where('id', $this->labelId)
                ->delete();
        $this->dispatch('label-deleted');
        $this->resetForm();
    }

    public function saveData()
    {

        $this->validate([
            'title' => 'required|string|max:50',
            'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $label = Label::updateOrCreate([
            'id' => $this->labelId
        ], [
            'title' => $this->title,
            'color' => $this->color,
            'board_id' => $this->board->id,
        ]);

        $this->dispatch('label-saved');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.label.label-create');
    }
}
