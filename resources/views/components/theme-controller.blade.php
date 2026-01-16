<label
    id="switch-theme"
    class="hover:animate-spin 
    btn-circle btn btn-soft btn-primary swap swap-rotate"
>
    <input
        type="checkbox"
        class="theme-controller"
        onchange="toggleTheme(this)"
    />

    <x-lucid
        class="swap-on"
        iconName="moon"
    ></x-lucid>
    <x-lucid
        class="swap-off"
        iconName="sun"
    ></x-lucid>
</label>

<script>
    const toggleTheme = (el) => {
        const theme = el.checked ? "nord" : "business";
        localStorage.setItem("theme", theme);
        document.documentElement.setAttribute("data-theme", theme);
    };
</script>
