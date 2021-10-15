<?php
require_once 'header.php';
?>
    <!-- react getting-started guide from: https://reactjs.org/docs/add-react-to-a-website.html#add-react-in-one-minute -->
    <h1>Marketplace</h1>
    <div id="react_container"></div>

    <!-- Load React. -->
    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
    <!-- slow babel translator for jsx (fine for this I guess) -->
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    <!-- include utils -->
    <script type="text/javascript" src="utils.js"></script>
    <!-- coundn't figure out how to make modules work with babel -->
    <script type ="text/babel"src="marketplace/MarketplaceItem.jsx"></script>
    <!-- Load React component. -->
    <script type ="text/babel"src="marketplace/marketplace.jsx"></script>
<?php
require_once 'footer.php';
?>