<div class="fab ">
    <button
        x-data="{
            show: false,
            scrollTop() { window.scrollTo({ top: 0, behavior: 'smooth' }) }
        }"
        x-show="show"
        @scroll.window="show = (window.pageYOffset > 200)"
        @click="scrollTop()"
        class="btn btn-circle btn-primary tooltip tooltip-left"
        data-tip="Back to top"
    >
        <x-lucid iconName="arrow-up-to-line" />
    </button>
</div>
