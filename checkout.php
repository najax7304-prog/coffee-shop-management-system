<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../connection.php';

// Soo akhri alaabta ku jirta cart-ka si loo xisaabiyo wadarta guud
$select_cart = "SELECT * FROM cart";
$cart_result = mysqli_query($conn, $select_cart);$subtotal_all = 0;

while($row = mysqli_fetch_assoc($cart_result)) {$item_total = $row['price'] *$row['quantity'];
    $subtotal_all +=$item_total;
}

$discount = 2.00;
$delivery = 3.00; 

// Xisaabinta Total-ka: Subtotal + Delivery - Discount
$total_price = ($subtotal_all > 0) ? ($subtotal_all + $delivery -$discount) : 0;
if($total_price < 0) {$total_price = 0;
}

// Marka uu macmiilku gujiyo badhanka "Place an order"
if(isset($_POST['place_order'])) {
    // Hel customer_id-ga macmiilka logged-in ah
    $customer_id = isset($_SESSION['customer_id']) ? intval($_SESSION['customer_id']) : 'NULL';

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);$lastname = mysqli_real_escape_string($conn,$_POST['lastname']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);$street_address = mysqli_real_escape_string($conn,$_POST['street_address']);
    $apartment = mysqli_real_escape_string($conn, $_POST['apartment']);$town_city = mysqli_real_escape_string($conn,$_POST['town_city']);
    $postcode_zip = mysqli_real_escape_string($conn, $_POST['postcode_zip']);$phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);$payment_method = mysqli_real_escape_string($conn,$_POST['payment_method']);

    // Hubi in cart-ku uusan madhnaan intaan dalabka la gudbin
    if($subtotal_all > 0) {
        // Halkan ayaa la saxay qeybta customer_id si aysan syntax error u keenin
        if ($customer_id === 'NULL') {$insert_order = "INSERT INTO orders (customer_id, firstname, lastname, state, street_address, apartment, town_city, postcode_zip, phone, email, total_price, payment_method) 
                            VALUES (NULL, '$firstname', '$lastname', '$state', '$street_address', '$apartment', '$town_city', '$postcode_zip', '$phone', '$email', '$total_price', '$payment_method')";
        } else {
            $insert_order = "INSERT INTO orders (customer_id, firstname, lastname, state, street_address, apartment, town_city, postcode_zip, phone, email, total_price, payment_method) 
                            VALUES ($customer_id, '$firstname', '$lastname', '$state', '$street_address', '$apartment', '$town_city', '$postcode_zip', '$phone', '$email', '$total_price', '$payment_method')";
        }
        
        if(mysqli_query($conn,$insert_order)) {
            // 1. Hel ID-ga order-kii dhashay
            $order_id = mysqli_insert_id($conn);

            // 2. Ku dar xogta maaliyadda miiska finances
            $title       = "Order Payment #" . $order_id;
            $type        = "income"; 
            $amount      =$total_price;
            $category    = "Sales";
            $date        = date('Y-m-d');$description = "Payment received from customer: " . $firstname . " " . $lastname;

            $sql_finance = "INSERT INTO `finances` (`order_id`, `title`, `type`, `amount`, `category`, `date`, `description`) 
                            VALUES ('$order_id', '$title', '$type', '$amount', '$category', '$date', '$description')";
            
            if(!mysqli_query($conn,$sql_finance)) {
                die("Finance Error: " . mysqli_error($conn));
            }

            // Tirtir cart-ka dalabka ka dib
            mysqli_query($conn, "DELETE FROM cart");
            
            echo "<script>alert('Dalabkaaga si guul leh ayaa loo diray!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Cilad ayaa dhacday, fadlan dib u day.');</script>";
        }
    } else {
        echo "<script>alert('Gaari-gaarigaagu waa madhan yahay!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Checkout - Coffee Blend</title>
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

    <style>
      .custom-dark-box {
        background-color: #1a1a1a !important;
        color: #fff !important;
        border: 1px solid #333;
      }
      .custom-dark-box h3 {
        color: #fff !important;
      }
      .custom-dark-box hr {
        border-top: 1px solid #444;
      }
      .custom-dark-box label, .custom-dark-box span {
        color: #ccc !important;
      }
    </style>
  </head>
  <body>
    <!-- NAV -->
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
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-shopping-cart"></span> Cart
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="cart.php">Cart</a>
                        <a class="dropdown-item" href="checkout.php">Checkout</a>
                    </div>
                </li>

                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>

                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <div class="d-flex align-items-center gap-2">
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <a href="customer.php" class="nav-link text-white fw-bold text-nowrap">
                                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'My Account'); ?>
                            </a>
                            <a href="logout.php" class="btn btn-outline-danger btn-sm px-2 ml-2">Logout</a>
                        <?php else: ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn-sm px-3 text-white" href="#" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
              <h1 class="mb-3 mt-5 bread">Checkout</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <form action="checkout.php" method="POST" class="billing-form">
          <div class="row">
            <div class="col-xl-8 ftco-animate">
              <h3 class="mb-4 billing-heading">Billing Details</h3>
              <div class="row align-items-end">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="w-100"></div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="state">State / Country</label>
                    <input type="text" name="state" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="w-100"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="street_address">Street Address</label>
                    <input type="text" name="street_address" class="form-control" placeholder="House number and street name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="apartment">Apartment, suite, unit etc.:</label>
                    <input type="text" name="apartment" class="form-control" placeholder="Apartment, suite, unit etc. (optional)">
                  </div>
                </div>
                <div class="w-100"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="town_city">Town / City</label>
                    <input type="text" name="town_city" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="postcode_zip">Postcode / ZIP *</label>
                    <input type="text" name="postcode_zip" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="w-100"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 sidebar ftco-animate">
              <div class="cart-detail cart-total custom-dark-box p-3 p-md-4 mb-4">
                <h3 class="billing-heading mb-4">Cart Total</h3>
                <p class="d-flex">
                  <span>Subtotal</span>
                  <span>$<?php echo number_format($subtotal_all, 2); ?></span>
                </p>
                <p class="d-flex">
                  <span>Delivery</span>
                  <span>$<?php echo number_format($delivery, 2); ?></span>
                </p>
                <p class="d-flex">
                  <span>Discount</span>
                  <span>$<?php echo number_format($discount, 2); ?></span>
                </p>
                <hr>
                <p class="d-flex total-price" style="color: #c49b63 !important;">
                  <span>Total</span>
                  <span>$<?php echo number_format($total_price, 2); ?></span>
                </p>
              </div>
              
              <div class="cart-detail custom-dark-box p-3 p-md-4">
                <h3 class="billing-heading mb-4">Payment Method</h3>
                
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="radio">
                      <label><input type="radio" name="payment_method" value="Direct Bank Transfer" class="mr-2" checked> Direct Bank Transfer</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                    <div class="radio">
                      <label><input type="radio" name="payment_method" value="Check Payment" class="mr-2"> Check Payment</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                    <div class="radio">
                      <label><input type="radio" name="payment_method" value="Paypal" class="mr-2"> Paypal</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                    <div class="checkbox">
                      <label><input type="checkbox" name="terms" value="1" class="mr-2" required> I have read and accept the terms and conditions</label>
                    </div>
                  </div>
                </div>

                <div class="form-group mt-4">
                  <button type="submit" name="place_order" class="btn btn-primary py-3 px-4 w-100">Place an order</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>

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