<?php

namespace App\Livewire\CustomField;

use App\Models\Board;
use App\Models\CustomField;
use Illuminate\Support\Collection;
use Livewire\Component;

class CustomFieldList extends Component
{
    public Board $board;
    public Collection $fields;

    protected $listeners = [
        'field-deleting' => 'handleFieldDeleting',
        'custom-field-list-refresh' => 'refreshFields',
        'field-updated' => 'refreshFields', // Add this back for creation
        'echo-private:board.{board.id},CustomFieldBoard' => 'handleBroadcast', // Add this back
    ];

    public function mount(Board $board)
    {
        $this->board = $board;
        $this->fields = collect();
        $this->refreshFields();
    }

    public function refreshFields()
    {
        $this->fields = $this->board->customFields()->get();
    }

    public function handleFieldDeleting($fieldId)
    {
        // Remove immediately from collection BEFORE the actual delete happens
        $this->fields = $this->fields->reject(fn($field) => $field->id === $fieldId);
    }

    public function render()
    {
        return view('livewire.custom-field.custom-field-list');
    }
}
