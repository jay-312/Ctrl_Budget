<?php
require('includes/connection.php');
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
if(isset($_GET['msg'])){
    echo "<script> window.alert('".$_GET['msg']."') </script>";
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

    <?php
    $user_id = $_SESSION['id'];
    $plan_check = "SELECT * FROM plans WHERE user_id='$user_id' ";
    $result = $conn->query($plan_check) or die($conn->error);
    $row_num = $result -> num_rows;
    if ($row_num == 0) { //Check if user have created 0 plans 
    ?>
        <main class="container content">
            <h1 class="h3 fw-normal">You don't have any active plans</h1>
            <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                <div class="bg-light p-5 rounded m-3">
                    <a class="btn btn-outline text-primary my-4" href="plan_new.php"><i class="fas fa-plus-circle text-success"></i> Create new plan</a>
                </div>
            </div>
        </main>
    <?php   
    } else { //Show user plans 
    ?>
        <main class="container content">
            <h1 class="h3 fw-normal">Your plans</h1>
            <div class="row">
                
                <?php
                while($row = $result -> fetch_array()) {
                    $date_from = date_create($row['date_from']);
                    $date_from = date_format($date_from,'jS M');
                    $date_to = date_create($row['date_to']);
                    $date_to = date_format($date_to,'jS M Y');
                ?>
                    <div class="col-sm-8 mx-sm-auto col-md-6 col-lg-5 col-xl-4 mx-xl-0">
                        <div class="card m-3">
                            <div class="card-header bg-success text-center text-white ">
                                <div class="row h5 fw-normal mt-2">
                                    <div class="d-inline col-9  m-auto"><?php echo $row['title']; ?></div>
                                    <div class="d-inline col-3">
                                        <i class="fas fa-user"></i> <?php echo $row['people']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    <div class="d-inline-flex flex-wrap">
                                        <h5 class="my-2 me-auto">Budget :</h4>
                                        <p class="my-auto">&#8377; <?php echo $row['budget']; ?></p>
                                    </div>
                                    <div class="d-inline-flex flex-wrap">
                                        <h5 class="my-2 me-auto">Date :</h4>
                                        <p class="my-auto"><?php echo $date_from.' - '.$date_to; ?></p>
                                    </div>
                                    <div class="d-grid">
                                        <a class="btn btn-outline-success my-2" href="plan_view.php?id=<?php echo $row['plan_id']; ?>"><i class="far fa-eye"></i> View More</a>
                                        <a class="btn btn-outline-danger my-2" href="plan_remove.php?id=<?php echo $row['plan_id']; ?>" onclick=" return confirm('Are You sure you want to delete this plan?');" ><i class="far fa-trash-alt"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    } //end of while loop
                    ?>
            </div>
            <!-- Add plan btn on the bottom-right corner -->
            <a id="add_plan_btn" href="plan_new.php"><i class="fas fa-plus-circle fa-4x text-success "> </i></a>
        </main>
    <?php
    } //end of else loop 
    ?>



    <?php include('includes/footer.php') //Footer 
    ?>

</body>

</html>