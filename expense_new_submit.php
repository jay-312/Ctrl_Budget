<?php
require("includes/connection.php");
function GetImageExtension($imagetype) {
    if (empty($imagetype)) return false;
    switch ($imagetype) {
        case 'image/bmp':
            return '.bmp';
        case 'image/gif':
            return '.gif';
        case 'image/jpeg':
            return '.jpg';
        case 'image/png':
            return '.png';
        default:
            return false;
    }
}

$plan_id = $_POST['id'];
$expense_title = $_POST['expense_title'];
$expense_date = $_POST['expense_date'];
$expense_amount = $_POST['expense_amount'];
$expense_by = $_POST['expense_by'];
//Updating amount in plan_group
$stmt = $conn -> prepare("UPDATE plan_group SET amount=amount+? WHERE name=? AND plan_id=?") or die($conn -> error);
$stmt -> bind_param('isi',$expense_amount, $expense_by, $plan_id) or die($stmt -> error);
$stmt -> execute() or die($stmt -> error);
//commiting expense in the database
$stmt = $conn -> prepare("INSERT INTO expenses (plan_id, title, date, amount, spent_by) VALUES (?,?,?,?,?)") or die($conn -> error);
$stmt -> bind_param('issis', $plan_id, $expense_title, $expense_date, $expense_amount, $expense_by) or die($stmt -> error);
$stmt -> execute() or die($stmt -> error);
$expense_id = $conn -> insert_id;
//checking if bill is uploaded
if (!empty($_FILES["uploadedimage"]["name"])) {
    $file_name = $_FILES["uploadedimage"]["name"];
    $temp_name = $_FILES["uploadedimage"]["tmp_name"];
    $imgtype = $_FILES["uploadedimage"]["type"];
    $ext = GetImageExtension($imgtype);
    $imagename = date("d-m-Y") . "-" . time() . $ext;
    $target_path = "img/" . $imagename;
    if ($ext && move_uploaded_file($temp_name, $target_path)) {
        $add_bill_address = $conn -> prepare("UPDATE expenses SET bill=? WHERE expense_id=? AND plan_id=?") or die($conn -> error);
        $add_bill_address -> bind_param('sii', $target_path, $expense_id, $plan_id) or die($add_bill_address -> error);
        $add_bill_address -> execute() or die($add_bill_address -> error);
        header("location: plan_view.php?id=$plan_id&msg=expense added successfully");
    }
    else{
        header("location: plan_view.php?id=$plan_id&msg=The Uploaded File is not image format");
    }
}else{
    header("location: plan_view.php?id=$plan_id&msg=expense added successfully");
}
