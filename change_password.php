<?php
require "includes/connection.php";
if (!isset($_SESSION['email'])) {
    header('location:index.php');
}
//Processing form after submiting
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $old_password = md5(md5($_POST['oldpassword']));
    $new_password = md5(md5($_POST['newpassword']));
    $confirm_password = md5(md5($_POST['confirmpassword']));
    $email = $_SESSION['email'];

    $password_from_database_query = "SELECT password FROM users WHERE email='$email'";
    $password_from_database_result = $conn -> query($password_from_database_query) or die(mysqli_error($conn));
    $row = $password_from_database_result -> fetch_array();
    if ($old_password != $row['password']) {
        $oldpassword_error = "is-invalid";
    } else if ($new_password != $confirm_password) {
        $confirmpassword_error = "is-invalid";
    } else {
        $update_password_query = "UPDATE users SET password='$new_password' WHERE email='$email'";
        $conn -> query($update_password_query) or die(mysqli_error($con));
        echo "<script> window.alert('Password Updated Successfully') </script>";
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
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); //To submit the form in same page ?>">                            
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label fw-bold">Old Password</label>
                                <input type="password" id="oldPassword" class="form-control <?php if(isset($oldpassword_error)){echo $oldpassword_error;} //To add is-invalid/is-valid class after validation ?>"
                                    name="oldpassword" placeholder="Old Password" required>
                                <div class="invalid-feedback">Incorrect Old Password</div>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label fw-bold">New Password:</label>
                                <input type="password" id="newPassword" class="form-control" name="newpassword" placeholder="New Password (Min. 6 characters)" pattern=".{6,}" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label fw-bold">Confirm New Password:</label>
                                <input type="password" id="confirmPassword" class="form-control <?php if(isset($confirmpassword_error)){echo $confirmpassword_error;} //To add is-invalid class after validation ?>"
                                    name="confirmpassword" placeholder="Re-type New Password" pattern=".{6,}" required>
                                <div class="invalid-feedback">Confirm Password must match New Password</div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Change</button>
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