const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function LoadingIndicator() {
    return <p>loading...</p>;
}

function Main() {
    const [items, setItems] = useState(null);
    const [loggedInUsername, setUsername] = useState(null);

    async function fetchItems() {
        const result = await fetch("marketplace/api/getAllItems.php", {
            method: "GET",
        });

        if (result.ok) return await result.json();
        else throw new Error(await result.text());
    }

    async function refreshItems() {
        setItems(await fetchItems());
    }



    async function handleDelete(title) {
        if (confirm(`Item '${title}' will be deleted.`)) {
            const result = await fetch(
                `marketplace/api/removeItem.php?title=${title}`,
                {
                    method: "GET",
                }
            );

            if (result.ok) {
                refreshItems();
                alert("👍Item Deleted.");
            } else {
                alert(
                    `👎Failed to delete item.\nstatus: ${
                        result.status
                    }\n\n${await result.text()}`
                );
            }
        }
    }

    // function DeleteButton({ title }) {
    //     const [deleting, setDeleting] = useState(false);
    //     async function handleDelete() {
    //         if (confirm(`Item '${title}' will be deleted.`)) {
    //             setDeleting(true);
    //             try {
    //                 const result = await fetch(
    //                     `marketplace/api/removeItem.php?title=${title}`,
    //                     {
    //                         method: "GET",
    //                     }
    //                 );

    //                 if (result.ok) {
    //                     refreshItems();
    //                     alert("👍Item Deleted.");
    //                 } else {
    //                     alert(
    //                         `👎Failed to delete item.\nstatus: ${
    //                             result.status
    //                         }\n\n${await result.text()}`
    //                     );
    //                 }
    //             } finally {
    //                 setDeleting(false);
    //             }
    //         }
    //     }
    //     return (
    //         <button onClick={handleDelete} disabled={deleting}>
    //             {deleting ? "deleting..." : "Delete Me"}
    //         </button>
    //     );
    // }

    // function MarketPlaceItem({
    //     username,
    //     title,
    //     description,
    //     price_cents,
    // }) {
    //     return (
    //         <div>
    //             {title}
    //             <ul>
    //                 <li>{username}</li>
    //                 <li>{description}</li>
    //                 <li>${formatMoney(parseInt(price_cents))}</li>
    //                 {loggedInUsername === username ? (
    //                     <li>
    //                         <DeleteButton title={title} />
    //                     </li>
    //                 ) : (
    //                     ""
    //                 )}
    //             </ul>
    //         </div>
    //     );
    // }

    useEffect(() => {
        if (items == null) {
            refreshItems();
        }
    });

    useEffect(async () => {
        if (loggedInUsername == null) {
            setUsername(await whoAmI());
        }
    });

    function formatMoney(amount_cents) {
        const dollars = Math.trunc(amount_cents / 100);
        const cents = amount_cents % 100;
        return `${dollars}.${`${cents}`.padStart(2, "0")}`;
    }

    return (
        <div>
            <h1>Place-holder marketplace, Work In Progress</h1>
            {items == null || loggedInUsername == null ? (
                <LoadingIndicator />
            ) : (
                <ul>
                    {items.map((i) => (
                        <li>
                            <MarketplaceItem
                                key={i[1]}
                                username={i[0]}
                                title={i[1]}
                                description={i[2]}
                                price_cents={i[3]}
                                onDelete={
                                    i[0] === loggedInUsername
                                        ? handleDelete
                                        : undefined
                                }
                            />
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}

ReactDOM.render(<Main />, reactContainer);
