<?php

namespace App\Livewire\Board;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class BoardMemberList extends Component
{
    public Board $board;
    public bool $show = false;
    public ?int $selectedUserId = null;

    public function mount(Board $board)
    {
        $this->board = $board;
    }

    public function backToList()
    {
        $this->selectedUserId = null;
    }

    public function loadMember()
    {
        $this->board->load('members');
    }

    #[On('open-modal-members')]
    public function toggleDropdownOpen()
    {
        $this->show = true;
    }

    #[On('close-modal-members')]
    public function toggleDropdownClose()
    {
        $this->show = false;
    }

    #[On('member_added')]
    public function memberAddUpdate()
    {
        $this->loadMember();
    }

    #[On('member_action')]
    public function memberaActionsRole()
    {
        $this->loadMember();
    }

    public function selectMember(int $userId)
    {
        $this->selectedUserId = $userId;
    }

    #[On('member_action_done')]
    public function resetSelect()
    {
        $this->selectedUserId = null;
    }

    //Protection on accessing update
    public function currentUserIsAdmin(): bool {
        return $this->board->members()
                    ->where('user_id', Auth::id())
                    ->wherePivot('role', 'admin')
                    ->exists();
    }

    public function memberIsProtectedAdmin($member): bool {
        return $member->pivot?->role === 'admin' && $member->pivot?->isGuest === false;
    }

    public function render()
    {
        return view('livewire.board.board-member-list', [
            'members' => $this->board->members()->get()
        ]);
    }
}
