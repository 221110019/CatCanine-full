@extends('layouts.app')

@section('content')
    <div class="card mb-8">
        <!-- Posts List -->
        <div wire:poll.visible.5s="loadPosts">
            @forelse ($posts as $post)
                <div
                    class="card border-l border-r mb-4"
                    wire:key="post-{{ $post->id }}"
                >
                    <div class="card-body">

                        <!-- Author Info -->
                        <x-forum-post-header :post="$post" />

                        <!-- Post Content -->
                        <div class="p-2 rounded-sm bg-base-300">
                            @if ($editingPostId === $post->id)
                                <div class="space-y-2">
                                    <textarea
                                        wire:model="editingCaption"
                                        class="textarea textarea-bordered w-full"
                                        rows="3"
                                    ></textarea>
                                    <div class="flex gap-2">
                                        <button
                                            wire:click="updatePost({{ $post->id }})"
                                            class="btn btn-success btn-sm"
                                        >Save</button>
                                        <button
                                            wire:click="cancelEdit"
                                            class="btn btn-ghost btn-sm"
                                        >Cancel</button>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm">{{ $post->caption }}</p>
                                @if ($post->picture)
                                    <div class="max-w-screen-sm w-full relative">
                                        <div class="pb-[100%]">
                                            <img
                                                src="{{ asset('storage/' . $post->picture) }}"
                                                class="mask mask-squircle absolute inset-0 w-full h-full object-cover"
                                                alt="{{ $post->id }}{{ $post->user->name }}"
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
                        @livewire('forum-comment-section', ['post' => $post])
                    </div>
                </div>
            @empty
                <div class="text-center text-base-content/70 py-8">
                    No posts yet. Be the first to share something!
                </div>
            @endforelse
        </div>
    </div>


@endsection
