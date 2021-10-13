const reactContainer = document.getElementById("react_container");
const {useState, useEffect} = React;

function LoadingIndicator(){
    return <p>loading...</p>;
}

function Main(){
    const [items, setItems] = useState(null);

    useEffect(async () => {
        if (items == null){
        const result = await fetch("marketplace/api/getAllItems.php", {
            method: "GET",
        });

        if (result.ok){
            setItems(await result.json());
        }
    }
    });

    function formatMoney(amount_cents){
        const dollars = Math.trunc(amount_cents / 100);
        const cents = amount_cents % 100;
        return `${dollars}.${cents}`;
    }

    return <div>
        <h1>Place-holder marketplace, Work In Progress</h1>
        {
            items == null ? <LoadingIndicator/> :
        <ul>
        {items.map(i => <li>{i[1]}<ul>
            <li>{i[0]}</li>
            <li>{i[2]}</li>
            <li>${formatMoney(parseInt(i[3]))}</li>
        </ul></li>)}
        </ul>}
    </div>
}

ReactDOM.render(
    <Main/>,
    reactContainer
);