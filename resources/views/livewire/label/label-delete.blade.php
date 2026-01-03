<button 
    type="button" 
    class="btn btn-outline-danger" 
    wire:click="deleteLabel"
    onclick="return confirm('Are you sure you want to delete this label? It will be removed from all cards.')"
    wire:loading.attr="disabled">
    <span class="material-symbols-rounded font-logo">delete</span>
</button>