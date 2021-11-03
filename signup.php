<?php
require ('includes/connection.php');
if (isset($_SESSION['email'])) {
    header('location: home.php');
}


//defining variables
$name = '';
$email = '';
$password = '';
$contact = '';    

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5(md5($_POST['password']));
    $contact = $_POST['contact'];

    // To check if email id already exists
    $stmt = $conn -> prepare("SELECT user_id FROM users WHERE email=?") or die($conn -> error) ;
    $stmt -> bind_param('s',$email) or die($stmt -> error) ;
    $stmt -> execute() or die($stmt -> error) ;
    $result = $stmt -> get_result();
    if ($result -> num_rows > 0) {
        $class = 'is-invalid';
    }else {
        $stmt = $conn -> prepare("INSERT INTO users (name, email, password, phone_no) VALUES (?,?,?,?)") or die($conn -> error) ;
        $stmt -> bind_param('ssss',$name,$email,$password,$contact) or die($stmt -> error) ;
        $stmt -> execute() or die($conn -> error) ;
        header('location: login.php?signup=Account Created successfully. Login again ');
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
                        <h3 class="card-title">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); //To submit the form in same page ?>">
                            <div class="mb-3">
                                <label for="Name" class="form-label fw-bold">Name:</label>
                                <input type="text" id="Name" class="form-control" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="Email" class="form-label fw-bold">Email:</label>
                                <input type="email" id="Email" class="form-control <?php if(isset($class)){echo $class;} //To add class is-invalid after validation ?>" value="<?php echo $email; ?>" name="email" placeholder="Email (Ex. name@example.com)" required>
                                <div class="invalid-feedback">This Email User already exists</div>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label fw-bold">Password:</label>
                                <input type="password" id="Password" class="form-control" name="password" placeholder="Password (Min. 6 characters)"
                                pattern=".{6,}" title="Use Minimum 6 characters" required>
                            </div>
                            <div class="mb-3">
                                <label for="Contact" class="form-label fw-bold">Phone Number:</label>
                                <input type="tel" id="Contact" class="form-control" name="contact" placeholder="Phone Number (Ex. 8448444853)" value="<?php echo $contact; ?>"
                                pattern="\d{10}" title="Enter valid 10 digit number" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Signup</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include ('includes/footer.php') //Footer ?>
    
</body>
</html>