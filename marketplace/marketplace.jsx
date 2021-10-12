const reactContainer = document.getElementById("react_container");
const {useState, useEffect} = React;

function Main(){
    const [items, setItems] = useState([]);

    useEffect(async () => {
        const result = await fetch("marketplace/api/getAllItems.php", {
            method: "GET",
        });

        if (result.ok){
            setItems(await result.json());
        }
    });

    return <div>
        <ul>
        {items.map(i => <li>{i[1]}<ul>
            <li>{i[0]}</li>
            <li>{i[2]}</li>
        </ul></li>)}
        </ul>
    </div>

    
    // const [testState, setTestState] = useState(6);

    // async function testFetch(){
    //     const result = await fetch("validate_route.php", {
    //         method:"GET",
    //     });
        
    //     if (result.ok)
    //         setTestState("You are logged in" + result.status);
    //     else
    //         setTestState("You are not logged in" + result.status);
    // }

    // return <p>main test {3+testState}<button onClick={testFetch}>test fetch and set state</button></p>;
}

ReactDOM.render(
    <Main/>,
    reactContainer
);