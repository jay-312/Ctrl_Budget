<?php
require("includes/connection.php");
$plan_id = $_GET['id'];
$exp_id = $_GET['exp_id'];

$stmt = $conn -> prepare("SELECT spent_by,amount,bill FROM expenses WHERE expense_id=?") or die($conn->error);
$stmt -> bind_param('i',$exp_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);
$result = $stmt -> get_result();
$row = $result -> fetch_array();
$spent_by = $row['spent_by'];
$amount = $row['amount'];
$bill = $row['bill'];
//Updating Plan Group
$stmt = $conn -> prepare("UPDATE plan_group SET amount=amount-? WHERE plan_id=? AND name=?") or die($conn->error);
$stmt -> bind_param('iis',$amount,$plan_id,$spent_by) or die($stmt->error);
$stmt -> execute() or die($stmt->error);
//Deleting Expense row
$stmt = $conn -> prepare("DELETE FROM expenses WHERE expense_id=?") or die($conn->error);
$stmt -> bind_param('i',$exp_id) or die($stmt->error);
$stmt -> execute() or die($stmt->error);
//Deleting bill from the directory
if(isset($bill)){  
    unlink(realpath($bill));
}

header("location: plan_view.php?id=$plan_id&msg=expense removed successfully")



?>