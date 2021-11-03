<?php
require('includes/connection.php');
if (!isset($_SESSION['email'])) {
    header('location: home.php');
}
if(!isset($plan_id)){
    if(isset($_GET['id'])){
        $plan_id = $_GET['id'];
    }else{
        header('location: home.php');
    }    
}
$group = array();
$stmt = $conn -> prepare("SELECT plans.date_from,plans.date_to,plan_group.name FROM plans INNER JOIN plan_group ON plans.plan_id=plan_group.plan_id WHERE plans.plan_id=?") or die($conn -> error);
$stmt -> bind_param('i',$plan_id) or die($stmt -> error);
$stmt -> execute() or die($stmt -> error);
$result = $stmt -> get_result();
while ($row = $result -> fetch_array()) {
    $date_from = $row['date_from'];
    $date_to = $row['date_to'];
    $group[] = $row['name'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTRL BUDGET</title>

    <!--jQuery library-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- compiled and minified Bootstrap JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>


    <!-- compiled and minified Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <!---- External css file index.css placed in the folder css is linked-->
    <link rel="stylesheet" type="text/css" href="css/home.css" />

</head>

<body>
    <?php include('includes/header.php') //Navbar
    ?>

    <div class="container content">
        <div class="col-md-6 col-lg-12">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <h4 class="card-title my-2">Add New Expense</h4>
                </div>
                <div class="card-body">
                    <form action="expense_new_submit.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Title" class="form-label fw-bold">Title</label>
                            <input type="text" id="Title" class="form-control" name="expense_title" placeholder="Expanse Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="Date" class="form-label fw-bold">Date</label>
                            <input type="date" id="Date" class="form-control" min="<?php echo $date_from; ?>" max="<?php echo $date_to; ?>" name="expense_date" required>                    
                        </div>
                        <div class="mb-3">
                            <label for="Amount" class="form-label fw-bold">Amount Spent</label>
                            <input type="number" id="Amount" min="1" max="10000000" class="form-control" name="expense_amount" placeholder="Amount Spent" required>
                        </div>
                        <div class="mb-3">
                            <label for="By" class="form-label fw-bold">By</label>
                            <select name="expense_by" id="By" class="form-select" required>
                                <option value="" selected disabled>Choose</option>
                                <?php foreach ($group as $name){
                                    echo "<option value='".$name."'>".$name."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label fw-bold">Upload Bill</label>
                            <input class="form-control" type="file" id="formFile" name="uploadedimage" aria-describedby="allowed-extension" accept="image/*">
                            <div id="allowed-extension">bmp, gif, jpg, png are the allowed file format</div>
                        </div>
                        <!-- TO send the plan id when form is submitted -->
                        <input type="hidden" name="id" value="<?php echo $plan_id; ?>">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <?php include('includes/footer.php') //Footer
    ?>

</body>

</html>