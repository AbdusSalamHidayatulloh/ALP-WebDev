@extends('layouts.nav')
@section('title', $board->board_name ?? 'You are not part of this board')
@section('mainContent')
@if ($board)
    <div class="board-layout d-flex flex-row">

        {{-- Sidebar --}}
        <livewire:inbox.inbox-actions :boardId="$board->id" />

        {{-- Board --}}
        <main id="boardContent" class="p-4">
            <livewire:board.board-rename :board="$board" :key="'board-renamed-' . $board->id . '-' . $board->updated_at" />
            <livewire:custom-field.custom-field-list :board="$board" />
            <livewire:custom-field.custom-field-create :board="$board" />
            <livewire:board.board-invite :board="$board" />
            <livewire:board.board-member-list :board="$board" />
            @push('scripts')
                <script>
                    window.boardId = {{ $board->id }};
                </script>
            @endpush
            <livewire:boardlist.list-view :board="$board" />

        </main>

        <div class="position-absolute d-flex flex-row p-2 bg-white p-1 shadow" style="bottom: 40px; left: 50%; border-radius: 10px;">
            <button id="toggleSidebar" class="btn btn-primary mb-3">
                ☰
            </button>
        </div>

    </div>
@else
    <div class="d-flex flex-colum align-items-center justify-content-center" style="min-height: 60vh">
        <h3 class="mb-3 fw-bold fs-4">You are not part of this board</h3>
        <p>You have no access to do something in this board</p>
        <a href="/dashboard" class="btn btn-primary">Return</a>
    </div>
@endif
@endsection
