import "./bootstrap";

import {
    ArrowUpToLine,
    AtSign,
    Bone,
    Cat,
    CircleX,
    createIcons,
    Dog,
    KeyRound,
    LogIn,
    LogOut,
    Mail,
    Megaphone,
    Moon,
    PawPrint,
    Sun,
    UserRoundPlus,
} from "lucide";
createIcons({
    icons: {
        LogIn,
        UserRoundPlus,
        Sun,
        Moon,
        Cat,
        Dog,
        Mail,
        KeyRound,
        AtSign,
        Megaphone,
        LogOut,
        CircleX,
        PawPrint,
        Bone,
        ArrowUpToLine,
    },
});

window.addEventListener("toast", (e) => {
    const toast = document.getElementById("toast");
    const msg = document.getElementById("message");
    toast.classList.remove("hidden");
    msg.textContent = e.detail.message;
    setTimeout(() => toast.classList.add("hidden"), 2500);
});

document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme") || "business";
    document.documentElement.setAttribute("data-theme", savedTheme);
    document.querySelector(".theme-controller").checked = savedTheme === "nord";
});

document.addEventListener("livewire:init", () => {
    Livewire.hook("element.updated", () => {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
});
