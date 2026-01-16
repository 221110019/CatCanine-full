<div class="flex items-center justify-between mb-4">
    <div>
        @php
            $roleFont =
                [
                    'moderator' => 'text-shadow-lg/50 text-shadow-secondary',
                    'master' => 'italic text-shadow-lg text-shadow-primary',
                ][$post->user->role] ?? '';

            $isSelf =
                $post->user_id === auth()->id()
                    ? 'before:content-["►"] after:content-["◄"]'
                    : '';
            $isBanned = $post->user->isBanned() ? 'text-error opacity-30' : '';

        @endphp

        <p
            class="font-bold {{ $roleFont }} {{ $isSelf }} {{ $isBanned }}">
            {{ $post->user->name }}
        </p>

        <p class="text-xs opacity-70">
            {{ $post->created_at->diffForHumans() }}
            @if ($post->updated_at > $post->created_at)
                <span class="opacity-50 text-xs">(edited)</span>
            @endif
        </p>
    </div>

    @php
        $viewer = auth()->user();
        $author = $post->user;

        $showMenu = !($author->role === 'master' && $viewer->role !== 'master');

        $hasReportedPost = $post->reporters
            ? $post->reporters->contains('user_id', $viewer->id)
            : false;

        $hasReportedUser = $post->userReports
            ? $post->userReports->contains('reporter_id', $viewer->id)
            : false;

    @endphp

    @if ($showMenu)
        <div
            class="dropdown dropdown-end flex items-center"
            wire:ignore
        >
            <label
                tabindex="0"
                class=" btn btn-ghost btn-circle btn-sm mt-1 tooltip tooltip-left"
                data-tip="Menu"
            >
                <x-svg.ellipsis-vertical />
            </label>

            <ul
                tabindex="0"
                class= "  dropdown-content p-2 menu rounded-box bg-base-100 border border-secondary w-28 uppercase font-bold"
            >

                @if ($post->user_id === $viewer->id)
                    <li>
                        <button
                            wire:click="editPost({{ $post->id }})"
                            class="text-warning "
                        >
                            Edit
                        </button>
                    </li>
                @endif
                @if ($post->canDelete)
                    <li>
                        <button
                            wire:click="archivePost({{ $post->id }})"
                            class="text-error "
                        >
                            Delete
                        </button>
                    </li>
                @endif
                @if ($post->user_id !== $viewer->id)
                    <li>
                        <button
                            wire:click="reportPost({{ $post->id }})"
                            @disabled($hasReportedPost)
                            class=" {{ $hasReportedPost ? 'opacity-50 cursor-not-allowed' : '' }}"
                        >
                            {{ $hasReportedPost ? 'Post Reported' : 'Report Post' }}
                        </button>
                    </li>
                @endif
                @if ($post->user_id !== $viewer->id)
                    <li>
                        <button
                            wire:click="reportUser({{ $post->id }})"
                            @disabled($hasReportedUser)
                            class=" {{ $hasReportedUser ? 'opacity-50 cursor-not-allowed' : '' }}"
                        >
                            {{ $hasReportedUser ? 'User Reported' : 'Report User' }}
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    @endif

</div>
