<div class="p-2">
    <h1 class="text-xl font-bold mb-4">Reported Post(s)</h1>

    @if ($posts->isEmpty())
        <div class="alert alert-info">No posts to moderate.</div>
    @else
        <div class="w-full">
            <div class="grid grid-cols-1 gap-y-1">
                @foreach ($posts as $post)
                    <div
                        class="card bg-primary-content text-primary  shadow flex flex-col">
                        @if ($post->picture)
                            <figure class="overflow-hidden">
                                <img
                                    src="{{ asset('storage/' . $post->picture) }}"
                                    alt="Post image"
                                    class="object-cover w-full h-48"
                                />
                            </figure>
                        @endif

                        <div class="card-body flex-1 flex flex-col">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="card-title  text-sm">
                                        {{ $post->author->name }}
                                    </h2>
                                    @if (isset($post->created_at))
                                        <p class="text-xs text-muted">
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <span class="badge badge-outline">
                                        {{ $post->reporters_count ?? ($post->reports_count ?? 0) }}
                                        reports
                                    </span>
                                </div>
                            </div>

                            <p class="text-sm mt-2">
                                {{ $post->caption }}</p>

                            <div class="card-actions justify-end mt-2">
                                <button
                                    wire:click="archive({{ $post->id }})"
                                    class="btn btn-sm btn-error"
                                >Archive</button>
                                <button
                                    wire:click="dismiss({{ $post->id }})"
                                    class="btn btn-sm btn-ghost"
                                >Dismiss</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
