<?php
require ('includes/connection.php');
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
            <div class="col-md-6">
                <h1 class="display-6">Who are we?</h1>
                <p class="lead">
                    We are a group of technocrats who came up with an idea of solving budget and time issues which we usually face in our daily lives. We are here to provide a budget controller according to your aspects.
                </p>
                <p class="lead">
                    Budget control is the biggest financial issue in the present world. One should look after their budget control to get ride off from their financial crisis.
                </p>
            </div>
            <div class="col-md-6">
                <h1 class="display-6">Why choose us?</h1>
                <p class="lead">
                    We provide with predominant way to control and manage your budget estimations with ease of accessing for multiple users.
                </p>
            </div>
            <div class="col-md-6">
                <h1 class="display-6">Contact Us</h1>
                <div>
                    <h5 class="d-inline">Email:</h5>
                    <p class="lead d-inline">trainings@internshala.com</p>
                </div>
                <div>
                    <h5 class="d-inline">Mobile:</h5>
                    <p class="lead d-inline">+91-8448444853</p>
                </div>
            </div>
        </div>

    </main>





    <?php include('includes/footer.php') //Footer     ?>
</body>

</html>