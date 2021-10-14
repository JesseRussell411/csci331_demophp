const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function LoadingIndicator() {
    return <p>loading...</p>;
}

function Main() {
    const [items, setItems] = useState(null);
    const [loggedInUsername, setUsername] = useState(null);

    const sortTypes = {
        username: (a, b) => a.username.localeCompare(b.username),
        title: (a, b) => a.title.localeCompare(b.title),
        description: (a, b) => a.description.localeCompare(b.description),
        price: (a, b) => Math.sign(a.price_cents - b.price_cents),
    };

    async function fetchItems() {
        const result = await fetch("marketplace/api/getAllItems.php", {
            method: "GET",
        });

        if (result.ok) {
            const items = (await result.json()).map((row) => ({
                username: row[0],
                title: row[1],
                description: row[2],
                price_cents: row[3],
            }));
            items.sort(sortTypes.title);
            return items;
        } else {
            throw new Error(await result.text());
        }
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
            } else {
                alert(
                    `👎Failed to delete item.\nstatus: ${
                        result.status
                    }\n\n${await result.text()}`
                );
            }
        }
    }

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

    function sortBy(sortType) {
            setItems([...items].sort(sortType));
        
    }

    function handleSortFormSubmit(e) {
        e.preventDefault();
        const elements = e.target.elements;
        const sortTypeId = elements.sortType.value;
        const reverse = elements.reverse.checked;
        console.log(elements.reverse);
        const sortType = (() => {
            if (reverse) {
                return (a, b) =>
                    (isNonEmptyString(sortTypeId)
                        ? sortTypes[sortTypeId]
                        : sortTypes.title)(b, a);
            } else {
                return isNonEmptyString(sortTypeId)
                    ? sortTypes[sortTypeId]
                    : sortTypes.title;
            }
        })();

        sortBy(sortType);
    }

    return (
        <div>
            <div>
                <form onSubmit={handleSortFormSubmit}>
                    <div>
                        <input
                            type="radio"
                            name="sortType"
                            value="username"
                            id="sortType-username"
                        />
                        <label htmlFor="sortType-username">Username</label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            name="sortType"
                            value="title"
                            id="sortType-title"
                        />
                        <label htmlFor="sortType-title">Title</label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            name="sortType"
                            value="description"
                            id="sortType-description"
                        />
                        <label htmlFor="sortType-description">
                            Description
                        </label>
                    </div>
                    <div>
                        <input
                            type="radio"
                            name="sortType"
                            value="price"
                            id="sortType-price"
                        />
                        <label htmlFor="sortType-price">Price</label>
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            name="reverse"
                            id="sort-reverse"
                        />
                        <label htmlFor="sort-reverse">Reverse</label>
                    </div>
                    <div>
                        <input type="submit" value="sort"></input>
                    </div>
                </form>
            </div>
            <h1>Place-holder marketplace, Work In Progress</h1>
            {items == null || loggedInUsername == null ? (
                <LoadingIndicator />
            ) : (
                <div>
                    {items.map((i) => (
                        <div style={{ margin: "10px" }}>
                            <MarketplaceItem
                                key={i.username + i.title}
                                username={i.username}
                                title={i.title}
                                description={i.description}
                                price_cents={i.price_cents}
                                onDelete={
                                    i.username === loggedInUsername
                                        ? handleDelete
                                        : undefined
                                }
                            />
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}

ReactDOM.render(<Main />, reactContainer);
