<section>
    <form wire:submit.prevent="login">
        <label class="input validator input-neutral text-primary-content w-full">
            <x-lucid iconName="mail" />
            <input
                type="email"
                wire:model="email"
                placeholder="cat@email.com"
                maxlength="40"
                autocomplete="off"
                autofocus
                required
            />
        </label>
        <div class="validator-hint hidden leading-none text-xs">
            Enter valid email address
        </div>

        <label
            class="mt-3 validator input input-neutral text-primary-content w-full"
        >
            <x-lucid iconName="key-round" />
            <input
                type="password"
                wire:model="password"
                placeholder="password"
                maxlength="15"
                minlength="6"
                autocomplete="off"
                required
            />
        </label>
        <div class="validator-hint hidden leading-none text-xs">
            Enter valid password
        </div>

        <button class="btn btn-primary mt-3 w-full">
            <x-lucid iconName="log-in" /> Login
        </button>

        @if (session()->has('message'))
            <div class="alert alert-info mt-2">
                {{ session('message') }}
            </div>
        @endif

    </form>
</section>
