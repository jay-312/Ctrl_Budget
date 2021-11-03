<?php
require('includes/connection.php');

if (!isset($_GET['budget']) && !isset($_POST['budget']) ) {
    header('location: plan_new.php');
}

//defining variable to keep the value after validation fail
if (isset($_GET['budget']) and isset($_GET['people_number'])) {
    $budget = $_GET['budget'];
    $people_number = $_GET['people_number'];
} else{
    $budget = $_POST['budget'];
    $people_number = $_POST['people_number'];
}
$plan_title = $plan_from = $plan_to = '';
for ($x=1; $x<=$people_number; $x++){
    $name_array[$x] = '';}

//Processing form after submiting
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];
    $plan_title = $_POST['plan_title'];
    $plan_from = $_POST['plan_from'];
    $plan_to = $_POST['plan_to'];
    for ($x = 1; $x <= $people_number; $x++) {
        $name_array[$x] = $_POST['name'][$x];
    }

    if ($plan_to < $plan_from) {
        $date_class = 'is-invalid';
    } else {
        $insert_plan = $conn->prepare("INSERT INTO plans (user_id, title, date_from, date_to, budget, people) VALUES (?,?,?,?,?,?)") or die($conn->error);
        $insert_plan->bind_param('isssii', $user_id, $plan_title, $plan_from, $plan_to, $budget, $people_number);
        $insert_plan->execute() or die($insert_plan->error);
        $plan_id = $conn->insert_id;
        foreach ($name_array as $name) {
            $insert_grp = $conn->prepare("INSERT INTO plan_group (plan_id, name) VALUES (?,?) ") or die($conn->error);
            $insert_grp->bind_param('is', $plan_id, $name);
            $insert_grp->execute() or die($insert_grp->error);
        }
        header('location: home.php');
    }
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
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <?php include('includes/header.php') //Navbar     ?>

    <main class="container content">
        <div class="row">
            <div class="col-sm-10 col-lg-8 col-xl-6 mx-auto">
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); //To submit the form in same page ?>">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="planTitle" class="form-label h5">Title</label>
                                    <input type="text" id="planTitle" class="form-control" name="plan_title" placeholder="Title (Ex. Trip to Goa)" value="<?php echo $plan_title; ?>" required>
                                </div>
                                <div class=" col-md-6">
                                    <label for="planFrom" class="form-label h5">From</label>
                                    <input type="date" id="planFrom" class="form-control" name="plan_from" value="<?php echo $plan_from; ?>" required>
                                </div>
                                <div class=" col-md-6">
                                    <label for="planTo" class="form-label h5">To</label>
                                    <input type="date" id="planTo" class="form-control <?php if(isset($date_class)){echo $date_class;} //To add is-invalid/is-valid class after validation ?>" value="<?php echo $plan_to; ?>" name="plan_to" required>
                                    <div class="invalid-feedback">End date should be greater than from date</div>
                                </div>
                                <div class=" col-md-8">
                                    <label for="budget" class="form-label h5">Budget</label>
                                    <input type="text" id="budget" class="form-control" name="budget" value="<?php echo $budget; ?>" readonly>
                                </div>
                                <div class=" col-md-4">
                                    <label for="NumberOfPeople" class="form-label h5">No. of people</label>
                                    <input type="text" id="NumberOfPeople" class="form-control" name="people_number" value="<?php echo $people_number; ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <!-- Person 1 will be always user itself -->
                                    <label for="person" class="form-label h5">Person 1</label>
                                    <input type="text" id="person" class="form-control" name="name[1]" value="<?php echo $_SESSION['name']; ?>" readonly>
                                </div>
                                <?php
                                for ($x = 2; $x <= $people_number; $x++) { ?>
                                    <div class="col-12">
                                        <label for="person" class="form-label h5">Person <?php echo $x ?></label>
                                        <input type="text" id="person" class="form-control" name="name[<?php echo $x ?>]" value="<?php if(isset($name_array)){echo $name_array[$x];} ?>"
                                            placeholder="Person <?php echo $x ?> Name" required>
                                    </div>
                                <?php }  ?>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-success">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include('includes/footer.php') //Footer     ?>

</body>

</html>