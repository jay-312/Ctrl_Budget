<?php
require ('includes/connection.php');
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
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
    <?php include ('includes/header.php') //Navbar ?>
    
    <main class="container content">
        <div class="row">
            <div class="col-sm-8 col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title">Create New Plan</h3>
                    </div>
                    <div class="card-body">
                        <form action="plan_new_2.php" method="GET">                            
                            <div class="mb-3">
                                <label for="budget" class="form-label h5">Initial Budget:</label>
                                <input type="number" id="budget" min="100" max="10000000" class="form-control" name="budget" placeholder="Initial Budget (Ex. 3000)" required>
                            </div>
                            <div class="mb-3">
                                <label for="NumberOfPeople" class="form-label h5">Number of people you want to add in your group:</label>
                                <input type="number" min="1" id="NumberOfPeople" class="form-control" name="people_number" placeholder="No. of People" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-success">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include ('includes/footer.php') //Footer ?>

</body>
</html>