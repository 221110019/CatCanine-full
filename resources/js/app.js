import "./bootstrap";

import {
    ArrowUpToLine,
    AtSign,
    Bone,
    Cat,
    CircleX,
    createIcons,
    Dog,
    EllipsisVertical,
    ImagePlus,
    KeyRound,
    LogIn,
    LogOut,
    Mail,
    Megaphone,
    Moon,
    PawPrint,
    Send,
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
        ImagePlus,
        LogOut,
        CircleX,
        Send,
        EllipsisVertical,
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
