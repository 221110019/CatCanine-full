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
    data-tip="About Us"
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
        <p class="text-center">Welcome to CatCanine, a friendly forum for
            cat🐈 and dog🐩
            lovers alike. <br> Here, you can share stories, ask for advice,
            exchange
            tips, and connect with others who appreciate the joys and challenges
            of life with pets.📝 <br> Whether you love cats, dogs, or both, this
            is a
            respectful and welcoming space to celebrate your furry companions.😻
        </p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>
