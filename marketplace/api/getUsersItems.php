<?php
require_once '../functions.php';

$username = $_GET['username'];

echo json_encode(getUsersMarketplaceItems($username));
?>