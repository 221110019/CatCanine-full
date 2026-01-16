<section>
    <form wire:submit.prevent="register">
        <label class="input input-neutral text-primary-content w-full">
            <x-lucid iconName="at-sign" />
            <input
                type="text"
                wire:model="name"
                placeholder="username"
                maxlength="40"
                autocomplete="off"
                required
            />
        </label>

        <label class="mt-3 input  input-neutral text-primary-content w-full">
            <x-lucid iconName="mail" />
            <input
                type="email"
                wire:model="email"
                placeholder="canine@email.com"
                maxlength="20"
                autocomplete="off"
                required
            />
        </label>

        <label class="mt-3 input  input-neutral text-primary-content w-full">
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


        <button
            type="submit"
            class="btn btn-primary mt-3 w-full"
        >
            <x-lucid iconName="user-round-plus" /> Register
        </button>

        @if (session()->has('message'))
            <div class="alert alert-info mt-2">
                {{ session('message') }}
            </div>
        @endif

    </form>
</section>
