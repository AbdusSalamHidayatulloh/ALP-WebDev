<?php

namespace App\Livewire\CardTemplate;

use App\Events\CardTemplateUpdated; // ADD THIS
use App\Models\Board;
use App\Models\CardTemplate;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CardTemplateDelete extends Component
{
    public $template;

    public function mount(CardTemplate $template)
    {
        $this->template = $template;
    }

    public function delete()
    {
        // Check authorization
        if ($this->template->board->members->pluck('id')->doesntContain(Auth::id())) {
            abort(403, 'Unauthorized access');
        }

        $templateTitle = $this->template->card_title;
        $boardId = $this->template->board_id;
        $boardIn = Board::find($boardId);
        $templateId = $this->template->id;

        // Delete image if exists
        if ($this->template->image && Storage::disk('public')->exists($this->template->image)) {
            Storage::disk('public')->delete($this->template->image);
        }

        // Delete the template (cascade will handle relationships)
        $this->template->delete();

        // Create log
        Log::create([
            'user_id' => Auth::id(),
            'board_id' => $boardIn->id,
            'loggable_type' => CardTemplate::class,
            'loggable_id' => $templateId,
            'details' => 'Deleted card template: "' . $templateTitle . '"',
        ]);

        broadcast(new CardTemplateUpdated(
            $boardIn->id,
            'deleted',
            ['id' => $templateId]
        ))->toOthers();

        $this->dispatch('template-deleted');
        
        session()->flash('message', 'Template deleted successfully');
    }

    public function render()
    {
        return view('livewire.card-template.card-template-delete');
    }
}