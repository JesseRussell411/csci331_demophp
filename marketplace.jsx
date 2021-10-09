const reactContainer = document.getElementById("react_container");
const {useState, useEffect} = React;

function Main(){
    const [testState, setTestState] = useState(6);

    useEffect(async () => {
        const result = await fetch("gethello.php?who=world", {
            method:"GET",
        });
        setTestState(await result.text());
    });

    return <p>main test {3+testState}<button onClick={() => setTestState(8)}>test set state</button></p>;
}

ReactDOM.render(
    <Main/>,
    reactContainer
);