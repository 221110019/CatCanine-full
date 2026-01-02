                        <div
                            class="mask mask-heart shadow-2xl shadow-primary-content items-center flex mx-auto">
                            <button
                                wire:click="toggleLike"
                                data-tip="Like"
                                class=" tooltip tooltip-left btn {{ $liked ? 'btn-error' : '' }}"
                            >
                                {{ $likesCount }}
                            </button>
                        </div>
