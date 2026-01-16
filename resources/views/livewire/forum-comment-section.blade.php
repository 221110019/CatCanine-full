<div class="mt-4">
    @if ($post->comments()->count() > $showCount)
        <button
            wire:click="loadMore"
            class="btn btn-link"
        >View older comment</button>
    @endif

    @foreach ($comments as $comment)
        @php
            $roleFont =
                [
                    'moderator' => 'text-shadow-lg text-shadow-secondary',
                    'master' => 'italic text-shadow-lg text-shadow-primary',
                ][$comment->user->role] ?? '';

            $isSelf =
                $comment->user_id === auth()->id()
                    ? 'before:content-["►"] after:content-["◄"]'
                    : '';
            $isBanned = $comment->user->isBanned()
                ? 'text-error opacity-30'
                : '';

        @endphp
        <p>
            <span
                class="font-semibold {{ $roleFont }} {{ $isSelf }} {{ $isBanned }}"
            >
                {{ $comment->user->name }}
            </span>
            : {{ $comment->content }}
        </p>
    @endforeach

    <form
        wire:submit.prevent="addComment"
        class="flex mt-2 join"
    >
        <input
            type="text"
            wire:model.defer="newComment"
            placeholder="Add a comment..."
            class="join-item input input-bordered flex-1"
            maxlength="100"
        >

        <button
            type="submit"
            class="join-item btn btn-primary tooltip"
            data-tip="Add comment"
        >
            <x-svg.comment-dialog />
        </button>
    </form>


</div>
