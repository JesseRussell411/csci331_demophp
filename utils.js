/**
 * @retuns {string} Username of who's logged in or an empty string if nobody's logged in.
 */
async function whoAmI() {
    const result = await fetch("api/validate.php", {
        method: "GET",
    });

    if (result.ok) {
        return await result.text();
    } else if (result.status === 401) {
        return "";
    } else {
        throw new Error(awaitresult.text());
    }
}

/**
 * @returns the amount in cents formatted in a string of form: d.cc where d in dollars and c is cents. example: 5.34
 */
function formatMoney(amount_cents) {
    const dollars = Math.trunc(amount_cents / 100);
    const cents = amount_cents % 100;
    return `${dollars}.${`${cents}`.padStart(2, "0")}`;
}