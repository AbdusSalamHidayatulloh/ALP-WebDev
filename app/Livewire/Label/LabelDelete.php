<?php

namespace App\Livewire\Label;

use App\Models\Label;
use Livewire\Component;

class LabelDelete extends Component
{
    
    public $label;
    public function mount (Label $label) {
        $this->label = $label;
    }

    public function deleteLabel() {
        if(! $this->label) {
            abort(404, 'Label not found');
        }
        $this->label->delete();
        $this->dispatch('label-deleted');
    }

    public function render()
    {
        return view('livewire.label.label-delete');
    }
}
