<div class="h-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 d-flex align-items-center gap-1">
            <span class="material-symbols-rounded font-logo text-primary">schedule</span>
            <span>Due Dates</span>
        </h5>
        
        <!-- Limit Selector -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                {{ $limit }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" wire:click.prevent="updateLimit(3)">3</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updateLimit(5)">5</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updateLimit(10)">10</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updateLimit(15)">15</a></li>
            </ul>
        </div>
    </div>

    <div style="max-height: calc(100vh - 200px); overflow-y: auto;">
        @if ($upcomingCards->count() > 0)
            <div class="d-flex flex-column gap-2">
                @foreach ($upcomingCards as $card)
                    @php
                        $dueDate = \Carbon\Carbon::parse($card->dates);
                        $isOverdue = $dueDate->isPast();
                        $daysUntilDue = now()->diffInDays($dueDate, false);
                        $isDueSoon = !$isOverdue && $daysUntilDue >= 0 && $daysUntilDue <= 7;
                    @endphp

                    <div class="card shadow-sm"
                        style="cursor: pointer;"
                        wire:click="$dispatch('open-card-from-sidebar', { cardId: {{ $card->id }} })">
                        <div class="card-body p-2">
                            <!-- Card Title -->
                            <div class="d-flex align-items-start gap-2 mb-1">
                                @if ($card->labels->first())
                                    <span class="badge flex-shrink-0"
                                        style="background-color: {{ $card->labels->first()->color }}; width: 8px; height: 8px; padding: 0; border-radius: 50%;">
                                    </span>
                                @endif
                                <span class="small fw-semibold flex-grow-1">{{ Str::limit($card->card_title, 35) }}</span>
                            </div>

                            <!-- List Name -->
                            <div class="small text-muted mb-1 d-flex align-items-center gap-1">
                                <span class="material-symbols-rounded font-logo" style="font-size: 16px;">list</span>
                                <span>{{ $card->list->list_name }}</span>
                            </div>

                            <!-- Due Date -->
                            <div class="mb-1">
                                <span
                                    class="badge d-inline-flex align-items-center gap-1 {{ $isOverdue ? 'bg-danger' : ($isDueSoon ? 'bg-warning text-dark' : 'bg-secondary') }} small">
                                    <span class="material-symbols-rounded font-logo">schedule</span>
                                    <span>{{ $dueDate->format('M d, Y') }}</span>
                                </span>
                            </div>
                            
                            <div class="small text-muted">
                                {{ $dueDate->diffForHumans() }}
                            </div>

                            @if ($isOverdue)
                                <div class="small text-danger mt-1 d-flex align-items-center gap-1">
                                    <span class="material-symbols-rounded font-logo">error</span>
                                    <span>Overdue</span>
                                </div>
                            @elseif($isDueSoon)
                                <div class="small text-warning mt-1 d-flex align-items-center gap-1">
                                    <span class="material-symbols-rounded font-logo">notifications_active</span>
                                    <span>Due soon!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-5">
                <span class="material-symbols-rounded font-logo" style="font-size: 48px; opacity: 0.5;">event_available</span>
                <p class="mb-0">No upcoming due dates</p>
            </div>
        @endif
    </div>
</div>