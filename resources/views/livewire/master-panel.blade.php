<div class="card bg-base-100 shadow-md">
    <div class="card-body">
        <div
            class="btn-group my-2 flex flex-nowrap whitespace-nowrap gap-1 justify-center"
            role="tablist"
        >
            <button
                type="button"
                class="btn btn-sm text-sm {{ $tab === 'role' ? 'btn-active' : '' }} px-3 py-1"
                wire:click="setTab('role')"
            >
                User
                <span
                    class="badge badge-sm ml-1">{{ $roleUsers->count() }}</span>
            </button>
            <button
                type="button"
                class="btn btn-sm text-sm {{ $tab === 'post' ? 'btn-active' : '' }} px-3 py-1"
                wire:click="setTab('post')"
            >
                Reported Post
                <span class="badge badge-sm ml-1">{{ $posts->count() }}</span>
            </button>
            <button
                type="button"
                class="btn btn-sm text-sm {{ $tab === 'archived' ? 'btn-active' : '' }} px-3 py-1"
                wire:click="setTab('archived')"
            >
                Archived
                <span
                    class="badge badge-sm ml-1">{{ $archivedPosts->count() }}</span>
            </button>
        </div>
        @if ($tab === 'role')
            <div class="mt-2 p-2 bg-base-200 rounded">
                <div class="flex flex-col  gap-2">
                    <div class="form-control flex-1 min-w-0">
                        <label class="input-group input-group-sm w-full">
                            <span class="bg-base-300 px-2 text-sm">Search</span>
                            <input
                                type="text"
                                placeholder="Username or email"
                                wire:model="search"
                                wire:input="applyFilters"
                                class="input input-sm input-bordered w-full text-sm py-1"
                            />
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="form-control w-36">
                            <select
                                wire:model="sort"
                                wire:change="applyFilters"
                                class="select select-bordered select-sm w-full text-sm"
                                aria-label="Sort"
                            >
                                <option value="reports">Report Count</option>
                                <option value="latest">Latest</option>
                                <option value="alpha">Alphabets</option>
                                <option value="role">Role</option>
                            </select>
                        </div>

                        <div class="form-control w-36">
                            <select
                                wire:model="filterRole"
                                wire:change="applyFilters"
                                class="select select-bordered select-sm w-full text-sm"
                                aria-label="Role"
                            >
                                <option value="all">All Roles</option>
                                <option value="moderator">Moderator</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label cursor-pointer gap-2 p-0 m-0">
                                <input
                                    type="checkbox"
                                    wire:model="showBanned"
                                    wire:change="applyFilters"
                                    class="toggle toggle-sm"
                                    aria-label="Show banned accounts"
                                />
                                <span class="label-text text-sm">Show banned
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center gap-1">
                            <button
                                type="button"
                                wire:click="resetAll"
                                class="btn btn-ghost btn-sm btn-circle"
                                title="Reset filters and sort"
                            >
                                <x-svg.reset />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($tab === 'post')
            <div class="w-full">
                <div class="grid grid-cols-1 gap-y-1">
                    @foreach ($posts as $post)
                        <div class="card bg-base-300 shadow flex flex-col">
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
                                        <h2 class="card-title text-sm">
                                            {{ $post->author->name }}</h2>
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
                                        wire:click="archivePost({{ $post->id }})"
                                        class="btn btn-sm btn-error"
                                    >Archive</button>
                                    <button
                                        wire:click="dismissPostReport({{ $post->id }})"
                                        class="btn btn-sm btn-ghost"
                                    >Dismiss</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif ($tab === 'archived')
            <div class="w-full">
                <div class="grid grid-cols-1 gap-y-1">
                    @foreach ($archivedPosts as $post)
                        <div class="card bg-base-300 shadow flex flex-col">
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
                                        <h2 class="card-title text-sm">
                                            {{ $post->author->name }}</h2>
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

                                <p class="text-sm  mt-2">
                                    {{ $post->caption }}</p>

                                <div class="card-actions justify-end mt-2">
                                    <button
                                        wire:click="restorePost({{ $post->id }})"
                                        class="btn btn-sm btn-success"
                                    >Restore</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($tab === 'role')
            <div class="space-y-2">
                @foreach ($roleUsers as $user)
                    <div
                        class="flex items-center justify-between p-3 bg-base-200 rounded shadow-sm">
                        <div>
                            <div class="font-extrabold">{{ $user->name }}
                            </div>
                            <div class="text-xs text-muted">
                                {{ $user->email }}
                            </div>
                            <div
                                class="mt-2 flex items-center gap-2"
                                aria-hidden="false"
                            >
                                @if ($user->is_banned)
                                    <span
                                        class="badge badge-error badge-sm">Banned</span>
                                @endif
                                @if (($user->reports_received_count ?? 0) > 0)
                                    <span
                                        class="badge badge-warning badge-sm">{{ $user->reports_received_count ?? 0 }}
                                        reports</span>
                                @endif
                                @if ($user->role === 'moderator')
                                    <span
                                        class="badge badge-outline badge-dash badge-sm"
                                    >{{ ucfirst($user->role) }}</span>
                                @elseif($user->role === 'user')
                                    <span
                                        class="badge badge-soft badge-sm">{{ ucfirst($user->role) }}</span>
                                @else
                                    <span
                                        class="badge badge-info badge-sm">{{ ucfirst($user->role) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($user->role === 'moderator')
                                <button
                                    wire:click="demoteUser({{ $user->id }})"
                                    class="btn btn-sm btn-warning"
                                >&#128293; Demote</button>
                            @else
                                @if ($user->is_banned)
                                    <button
                                        wire:click="unbanUser({{ $user->id }})"
                                        class="btn btn-sm btn-info"
                                    > &#128275; Unban</button>
                                @else
                                    @if (($user->reports_received_count ?? 0) > 0)
                                        <button
                                            wire:click="banUser({{ $user->id }})"
                                            class="btn btn-sm btn-error"
                                        >&#128274; Ban</button>
                                        <button
                                            wire:click="clearUserReports({{ $user->id }})"
                                            class="btn btn-sm btn-ghost"
                                        >Clear</button>
                                    @else
                                        <button
                                            wire:click="promoteUser({{ $user->id }})"
                                            class="btn btn-sm btn-success"
                                        >&#127882; Promote</button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
