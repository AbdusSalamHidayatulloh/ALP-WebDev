<div>
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 d-flex justify-content-center align-items-center gap-1">
                <span class="material-symbols-rounded font-logo">layers</span>
                <span>Card Templates</span>
            </h6>
            @if (!$showForm)
                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" wire:click="createTemplate">
                    <span class="material-symbols-rounded font-logo">add</span>
                    <span>New Template</span>
                </button>
            @endif
        </div>

        @if ($showForm)
            <!-- Template Form -->
            <livewire:card-template.card-template-create :board="$board" :templateId="$editingTemplateId" :key="'template-form-' . ($editingTemplateId ?? 'new')" />
        @else
            <!-- Template List -->
            @if ($templates->count() > 0)
                <div class="row g-3">
                    @foreach ($templates as $template)
                        <div class="col-md-6" wire:key="template-{{ $template->id }}">
                            <div class="card h-100">
                                @if ($template->image)
                                    <img src="{{ Storage::url($template->image) }}" class="card-img-top"
                                        alt="{{ $template->card_title }}" style="height: 150px; object-fit: cover;">
                                @endif

                                <div class="card-body">
                                    <h6 class="card-title">{{ $template->card_title }}</h6>

                                    @if ($template->description)
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($template->description, 100) }}
                                        </p>
                                    @endif

                                    @if ($template->dates)
                                        <div class="mb-2">
                                            <span class="badge bg-secondary d-inline-flex align-items-center gap-1">
                                                <span class="material-symbols-rounded font-logo">schedule</span>
                                                <span>{{ \Carbon\Carbon::parse($template->dates)->format('M d, Y') }}</span>
                                            </span>
                                        </div>
                                    @endif

                                    @if ($template->labels->count() > 0)
                                        <div class="mb-2">
                                            @foreach ($template->labels as $label)
                                                <span class="badge me-1" style="background-color: {{ $label->color }};">
                                                    {{ $label->title }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($template->customFields->count() > 0)
                                        <div class="mb-2">
                                            <small class="text-muted d-inline-flex align-items-center gap-1">
                                                <span class="material-symbols-rounded font-logo">list</span>
                                                <span>{{ $template->customFields->count() }} custom field(s)</span>
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer bg-white border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"
                                            wire:click="editTemplate({{ $template->id }})">
                                            <span class="material-symbols-rounded font-logo">edit</span>
                                            <span>Edit</span>
                                        </button>

                                        <div class="d-flex gap-2">
                                            <livewire:card-template.card-template-use :board="$board"
                                                :template="$template" :key="'template-use-' . $template->id" />

                                            <livewire:card-template.card-template-delete :template="$template"
                                                :key="'template-delete-' . $template->id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <span class="material-symbols-rounded font-logo align-middle">info</span>
                    <span>No templates yet. Create your first template to reuse card configurations!</span>
                </div>
            @endif
        @endif
    </div>
</div>
