const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

const YOU_SURE_TIMEOUT = 3000;

function MarketplaceItem({
    username,
    title,
    description,
    price_cents,
    onDelete = undefined,
}) {
    function DeleteButton() {
        const [deleting, setDeleting] = useState(false);

        const [youSure, setYouSure] = useState(false);
        const [ysTimeoutNumnber, setYsTimeoutNumber] = useState(undefined);

        // REACT doesn't like it when you try to set the state of an unmounted
        // component. This useEffect cleanup here is like a destructor. The
        // code in the inner most lambda gets called when the compoent
        // unmounts; in this case: when the item is deleted.
        useEffect(() => () => clearTimeout(ysTimeoutNumnber));

        function handleDelete() {
            if (!youSure) {
                setYouSure(true);
                setYsTimeoutNumber(
                    setTimeout(() => setYouSure(false), YOU_SURE_TIMEOUT)
                );
            } else {
                const deletePromise = onDelete(title);

                if (deletePromise instanceof Promise) {
                    setDeleting(true);
                    return deletePromise.finally(() => setDeleting(false));
                }
            }
        }

        return (
            <button onClick={handleDelete} disabled={deleting}>
                {(() => {
                    if (deleting) {
                        return "deleting...";
                    } else if (youSure) {
                        return "You Sure?";
                    } else {
                        return "Delete";
                    }
                })()}
            </button>
        );
    }

    return (
        <div
            style={{
                display: "flex",
                flexDirection: "column",

                padding: "1vh",
                borderRadius: "1vh",
                boxShadow: "0.5vh 0.5vh 1vh rgba(0,0,0,0.5)",
            }}
        >
            {/* Head Row: title and delete button */}
            <div
                style={{
                    display: "flex",

                    justifyContent: "space-between",
                    flexGrow: "1",
                }}
            >
                <div>{title}</div>
                {onDelete !== undefined ? <DeleteButton /> : ""}
            </div>

            {/* Description */}
            <div
                style={{
                    flexGrow: "2",
                }}
            >
                {description}
            </div>

            {/* Footer Row: username and price */}
            <div
                style={{
                    display: "flex",
                    justifyContent: "space-between",
                    flexGrow: "1",
                }}
            >
                <div>{username}</div>
                <div>${formatMoney(price_cents)}</div>
            </div>
        </div>
    );
}