"use strict";
// Відкриваємо та закриваємо меню на вузькому екрані.
const toggle = document.querySelector(".menu-toggle");
if (toggle)
    toggle.addEventListener("click", () => {
        const nav = document.getElementById("mainnav");
        const open = nav.classList.toggle("open");
        toggle.setAttribute("aria-expanded", String(open));
    });
