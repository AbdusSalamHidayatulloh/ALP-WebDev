    <div wire:poll.visible.1s="refreshLists" class="container-fluid bg-black board-scroll mt-3">
        <div class="d-flex gap-3 flex-nowrap">
            @foreach($lists as $li)
            <div class="col-auto list-view">
                <div class="card shadow-sm p-2" style="width: 300px">
                    <div class="card-header bg-white fw-bold mb-3">
                        {{ $li->list_name }}
                        <livewire:boardlist.list-delete
                            :board-id="$this->board->id"
                            :list-id="$li->id"
                            :key="$li->id" />
                    </div>
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body p-2">Sample Task Card</div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary w-100 mt-2">Add Card</button>
                </div>
            </div>
            @endforeach
            @if(! $showCreateForm)
            <div class="card add-card shadow-sm d-flex flex-row p-2 align-items-center" style="width: 300px; cursor: pointer;" wire:click="showForm">
                <p class="m-0 w-100">+ Add New List</p>
            </div>
            @else
                <livewire:boardlist.list-create :board="$board" />
            @endif
        </div>
    </div>