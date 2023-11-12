@if ($comments->count())
    <div class="comments-list">
        @foreach ($comments as $comment)
            <div class="comments-list__item">
                <div class="comments-list__header">
                    <x-other.ava
                        class="comments-list__ava"
                        image="{{ $comment->user->photo }}"
                        name="{{ $comment->user->name }}"
                        desc="{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}">
                    </x-other.ava>

                    <div class="comments-list__actions">
                        <x-buttons.linked href="{{ route('comments.edit', $comment->id) }}" icon="edit" style="main" class="button--rounded"></x-buttons.linked>

                        <button class="button button--danger button--rounded" type="button" data-click-action="delete-target" data-target-id="{{ $comment->id }}">
                            <span class="button__icon material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>

                <div class="comments-list__item-body">
                    {{ $comment->body }}
                </div>
            </div>
        @endforeach
    </div>

    @include('modals.delete-target', ['action' => route('comments.destroy'), 'permanently' => false])
@endif
