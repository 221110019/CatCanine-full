<span
    onclick="about_us.showModal()"
    class="btn
    btn-link
    hover:animate-pulse
    align-middle
    inline-flex
    gap-0
    text-primary
    font-extrabold
    font-mono
    overline
    tooltip
    tooltip-bottom
    "
    data-tip="About Us & Rules"
>
    <x-lucid
        class="whitespace-nowrap"
        iconName="cat"
    />
    <span class="whitespace-nowrap">CatCanine</span>
    <x-lucid iconName="dog" />
</span>

<dialog
    id="about_us"
    class="modal"
>
    <div class="modal-box">

        <div class="tabs tabs-lift justify-center">
            <input
                type="radio"
                name="logo_tabs"
                class="tab text-center"
                aria-label="About Us"
            />
            @php
                $paragraphs = [
                    "Welcome to CatCanine, a friendly forum for
                    cat🐈 and dog🐩 lovers alike. Here, you can share
                    stories, ask for advice,
                    exchange
                    tips, and connect with others who appreciate the joys and
                    challenges
                    of life with pets.📝",
                    "Whether you love cats, dogs, or both,
                    this
                    is a
                    respectful and welcoming space to celebrate your furry
                    companions.😻",
                ];
            @endphp
            <div
                class="tab-content bg-base-100 border-base-300 p-6 text-justify">
                @foreach ($paragraphs as $para)
                    <div class="indent-8 leading-relaxed">
                        {{ $para }}
                    </div>
                @endforeach
            </div>

            <input
                type="radio"
                name="logo_tabs"
                class="tab"
                aria-label="Role Indicator"
                checked="checked"
            />
            <div
                class="tab-content bg-base-100 border-base-300 p-6 text-center font-bold">
                <div class="italic text-shadow-lg text-shadow-primary">Master
                </div>
                <div class="text-shadow-lg/50 text-shadow-secondary">
                    Moderators</div>
                <div class='before:content-["►"] after:content-["◄"]'>Current
                    User</div>
                <div>Regular User</div>
                <div class="text-error opacity-30">Banned User</div>
            </div>

            <input
                type="radio"
                name="logo_tabs"
                class="tab"
                aria-label="Rules"
            />
            @php
                $rules = [
                    'MASTER will choose the MODERATORS to oversee forum activity.',
                    'No spamming or unrelated advertising.',
                    'No abusive or offensive language.',
                    'Keep posts and comments on topic: cats, dogs, or pet care.',
                    'Report suspicious posts or users to MODERATORS.',
                    'Problematic post will be archived.',
                    'Problematic users will be suspended.',
                    'Engage positively: support, encourage, and educate fellow members.',
                ];
            @endphp

            <div class="tab-content bg-base-100 border-base-300 p-6">
                <ol class="list-decimal p-2 text-justify">
                    @foreach ($rules as $rule)
                        <li>{{ $rule }}</li>
                    @endforeach
                </ol>
            </div>

        </div>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>
