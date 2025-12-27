<div class="card p-3 shadow-sm flex-shrink-0" style="width: 300px; height: fit-content;">
    <div class="position-relative">
        <input type="text" wire:model="list_name" placeholder="Enter a title" class="form-control pe-5">
        <button
            class="btn text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent"
            style="z-index: 999" wire:click="cancelCreateList">✕</button>
    </div>
    <div class="mt-2">
        <button class="btn btn-primary w-100" wire:click="createList">Add</button>
    </div>
</div>
