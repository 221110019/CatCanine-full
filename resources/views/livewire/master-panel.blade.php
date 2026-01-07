<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Master Panel</h1>

    <!-- Tabs -->
    <div class="tabs mb-4">
        <a
            class="tab tab-bordered {{ $tab === 'post' ? 'tab-active' : '' }}"
            wire:click="setTab('post')"
        >Post Reports</a>
        <a
            class="tab tab-bordered {{ $tab === 'userReports' ? 'tab-active' : '' }}"
            wire:click="setTab('userReports')"
        >User Reports</a>
        <a
            class="tab tab-bordered {{ $tab === 'promotion' ? 'tab-active' : '' }}"
            wire:click="setTab('promotion')"
        >Promotions</a>
    </div>

    <!-- Post Reports -->
    @if ($tab === 'post')
        <table class="table table-zebra w-full">
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
                                wire:click="archivePost({{ $post->id }})"
                                class="btn btn-sm btn-error"
                            >Archive</button>
                            <button
                                wire:click="dismissPostReport({{ $post->id }})"
                                class="btn btn-sm btn-ghost"
                            >Dismiss</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- User Reports -->
    @elseif($tab === 'userReports')
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Reporter</th>
                    <th>Reported User</th>
                    <th>Post ID</th>
                    <th>Reported At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userReports as $report)
                    <tr>
                        <td>{{ $report->reporter->name }}</td>
                        <td>{{ $report->reportedUser->name }}</td>
                        <td>{{ $report->post_id }}</td>
                        <td>{{ $report->created_at->diffForHumans() }}</td>
                        <td class="space-x-1">
                            @if (!$report->reportedUser->isMaster())
                                <button
                                    wire:click="banUser({{ $report->reportedUser->id }})"
                                    class="btn btn-sm btn-error"
                                >Ban</button>
                                <button
                                    wire:click="dismissUserReport({{ $report->id }})"
                                    class="btn btn-sm btn-ghost"
                                >Dismiss</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Promotions -->
    @elseif($tab === 'promotion')
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promotableUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="space-x-1">
                            <button
                                wire:click="promoteUser({{ $user->id }})"
                                class="btn btn-sm btn-primary"
                            >Promote</button>
                            @if ($user->role === 'moderator')
                                <button
                                    wire:click="demoteUser({{ $user->id }})"
                                    class="btn btn-sm btn-warning"
                                >Demote</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
