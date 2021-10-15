const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function getFullPrice_cents(price_dollars, price_cents) {
    return Math.trunc(price_cents) + 100 * Math.trunc(price_dollars);
}

function LoadingIndicator() {
    return <p>loading...</p>;
}

function Main() {
    const [username, setUsername] = useState(null);
    const [submitting, setSubmitting] = useState(false);
    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [price_dollars, setPrice_dollars] = useState("");
    const [price_cents, setPrice_cents] = useState("");

    useEffect(async () => {
        if (username === null) {
            const name = await whoAmI();

            setUsername(typeof name === "string" ? name : "");
        }
    });

    async function handleSubmit(e) {
        try {
            e.preventDefault();

            // begin submitting
            setSubmitting(true);

            // get form data
            const title = e.target.elements.title.value;
            const description = e.target.elements.description.value;
            const price_dollars_str = e.target.elements.price_dollars.value;
            const price_cents_str = e.target.elements.price_cents.value;
            if (price_dollars_str === "" && price_cents_str === "") {
                ifPostFailed(null, "Price is blank");
                return;
            }
            const price_dollars =
                price_dollars_str === "" ? 0 : parseInt(price_dollars_str);
            const price_cents =
                price_cents_str === "" ? 0 : parseInt(price_cents_str);

            // construct request body
            const formData = new FormData();
            formData.append("title", title);
            formData.append("description", description);
            formData.append(
                "price_cents",
                getFullPrice_cents(price_dollars, price_cents)
            );

            // send request
            const result = await fetch("marketplace/api/createItem.php", {
                method: "post",
                body: formData,
            });

            // see if the request worked or not
            const posted = result.status === 201;
            const message = await result.text();
            if (posted) alert("👍\nItem posted to marketplace.");
            else ifPostFailed(result.status, message);
        } catch (e) {
            ifPostFailed(null, `Site Error:\n${e}`);
            throw e;
        } finally {
            setSubmitting(false);
        }

        function ifPostFailed(status, message) {
            alert(
                `👎\nFailed to post item to marketplace${
                    status != null ? `\nstatus: ${status}` : ""
                }\n\n${message}`
            );
        }
    }

    return (
        <div id="sellItem">
            <div className="tile" id="sellItemInfo">
                <form onSubmit={handleSubmit}>
                    <div>
                        <label htmlFor="title">Title</label>
                        <br />
                        <input
                            type="text"
                            id="title"
                            name="title"
                            onChange={(e) => setTitle(e.target.value)}
                        ></input>
                    </div>
                    <div>
                        <label htmlFor="description">Description</label>
                        <br />
                        <textarea
                            id="description"
                            name="description"
                            onChange={(e) => setDescription(e.target.value)}
                        ></textarea>
                    </div>
                    <div style={{marginBottom:"10px"}}>
                        <label>Price</label>
                        <br />
                        <span style={{fontSize: "20px", marginRight: "10px"}}>$</span>
                        <input
                            type="number"
                            id="price_dollars"
                            name="price_dollars"
                            min="0"
                            onChange={(e) => setPrice_dollars(e.target.value)}
                        ></input>
                        <div
                            style={{
                                display: "inline-block",
                                fontSize: ".3em",
                                marginLeft: "5px",
                                marginRight: "5px",
                            }}
                        >
                            {" ⚫ "}
                        </div>
                        <input
                            type="number"
                            id="price_cents"
                            name="price_cents"
                            max="99"
                            min="0"
                            onChange={(e) => setPrice_cents(e.target.value)}
                        ></input>
                    </div>
                    <div>
                        <input
                            type="submit"
                            disabled={submitting}
                            value={submitting ? "submitting..." : "Submit Item"}
                        ></input>
                    </div>
                </form>
            </div>
            <div id="sellItemPreview">
                <h3>preview</h3>
                <MarketplaceItem
                    username={username}
                    title={title}
                    description={description}
                    price_cents={getFullPrice_cents(price_dollars, price_cents)}
                />
            </div>
        </div>
    );
}

ReactDOM.render(<Main />, reactContainer);
