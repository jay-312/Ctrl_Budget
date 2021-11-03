<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <!-- Brand Name -->
            <a href="index.php" class="navbar-brand">CT&#8377;L BUDGET</a>
            <!-- Collapse Button -->
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav ms-auto">
                    <hr>
                    <li class="nav-item me-2">
                        <a href="about_us.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a>
                    </li>
                    <?php if(!isset($_SESSION['email'])) { ?>
                    <li class="nav-item me-2">
                        <a href="signup.php" class="nav-link"><i class="fas fa-user"></i> Signup</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <?php } else {  ?>
                    <li class="nav-item me-2">
                        <a href="change_password.php" class="nav-link"><i class="fas fa-cog"></i> Change Password</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="logout.php" class="nav-link" onclick=" return confirm('Are You sure you want to logout?');"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>