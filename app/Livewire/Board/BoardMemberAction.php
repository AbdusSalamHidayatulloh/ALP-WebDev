<?php

namespace App\Livewire\Board;

use App\Events\Board\BoardMemberActions;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class BoardMemberAction extends Component
{

    public Board $board;
    public $member;
    public $role;
    public bool $isLoading;

    public function mount(Board $board, int $userId)
    {
        $this->board = $board;
        $this->member = $board->members()->where('user_id', $userId)->firstOrFail();
        $this->role = $this->member->pivot->role;
    }

    public function isAdmin($userId = null): bool
    {
        return $this->board->members()
            ->where('user_id', $userId ?? $this->userId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    public function isMember(int $memberId): bool
    {
        return $this->board->members()
            ->whereKey($memberId)
            ->exists();
    }

    public function checkSameRole(int $memberId, string $newRole): bool
    {
        return $this->board->members()
            ->whereKey($memberId)
            ->wherePivot('role', $newRole)
            ->exists();
    }

    public function updateMemberRole()
    {
        if (! $this->isAdmin(Auth::id())) {
            $this->addError('general', 'Only admins can update roles of a member to this board.');
            return;
        }

        if (! $this->isMember($this->member->id)) {
            $this->addError('general', 'This user is not exist on this board.');
            return;
        }

        $this->member = $this->board->members()
            ->where('user_id', $this->member->id)
            ->firstOrFail();

        if ($this->checkSameRole($this->member->id, $this->role)) {
            $this->addError('general', 'Role of the user is the same.');
            return;
        }

        $this->board->members()->updateExistingPivot(
            $this->member->id,
            ['role' => $this->role]
        );

        broadcast(new BoardMemberActions($this->board, $this->member));

        $this->member = null;
    }

    public function disconnectMemberFromBoard($userId)
    {
        if (! $this->isAdmin(Auth::id())) {
            $this->addError('general', 'Only admins can update roles of a member to this board.');
            return;
        }

        if (! $this->isMember($this->member->id)) {
            $this->addError('general', 'This user is not exist on this board.');
            return;
        }

        $this->board->members()->detach($userId);

        broadcast(new BoardMemberActions($this->board, $this->member));
    }

    #[On('member_action_done')]
    public function resetMember()
    {
        $this->member = null;
    }


    public function render()
    {
        return view('livewire.board.board-member-action');
    }
}
