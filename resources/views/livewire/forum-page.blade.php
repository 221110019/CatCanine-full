        <div>
            <livewire:forum-create-post />
            <div class="card mb-8 min-h-screen">
                <div class="flex gap-2 mb-4 justify-center">
                    @php
                        $parameters = [
                            'recent',
                            'popular',
                            'my post',
                            'liked',
                            'cat',
                            'dog',
                        ];
                    @endphp
                    @foreach ($parameters as $parameter)
                        <button
                            class="capitalize btn btn-sm {{ $filter === $parameter ? 'btn-secondary' : '' }}"
                            wire:click="setFilter('{{ $parameter }}')"
                        >
                            {{ $parameter }}
                        </button>
                    @endforeach
                </div>
                <x-forum-search-bar />
                <span class="align-center opacity-35 text-sm text-right">Show
                    {{ $posts->count() }}
                    post(s)</span>
                @forelse ($posts as $post)
                    <div
                        class="card border-primary border-l border-b mb-1"
                        wire:key="post-{{ $post->id }}"
                    >
                        <div class="card-body">
                            <x-forum-post-header :post="$post" />
                            <div class="p-2 rounded-sm bg-base-200">
                                @if ($editingPostId === $post->id)
                                    <textarea
                                        wire:model="editingCaption"
                                        class="validator textarea textarea-primary text-primary-content h-24 mb-4 w-full @error('caption')textarea-error @enderror"
                                        maxlength="120"
                                        required
                                    ></textarea>
                                    <div class="flex gap-2 mt-2">
                                        <button
                                            wire:click="updatePost({{ $post->id }})"
                                            class="btn btn-warning btn-sm"
                                        >
                                            Save
                                        </button>
                                        <button
                                            wire:click="cancelEdit"
                                            class="btn btn-ghost btn-sm"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                @else
                                    <p class="text-sm">{{ $post->caption }}</p>
                                    @if ($post->picture)
                                        <div
                                            class="max-w-screen-sm w-full relative mt-2">
                                            <div class="pb-[100%]">
                                                <img
                                                    src="{{ asset('storage/' . $post->picture) }}"
                                                    class="mask mask-squircle absolute inset-0 w-full h-full object-cover"
                                                >
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <livewire:forum-likes-counter
                                :post="$post->id"
                                :wire:key="'likes-'.$post->id"
                            />
                            @livewire('forum-comment-section', ['post' => $post], key('comments-' . $post->id))
                        </div>
                    </div>
                @empty
                    <div class="text-center text-base-content/70 py-8">
                        No posts found
                    </div>
                @endforelse
            </div>
        </div>
