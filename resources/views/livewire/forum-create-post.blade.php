<div
    class="collapse collapse-arrow  glass glass-25 bg-secondary text-secondary-content focus:bg-accent focus:text-accent-content"
    tabindex="0"
>
    <div class="collapse-title font-semibold text-center">Share
        your
        thought!
    </div>
    <div class="collapse-content">
        <form
            wire:submit.prevent="createPost"
            enctype="multipart/form-data"
        >
            <div class="form-control w-full">
                <textarea
                    wire:model="caption"
                    class="validator textarea textarea-primary text-primary-content h-24 mb-4 w-full @error('caption')textarea-error @enderror"
                    placeholder="What's on your mind?"
                    maxlength="120"
                    required
                ></textarea>
                @error('caption')
                    <div class="text-error text-sm mt-1">{{ $message }}
                    </div>
                @enderror

                @if ($picture)
                    <div class="mb-4">
                        <div class="relative w-fit">
                            <img
                                src="{{ $picture->temporaryUrl() }}"
                                alt="Preview"
                                class="max-w-xs mask mask-squircle"
                            >
                            <button
                                type="button"
                                class="btn btn-circle absolute top-2 right-2"
                                wire:click="removeImage"
                            >
                                x
                            </button>
                        </div>
                    </div>
                @endif

                @error('picture')
                    <div class="text-error text-sm mt-1">{{ $message }}
                    </div>
                @enderror

                <div class="flex items-center gap-4">
                    <label
                        class="flex items-center gap-2 btn btn-outline cursor-pointer"
                    >
                        <x-lucid iconName="image-plus" />
                        Add Photo
                        <input
                            type="file"
                            wire:model="picture"
                            accept=".jpg,.webp"
                            class="hidden"
                        >
                    </label>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                        wire:target="createPost,picture"
                    >
                        <span
                            wire:loading.remove
                            wire:target="createPost"
                        >
                            <x-lucid iconName="send" /> Post
                        </span>
                        <span
                            wire:loading
                            wire:target="createPost"
                            class="loading loading-dots"
                        ></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
