const reactContainer = document.getElementById("react_container");
const { useState, useEffect } = React;

function LoadingIndicator() {
  return <p>loading...</p>;
}

function Main() {
  const [items, setItems] = useState(null);
  const [username, setUsername] = useState(null);
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

  /**
   * @retuns {string} Username of who's logged in or an empty string if nobody's logged in.
   */
  async function whoAmI() {
    const result = await fetch("api/validate.php", {
      method: "GET",
    });
    if (result.ok) return await result.text();
    else return "";
  }

  function DeleteButton({ title }) {
    const [deleting, setDeleting] = useState(false);
    async function handleDelete() {
      if (confirm(`Item '${title}' will be deleted.`)) {
        setDeleting(true);
        try {
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
        } finally {
          setDeleting(false);
        }
      }
    }
    return <button onClick={handleDelete} disabled={deleting}>{deleting ? "deleting..." : "Delete Me"}</button>;
  }

  useEffect(() => {
    if (items == null) {
      refreshItems();
    }
  });

  useEffect(async () => {
    if (username == null) {
      setUsername(await whoAmI());
    }
  });

  function formatMoney(amount_cents) {
    const dollars = Math.trunc(amount_cents / 100);
    const cents = amount_cents % 100;
    return `${dollars}.${`${cents}`.padEnd(2, "0")}`;
  }

  return (
    <div>
      <h1>Place-holder marketplace, Work In Progress</h1>
      {items == null ? (
        <LoadingIndicator />
      ) : (
        <ul>
          {items.map((i) => (
            <li>
              {i[1]}
              <ul>
                <li>{i[0]}</li>
                <li>{i[2]}</li>
                <li>${formatMoney(parseInt(i[3]))}</li>
                {username === i[0] ? (
                  <li>
                    <DeleteButton title={i[1]} />
                  </li>
                ) : (
                  ""
                )}
              </ul>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

ReactDOM.render(<Main />, reactContainer);
