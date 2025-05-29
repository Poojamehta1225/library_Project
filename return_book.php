<?php
session_start();
include("data_class.php");

if (!isset($_GET['returnid']) || !isset($_GET['userlogid'])) {
    header("Location: otheruser_dashboard.php?msg=MissingParams");
    exit();
}

$returnid = $_GET['returnid'];
$userloginid = $_GET['userlogid'];

$u = new data;
$u->setconnection();

// Call returnbook() method
$u->returnbook($returnid);

// Redirect user back to dashboard
header("Location: otheruser_dashboard.php?userlogid=$userloginid&msg=Returned");
exit();
?>
