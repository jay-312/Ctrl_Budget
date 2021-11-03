<?php
require('includes/connection.php');
if (!isset($_SESSION['email'])) {
    header('location: home.php');
}
if(isset($_GET['msg'])){
    echo "<script> window.alert('".$_GET['msg']."') </script>";
}
if (!isset($_GET['id'])) {
    header('location: home.php');
}
$plan_id =  $_GET['id'];
$plan_detail = $conn -> prepare("SELECT plans.*,SUM(plan_group.amount) as spent FROM plans INNER JOIN plan_group ON plans.plan_id=plan_group.plan_id WHERE plans.plan_id=?") or die($conn -> error);
$plan_detail -> bind_param('i',$plan_id) or die($plan_detail -> error) ;
$plan_detail -> execute() or die($plan_detail -> error) ;
$result = $plan_detail -> get_result();
$row_plan = $result -> fetch_array();
$plan_title = $row_plan['title'];
$plan_people = $row_plan['people'];
$plan_budget = $row_plan['budget'];
$date_from = date_create($row_plan['date_from']);
$date_from = date_format($date_from,'jS M');
$date_to = date_create($row_plan['date_to']);
$date_to = date_format($date_to,'jS M Y');
$plan_date = $date_from.' - '.$date_to;
$remaining_amount = $plan_budget - $row_plan['spent'];

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

<main class="container content">
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <!-- Row for Plan + expenses -->
                <div class="row g-0">
                    <div class="row g-0">
                        <div class="col-lg-10">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-center text-white ">
                                    <div class="row h5 fw-normal mt-2">
                                        <div class="d-inline col-9  m-auto"><?php echo $plan_title; ?></div>
                                        <div class="d-inline col-3">
                                            <i class="fas fa-user"></i> <?php echo $plan_people; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="d-inline-flex flex-wrap">
                                            <h5 class="my-2 me-auto">Budget :</h5>
                                                <p class="my-auto">&#8377; <?php echo $plan_budget; ?></p>
                                        </div>
                                        <div class="d-inline-flex flex-wrap">
                                            <h5 class="my-2 me-auto">Remaining Amount :</h5>
                                                <?php if($remaining_amount>0){ ?>
                                                    <p class="my-auto text-success">&#8377; <?php echo $remaining_amount; ?></p>
                                                <?php }else if($remaining_amount < 0) { ?>
                                                    <p class="my-auto text-danger">overspent by &#8377; <?php echo abs($remaining_amount); ?></p>                                                
                                                <?php }else{ ?>
                                                    <p class="my-auto"> &#8377; <?php echo $remaining_amount; ?></p>
                                                <?php } ?>
                                        </div>
                                        <div class="d-inline-flex flex-wrap">
                                            <h5 class="my-2 me-auto">Date :</h5>
                                                <p class="my-auto"><?php echo $plan_date; ?></p>
                                        </div>
                                        <div class="d-grid">
                                            <a class="btn btn-outline-success my-2" href="expanse_distribution.php?id=<?php echo $plan_id; ?>">Expense Distribution</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Expenses -->
                    <?php 
                    $expense = $conn -> prepare("SELECT * FROM expenses WHERE plan_id=? ORDER BY date") or die($conn -> error);
                    $expense -> bind_param('i',$plan_id) or die($expense -> error) ;
                    $expense -> execute() or die($expense -> error) ;
                    $result = $expense -> get_result();
                    if ($result -> num_rows>0){
                        while ($row = $result -> fetch_array()) {
                            $date = date_create($row['date']);
                            $date = date_format($date,'jS M Y');
                    ?>
                            <div class="col-sm-6 col-md-4 col-lg-5 col-xl-4 mb-4 g-3">
                                <div class="card">
                                    <div class="card-header bg-secondary text-center text-white ">
                                        <div class="row h5 fw-normal mt-2">
                                            <div class="d-inline m-auto"><?php echo $row['title']; ?></div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            <div class="d-inline-flex flex-wrap">
                                                <h5 class="my-2 me-auto">Amount :</h5>
                                                    <p class="my-auto">&#8377; <?php echo $row['amount']; ?></p>
                                            </div>
                                            <div class="d-inline-flex flex-wrap">
                                                <h5 class="my-2 me-auto">By :</h5>
                                                    <p class="my-auto"> <?php echo $row['spent_by']; ?></p>
                                            </div>
                                            <div class="d-inline-flex flex-wrap">
                                                <h5 class="my-2 me-auto">Date :</h5>
                                                    <p class="my-auto"><?php echo $date ?></p>
                                            </div>
                                            <div class="d-grid">
                                                <?php if(isset($row['bill'])) { ?>
                                                    <a class="text-primary text-center text-decoration-none my-2" target="_blank" href="<?php echo $row['bill']; ?>">Show Bill</a>
                                                <?php }else { ?>
                                                    <a class="text-primary text-center text-decoration-none my-2">You Don't have bill</a>
                                                <?php }?>
                                                <a class="text-danger text-center text-decoration-none my-2" href="expense_remove.php?id=<?php echo $plan_id; ?>&exp_id=<?php echo $row['expense_id']; ?>" onclick=" return confirm('Are You sure you want to delete this expense?');" >Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        }//end of while loop
                    }//end of if cond.
                    ?>

                </div>
            </div>
            <!-- Hide for small screen -->
            <div class="col-lg-5 col-xl-4 d-none d-lg-block">
                <!-- Add new expense form -->
                <?php include('expense_new.php'); ?>
            </div>
        </div>

        <!-- Add expense btn on the bottom-right corner for small screen -->
        <a id="add_plan_btn" class="d-lg-none" href="expense_new.php?id=<?php echo $plan_id; ?>"><i class="fas fa-plus-circle fa-4x text-success "> </i></a>

    </main>




    <?php include('includes/footer.php') //Footer 
    ?>
</body>

</html>