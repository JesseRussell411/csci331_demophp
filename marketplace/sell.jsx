const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function LoadingIndicator() {
  return <p>loading...</p>;
}

function Main() {
  const [submitting, setSubmitting] = useState(false);
  async function handleSubmit(e) {
    try {
      e.preventDefault();

      // begin submitting
      setSubmitting(true);

      // get form data
      const title = e.target.elements.title.value;
      const description = e.target.elements.description.value;
      const price_dollars = parseInt(e.target.elements.price_dollars.value);
      const price_cents = parseInt(e.target.elements.price_cents.value);

      // construct request body
      const formData = new FormData();
      formData.append("title", title);
      formData.append("description", description);
      formData.append(
        "price_cents",
        Math.trunc(price_cents) + 100 * Math.trunc(price_dollars)
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
    <form onSubmit={handleSubmit}>
      <div>
        <label htmlFor="title">Title</label>
        <br />
        <input type="text" id="title" name="title"></input>
      </div>
      <div>
        <label htmlFor="description">Description</label>
        <br />
        <textarea id="description" name="description"></textarea>
      </div>
      <div>
        <label>Price</label>
        <br />
        {"$"}
        <input type="number" id="price_dollars" name="price_dollars"></input>
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
        <input type="number" id="price_cents" name="price_cents"></input>
      </div>
      <div>
        <input
          type="submit"
          disabled={submitting}
          value={submitting ? "submitting..." : "Submit Item"}
        ></input>
      </div>
    </form>
  );
}

ReactDOM.render(<Main />, reactContainer);
