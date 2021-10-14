const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function MarketplaceItem({
    username,
    title,
    description,
    price_cents,
    onDelete = undefined,
}) {
    const [deleting, setDeleting] = useState(false);

    async function handleDelete(event) {
        event.preventDefault();

        
        const promise = onDelete(title);
        if (promise instanceof Promise){
            promise.finally(() => setDeleting(false));
        }
        setDeleting(true);
    }
    function formatMoney(amount_cents) {
        const dollars = Math.trunc(amount_cents / 100);
        const cents = amount_cents % 100;
        return `${dollars}.${`${cents}`.padStart(2, "0")}`;
    }
    return (
        <div>
            {title}
            <ul>
                <li>{username}</li>
                <li>{description}</li>
                <li>${formatMoney(parseInt(price_cents))}</li>
                {onDelete != undefined ? (
                    <li>
                        <button onClick={handleDelete} disabled={deleting}>
                            {deleting ? "deleting..." : "Delete"}
                        </button>
                    </li>
                ) : (
                    ""
                )}
            </ul>
        </div>
    );
}
