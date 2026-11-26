"use strict";
// Оновлюємо підсумок вибраних місць. Остаточну перевірку виконує PHP.
const form = document.getElementById("seat-form");
if (form) {
    const quantities = [...form.querySelectorAll("input[data-price]")],
        seats = [...form.querySelectorAll('input[name="seats[]"]')];
    const update = () => {
        let count = 0,
            total = 0,
            valid = true;
        quantities.forEach((input) => {
            const n = Number(input.value);
            if (!Number.isInteger(n) || n < 0 || n > 5) valid = false;
            count += n;
            total += n * Number(input.dataset.price);
        });
        const selected = seats.filter((s) => s.checked).length;
        document.getElementById("selection-summary").textContent = `${selected} of ${count} seats selected`;
        document.getElementById("selection-total").textContent = `${total.toFixed(2)} DKK`;
        document.getElementById("seat-continue").disabled =
            !valid || count < 1 || count > 5 || selected !== count;
    };
    form.addEventListener("change", update);
    form.addEventListener("input", update);
    update();
}
