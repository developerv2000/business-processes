<form class="comment-form" action="{{ route('comments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
    <input type="hidden" name="id" value="{{ $item->id }}">

    <x-other.ava image="{{ request()->user()->photo }}"></x-other.ava>
    <input class="comment-form__input" type="text" name="body" placeholder="{{ __('Add new comment') }}" minlength="2" required autocomplete="off">
    <x-form.submit class="comment-form__submit" style="transparent" icon="send" />
</form>
