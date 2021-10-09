const reactContainer = document.getElementById("react_container");
const {useState} = React;

function Main(){
    const [testState, setTestState] = useState(6);
    return <p>main test {3+testState}<button onClick={() => setTestState(8)}>test set state</button></p>;
}

ReactDOM.render(
    <Main/>,
    reactContainer
);