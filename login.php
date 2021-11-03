<?php
require ('includes/connection.php');
if (isset($_SESSION['email'])) {
    header('location: home.php');
}
//Successfull msg after signup and asking to login again
if (isset($_GET['signup'])) {
  echo "<script> window.alert('".$_GET['signup']."') </script>";
}
//defining variables
$email = '';
$password = '';
//Processing form after submiting
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $email = $_POST['email'];
    $password = md5(md5($_POST['password']));

    // To check if email id already exists
    $stmt = $conn -> prepare("SELECT user_id FROM users WHERE email=?") or die($conn -> error) ;
    $stmt -> bind_param('s',$email) or die($stmt -> error) ;
    $stmt -> execute() or die($stmt -> error) ;
    $result = $stmt -> get_result();
    if ($result -> num_rows == 0) {
        $email_class = 'is-invalid';
    }else {
        $stmt = $conn -> prepare("SELECT user_id,name,email FROM users WHERE email=? AND password=? ") or die($conn -> error) ;
        $stmt -> bind_param('ss',$email,$password) or die($stmt -> error) ;
        $stmt -> execute() or die($conn -> error) ;
        $result = $stmt -> get_result();
        if ($result -> num_rows == 0){
            $email_class = 'is-valid';
            $paswd_class = 'is-invalid';
        }else {
            $row = $result -> fetch_array();
            $_SESSION['id'] = $row['user_id']; //assigning user id to session
            $_SESSION['email'] = $row['email']; //assigning user email to session
            $_SESSION['name'] = $row['name']; //assigning user name to session
            header('location: home.php');
        }
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

    <?php include ('includes/header.php') //Navbar ?>

    <main class="container content">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); //To submit the form in same page ?>">                            
                            <div class="mb-3">
                                <label for="Email" class="form-label fw-bold">Email:</label>
                                <input type="email" id="Email" class="form-control <?php if(isset($email_class)){echo $email_class;} //To add is-invalid/is-valid class after validation ?>" value="<?php echo $email; ?>"
                                    name="email" placeholder="Email (Ex. name@example.com)" required>
                                <div class="invalid-feedback">This email id is not registered!</div>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label fw-bold">Password:</label>
                                <input type="password" id="Password" class="form-control <?php if(isset($paswd_class)){echo $paswd_class;} //To add is-invalid class after validation ?>"
                                    name="password" placeholder="Password (Min. 6 characters)" pattern=".{6,}" required>
                                <div class="invalid-feedback">Wrong Login credentials!</div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        Don't have an account? <a href="signup.php">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include ('includes/footer.php') //Footer ?>
    
</body>
</html>