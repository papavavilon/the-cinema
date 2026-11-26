"use strict";
// Просимо підтвердження перед змінами та відкриваємо друк рахунку.
document.querySelectorAll("form[data-confirm]").forEach((form) =>
    form.addEventListener("submit", (event) => {
        if (!confirm(form.dataset.confirm)) event.preventDefault();
    }),
);

const printButton = document.getElementById("print-booking");
if (printButton) printButton.addEventListener("click", () => window.print());
