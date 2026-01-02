<div class="flex items-center justify-between mb-4">
    <div>
        <p class="font-bold before:content-['@']">
            {{ $post->user->name }}
        </p>
        <p class="text-xs opacity-70">
            {{ $post->created_at->diffForHumans() }}
        </p>
    </div>
    <div class="dropdown dropdown-end ">
        <label
            {{-- tabindex="0" --}}
            class="btn btn-ghost btn-circle btn-sm tooltip
                                            tooltip-left"
            data-tip="coming soon: edit, delete, report"
        >
            <x-lucid iconName="ellipsis-vertical" />
        </label>
        <ul
            tabindex="0"
            class="dropdown-content p-2 menu rounded-box bg-base-100 border border-secondary w-25 uppercase font-bold"
        >
            @if ($post->canEdit)
                <li><button
                        wire:click="editPost({{ $post->id }})"
                        class="text-warning"
                    >Edit</button></li>
            @endif
            @if ($post->canDelete)
                <li><button
                        wire:click.prevent="deletePost('{{ $post->id }}')"
                        class="text-error"
                    >Delete</button></li>
            @endif
            <li><button
                    wire:click="reportPost({{ $post->id }})"
                    class=""
                >Report</button></li>
        </ul>
    </div>
</div>
