<?php
require 'database.php';
session_start();
if(!isset($_SESSION['user']) && (!isset($_SESSION['user_id']) && (!isset($_SESSION['rol'])))){
    header("location:login.php");
}

if($_SESSION['rol']=='user'){
    header("location:pqr_form.php");
}

$id=$_GET['id'];
$delete= $conn->prepare("DELETE FROM pqrs WHERE idPqrs='$id'");
$delete->execute();

header('location:pqrs_admin')


?>