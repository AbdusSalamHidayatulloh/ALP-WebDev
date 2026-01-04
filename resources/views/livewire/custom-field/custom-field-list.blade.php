<div class="custom-fields-list">
    <h6 class="mb-2">Custom Fields</h6>
    
    @forelse($fields as $field)
        <div wire:key="field-wrapper-{{ $field->id }}">
            <livewire:custom-field.custom-field-edit 
                :field="$field" 
                :wire:key="'field-edit-' . $field->id"
            />
        </div>
    @empty
        <p class="text-muted small">No custom fields yet</p>
    @endforelse
</div>