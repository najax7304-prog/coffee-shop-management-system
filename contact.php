<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "coffee_shop_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success_message = "";

// Marka foomka la soo xarriiqo (Submit)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $query)) {
            $success_message = "Thank you! Your message has been sent successfully.";
        }
    }
}
?>
<!DOCTYPE php>
<php lang="en">
  <head>
    <style>
    /* Habaynta foomka contact-ka si qoraalku u caddaado */
.contact-form .form-control {
    background: transparent !important;
    border: none !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 0 !important;
    color: #fff !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}
.contact-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.4) !important;
}
</style>
    <title>Coffee - Contact</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php"><small>Coffee</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="menu.php" class="nav-link">MENU</a></li>
                <li class="nav-item"><a href="services.php" class="nav-link">SERVICES</a></li>
                <li class="nav-item"><a href="blog.php" class="nav-link">BLOG</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link">ABOUT</a></li>
                <!-- <li class="nav-item"><a href="customer.php" class="nav-link">Customer</a></li> -->
                
            
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-shopping-cart"></span> Cart
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="cart.php">Cart</a>
                        <a class="dropdown-item" href="checkout.php">Checkout</a>
                    </div>
                </li>

                <li class="nav-item active"><a href="contact.php" class="nav-link">Contact</a></li>

              
                <!-- Account / Login & Register Dropdown -->
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <div class="d-flex align-items-center gap-2">
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <!-- Haddii uu macmiilku soo galay (Logged in) -->
                            <a href="customer.php" class="nav-link text-white fw-bold text-nowrap">
                                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'My Account'); ?>
                            </a>
                            <a href="logout.php" class="btn btn-outline-danger btn-sm px-2 ml-2">Logout</a>
                        <?php else: ?>
                            <!-- Haddii uusan soo gelin: Dropdown u eg sida Cart -->
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle  btn-sm px-3 text-white" href="#" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="icon-user"></span> Account
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownAccount">
                                    <a class="dropdown-item" href="login.php">Login</a>
                                    <a class="dropdown-item" href="register.php">Register</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <!-- END nav -->

    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">
            <div class="col-md-7 col-sm-12 text-center ftco-animate">
              <h1 class="mb-3 mt-5 bread">Contact Us</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Contact</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

  <section class="ftco-section contact-section">
      <div class="container">
        <div class="row block-9 mb-4">
          <!-- Qeybta Macluumaadka Xiriirka (Dhinaca Bidix) -->
          <div class="col-md-5 pr-md-5 ftco-animate">
            <h3 class="mb-4" style="color: #fff; font-weight: 400;">Contact Information</h3>
            <p style="color: #999; margin-bottom: 25px;">
              <strong style="color: #fff;">Address:</strong> 198 West 21th Street, Suite 721 New York NY 10016
            </p>
            <p style="color: #999; margin-bottom: 25px;">
              <strong style="color: #fff;">Phone:</strong> + 1235 2355 98
            </p>
            <p style="color: #999; margin-bottom: 25px;">
              <strong style="color: #fff;">Email:</strong> info@yoursite.com
            </p>
            <p style="color: #999; margin-bottom: 25px;">
              <strong style="color: #fff;">Website:</strong> yoursite.com
            </p>
          </div>

          <!-- Qeybta Foomka (Dhinaca Midig) -->
          <div class="col-md-7 ftco-animate">
            <?php if (!empty($success_message)) { echo '<div class="alert alert-success">' . $success_message . '</div>'; } ?>
            <form action="" method="POST" class="contact-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
              </div>
              <div class="form-group">
                <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Message" required></textarea>
              </div>
              <div class="form-group">
                <input type="submit" name="send_message" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <footer class="ftco-footer ftco-section img">
      <div class="overlay"></div>
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Coffee Shop</p>
          </div>
        </div>
      </div>
    </footer>
    <script>
  // Sug 3 ilbiriqsi (3000 milliseconds) ka dibna tirtir ama qari fariinta guusha
  setTimeout(function() {
    var alertBox = document.querySelector('.alert-success');
    if (alertBox) {
      alertBox.style.transition = "opacity 0.5s ease";
      alertBox.style.opacity = "0";
      setTimeout(function() {
        alertBox.style.display = "none";
      }, 500); // Waxay qaadanaysaa 0.5 ilbiriqsi in si tartiib ah u tago
    }
  }, 3000); // Halkaan waad bedeli kartaa waqtiga (tusaale: 3000 waa 3 ilbiriqsi)
  </script>
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="js/main.js"></script>
  </body>
</html>