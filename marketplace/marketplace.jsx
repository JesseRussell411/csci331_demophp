const reactContainer = document.getElementById("react_container");
const {useState, useEffect} = React;

function Main(){
    const [testState, setTestState] = useState(6);

    async function testFetch(){
        const result = await fetch("validate_route.php", {
            method:"GET",
        });
        
        if (result.ok)
            setTestState("You are logged in" + result.status);
        else
            setTestState("You are not logged in" + result.status);
    }

    return <p>main test {3+testState}<button onClick={testFetch}>test fetch and set state</button></p>;
}

ReactDOM.render(
    <Main/>,
    reactContainer
);