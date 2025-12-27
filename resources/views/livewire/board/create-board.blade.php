    <form wire:submit.prevent="createBoard" class="d-flex px-4 flex-column">
        <label for="board_name">Board Name:</label>
        <input type="text" class="form-control my-3" wire:model="board_name" placeholder="Board #1" required>
        <div class="d-flex flex-md-row flex-column gap-2">
            <button type="submit" class="btn p-2 btn-primary btn-size w-100">Create Board</button>
            <a href="/dashboard" class="btn p-2 btn-secondary btn-size text-decoration-none w-100">Return</a>
        </div>
    </form>
