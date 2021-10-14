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
