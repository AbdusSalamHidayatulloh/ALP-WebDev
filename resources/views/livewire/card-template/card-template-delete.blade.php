<button 
    type="button" 
    class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" 
    onclick="if(confirm('Are you sure you want to delete this template? This action cannot be undone.')) { @this.call('delete') }"
    wire:loading.attr="disabled">
    <span wire:loading.remove wire:target="delete">
        <span class="d-flex align-items-center justify-content-center">
            <span class="material-symbols-rounded font-logo">delete</span>
        </span>
    </span>
    <span wire:loading wire:target="delete">
        <span class="d-flex align-items-center justify-content-center">
            <span class="material-symbols-rounded font-logo icon-spin">progress_activity</span>
        </span>
    </span>
</button>