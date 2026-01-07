<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Moderator Panel</h1>

    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Author</th>
                <th>Caption</th>
                <th>Reports</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->author->name }}</td>
                    <td class="max-w-xs truncate">{{ $post->caption }}</td>
                    <td>{{ $post->reporters_count }}</td>
                    <td class="space-x-2">
                        <button
                            wire:click="archive({{ $post->id }})"
                            class="btn btn-sm btn-error"
                        >
                            Archive
                        </button>
                        <button
                            wire:click="dismiss({{ $post->id }})"
                            class="btn btn-sm btn-ghost"
                        >
                            Dismiss
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
