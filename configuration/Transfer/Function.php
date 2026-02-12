<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/Function/sql.php");
$conn = dbConnect();
$message = new USER();

$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt = $conn->prepare($viesConn);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$internetid = $row['id'];


$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);
