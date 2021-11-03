<?php
require('includes/connection.php');
if (!isset($_SESSION['email'])) {
    header('location: home.php');
}
if (!isset($_GET['id'])) {
    header('location: home.php');
}
$plan_id =  $_GET['id'];
$plan_detail = $conn->prepare("SELECT title,people,budget FROM plans WHERE plan_id=?") or die($conn->error);
$plan_detail->bind_param('i', $plan_id) or die($plan_detail->error);
$plan_detail->execute() or die($plan_detail->error);
$result = $plan_detail->get_result();
$row_plan = $result->fetch_array();
$plan_title = $row_plan['title'];
$plan_people = $row_plan['people'];
$plan_budget = $row_plan['budget'];

$total_spent = 0;
$plan_grp = $conn->prepare("SELECT name,amount FROM plan_group WHERE plan_id=?") or die($conn->error);
$plan_grp->bind_param('i', $plan_id) or die($plan_grp->error);
$plan_grp->execute() or die($plan_grp->error);
$result = $plan_grp->get_result();
$x = 1; //counter
while ($row = $result->fetch_array()) {
    $name[$x] = $row['name'];
    $amount[$x] = $row['amount'];
    $total_spent = $total_spent + $row['amount'];
    $x = $x + 1;
}
$remaining_amount = $plan_budget - $total_spent;
$individual_share = $total_spent / $plan_people;

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
            <div class="col-sm-10 col-lg-8 col-xl-6 mx-auto">
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
                                <h5 class="my-2 me-auto">Initial Budget :</h5>
                                <p class="my-auto">&#8377; <?php echo $plan_budget; ?></p>
                            </div>
                                <?php for ($x = 1; $x <= $plan_people; $x++) { ?>
                                    <div class="d-inline-flex flex-wrap">
                                        <h5 class="my-2 me-auto"><?php echo $name[$x]; ?> :</h5>
                                        <p class="my-auto">&#8377; <?php echo $amount[$x]; ?></p>
                                    </div>
                                <?php } ?>
                            <div class="d-inline-flex flex-wrap">
                                <h5 class="my-2 me-auto">Total Amount Spent :</h5>
                                <p class="my-auto">&#8377; <?php echo $total_spent; ?></p>
                            </div>
                            <div class="d-inline-flex flex-wrap">
                                <h5 class="my-2 me-auto">Remaining Amount :</h5>
                                <?php if ($remaining_amount > 0) { ?>
                                    <p class="my-auto text-success">&#8377; <?php echo $remaining_amount; ?></p>
                                <?php } else if ($remaining_amount < 0) { ?>
                                    <p class="my-auto text-danger">overspent by &#8377; <?php echo abs($remaining_amount); ?></p>
                                <?php } else { ?>
                                    <p class="my-auto"> &#8377; <?php echo $remaining_amount; ?></p>
                                <?php } ?>
                            </div>
                            <div class="d-inline-flex flex-wrap">
                                <h5 class="my-2 me-auto">Individual Shares :</h5>
                                <p class="my-auto">&#8377; <?php echo $individual_share; ?></p>
                            </div>
                                <?php 
                                for ($x = 1; $x <= $plan_people; $x++) { 
                                ?>
                                    <div class="d-inline-flex flex-wrap">
                                        <h5 class="my-2 me-auto"><?php echo $name[$x]; ?> :</h5>
                                        <?php 
                                        $settlement = $amount[$x] - $individual_share;
                                        if ($settlement > 0) { 
                                        ?>
                                            <p class="my-auto text-success">Gets back &#8377; <?php echo $settlement; ?></p>
                                        <?php 
                                        } else if ($settlement < 0) { 
                                        ?>
                                            <p class="my-auto text-danger">Owes &#8377; <?php echo abs($settlement); ?></p>
                                        <?php 
                                        } else { 
                                        ?>
                                            <p class="my-auto">All settled up</p>
                                <?php   }  //end of else loop ?>                                 
                                    </div>
                                <?php
                                } //end of for loop
                                ?>
                            <div class="d-grid">
                                <a class="btn btn-outline-success my-2" href="plan_view.php?id=<?php echo $plan_id; ?>"><i class="fas fa-arrow-left"></i> Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>







    <?php include('includes/footer.php') //Footer 
    ?>

</body>

</html>