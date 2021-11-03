<?php
require("includes/connection.php");
$plan_id = $_GET['id'];

$stmt = $conn -> prepare("SELECT bill FROM expenses WHERE plan_id=?") or die($conn->error);
$stmt -> bind_param('i',$plan_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);
$result = $stmt -> get_result();
while($row = $result -> fetch_array()){
    $bills[] = $row['bill'];
}

$stmt = $conn -> prepare("DELETE FROM expenses WHERE plan_id=?") or die($conn->error);
$stmt -> bind_param('i',$plan_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);

$stmt = $conn -> prepare("DELETE FROM plan_group WHERE plan_id=?") or die($conn->error);
$stmt -> bind_param('i',$plan_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);

$stmt = $conn -> prepare("DELETE FROM plans WHERE plan_id=?") or die($conn->error);
$stmt -> bind_param('i',$plan_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);

//Deleting Bill from the server/directory
foreach($bills as $bill){
    unlink(realpath($bill));
}

header("location: home.php?msg=Plan removed successfully")

?>