<div x-data="{
    user: {
        name: '{{ Auth::user()->name }}',
        role: '{{ Auth::user()->role }}'
    }
}">
    <div class="navbar bg-ghost shadow-sm px-4 w-full">
        <div class="flex-1 gap-4">
            <x-logo />
        </div>

        <div class="flex-none">
            <span
                class="tooltip tooltip-bottom"
                data-tip="Coming soon"
            >
                <template x-if="user.role === 'moderator'">
                    <a
                        href="/moderator-panel"
                        class="btn btn-soft btn-secondary"
                        disabled
                    >
                        Moderator Panel
                    </a>
                </template>
                <template x-if="user.role === 'master'">
                    <a
                        href="/master-panel"
                        class="btn btn-soft btn-secondary"
                        disabled
                    >
                        Master Panel
                    </a>
                </template>
            </span>

            <x-theme-controller />

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="inline"
            >
                @csrf
                <button
                    type="submit"
                    class="btn btn-outline btn-error btn-square tooltip tooltip-bottom"
                    data-tip="Log out"
                >
                    <x-lucid iconName="log-out" />
                </button>
            </form>
        </div>
    </div>

    <div class="block text-center w-full">
        <span class="btn btn-sm pointer-events-none">
            <div
                class="text-lg text-secondary before:content-['@']"
                x-text="user.name"
            ></div>
            <span
                class="h-1/2 px-2 skeleton font-extralight font-mono uppercase"
                x-text="user.role"
            ></span>
        </span>
    </div>
</div>
