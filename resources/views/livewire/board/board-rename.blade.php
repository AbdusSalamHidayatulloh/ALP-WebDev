<div>
    @if ($edit)
    <div class="input-group d-flex gap-2">
        <input
            type="text"
            wire:model.defer="board_name"
            wire:keydown.enter="updateBoardName"
            wire:keydown.escape="$set('edit', false)"
            class="form-control"
            autofocus
        >
        <button
            class="btn btn-secondary"
            wire:click="$set('edit', false)"
        >✕</button>
    </div>
    @else
        <h3 wire:click="$set('edit', true)">
            {{ $board_name }}
        </h3>
    @endif
</div>

