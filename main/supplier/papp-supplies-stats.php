<?php
require_once('header.php');

$statement = $pdo->prepare("UPDATE requestsproduct SET inventoryStatus=? WHERE id=?");
$statement->execute(array($_REQUEST['task'], $_REQUEST['id']));
header('Location: tendarp.php');
exit;
?>
