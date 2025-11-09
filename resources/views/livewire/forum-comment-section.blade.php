<div class="mt-4">
    @if ($post->comments()->count() > $showCount)
        <button
            wire:click="loadMore"
            class="btn btn-link"
        >View older comment</button>
    @endif
    @foreach ($comments as $comment)
        <p><span class="font-semibold">{{ $comment->user->name }}:</span>
            {{ $comment->content }}</p>
    @endforeach



    <div class="flex mt-2 join">
        <input
            type="text"
            wire:model.defer="newComment"
            placeholder="Add a comment..."
            class="join-item input input-bordered flex-1"
            maxlength="100"
        >
        <button
            wire:click="addComment"
            class="join-item btn btn-accent"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path
                    d="M4 3 h16 a2 2 0 0 1 2 2 v12 a2 2 0 0 1 -2 2 h-12 l-4 4 V5 a2 2 0 0 1 2 -2 z"
                />

                <path d="M8 8 h10" />
                <path d="M8 12 h8" />
                <path d="M8 16 h6" />
            </svg>


        </button>
    </div>
    <div class="divider divider-accent px-0 mx-0 w-full">
        <x-lucid iconName="paw-print" />
    </div>
</div>
