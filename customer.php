<?php
// Hubi in session uusan laba jeer bilaabmin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../connection.php';

$customer_profile = null;
$customer_orders = null;

// 1. Haddii uu customer-ku soo galay (Logged in), soo qaado xogtiisa iyo dalabaadkiisa
if (isset($_SESSION['customer_id'])) {
    $session_customer_id = $_SESSION['customer_id'];
    
    // Soo qaado xogta shakhsiga ah ee customer-ka
    $sql_cust = "SELECT ID, firstname, lastname, email, phone, street_address, town_city, RegDate FROM customers WHERE ID = ?";
    $stmt_cust = $conn->prepare($sql_cust);
    if ($stmt_cust) {
        $stmt_cust->bind_param("i", $session_customer_id);
        $stmt_cust->execute();
        $res_cust = $stmt_cust->get_result();
        $customer_profile = $res_cust->fetch_assoc();
        $stmt_cust->close();
    }

    // 2. Soo qaado dalabaadka customer-kan adigoo isticmaalaya customer_id (Habka ugu sugan)
    $sql_orders = "SELECT id, total_price, order_date, payment_method, status, town_city, street_address FROM orders WHERE customer_id = ? ORDER BY id DESC";
    $stmt_ord = $conn->prepare($sql_orders);
    if ($stmt_ord) {
        $stmt_ord->bind_param("i", $session_customer_id);
        $stmt_ord->execute();
        $customer_orders = $stmt_ord->get_result();
        $stmt_ord->close();
    }
} else {
    // Haddii uusan logged in ahayn, u celi bogga login-ka
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Customer Portal - Naaxi Coffee</title>
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
      .custom-dark-box h3, .custom-dark-box h4 {
        color: #fff !important;
      }
      .badge-pending {
        background-color: #ffc107;
        color: #000;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 600;
      }
      .badge-completed, .badge-delivered {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 600;
      }
    </style>
  </head>
  <body>
    <!-- NAV -->
   <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">Nacfi<small>Coffee</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
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
                        <a href="customer.php" class="nav-link text-white fw-bold text-nowrap">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'My Account'); ?>
                        </a>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm px-2 ml-2">Logout</a>
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
              <h1 class="mb-3 mt-5 bread">My Account Portal</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Account</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">

        <!-- XOGTA SHAKHSIGA AH & DALABAADKIISA -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <div class="card custom-dark-box p-4 shadow-sm rounded mb-4">
                    <h3 class="mb-4 text-center">Xogtaada Shakhsiga ah (My Profile)</h3>
                    <ul class="list-group list-group-flush bg-transparent">
                        <li class="list-group-item custom-dark-box d-flex justify-content-between">
                            <strong>Magaca Buuxa:</strong> 
                            <span><?php echo htmlspecialchars(($customer_profile['firstname'] ?? '') . ' ' . ($customer_profile['lastname'] ?? '')); ?></span>
                        </li>
                        <li class="list-group-item custom-dark-box d-flex justify-content-between">
                            <strong>Email-ka:</strong> 
                            <span><?php echo htmlspecialchars($customer_profile['email'] ?? ''); ?></span>
                        </li>
                        <li class="list-group-item custom-dark-box d-flex justify-content-between">
                            <strong>Teleefanka:</strong> 
                            <span><?php echo htmlspecialchars($customer_profile['phone'] ?? ''); ?></span>
                        </li>
                        <li class="list-group-item custom-dark-box d-flex justify-content-between">
                            <strong>Cinwaanka:</strong> 
                            <span><?php echo htmlspecialchars(($customer_profile['town_city'] ?? '') . ' - ' . ($customer_profile['street_address'] ?? '')); ?></span>
                        </li>
                    </ul>
                </div>

                <!-- Dalabaadka uu sameeyay iyo Status-kooda -->
                <div class="card custom-dark-box p-4 shadow-sm rounded">
                    <h3 class="mb-4 text-center">Dalabaadkii aad soo galisay & Status-kooda</h3>
                    <div class="table-responsive">
                      <table class="table table-bordered custom-dark-box text-center">
                        <thead>
                          <tr>
                            <th>Order ID</th>
                            <th>Wadarta Lacagta</th>
                            <th>Habka Bixinta</th>
                            <th>Taariikhda</th>
                            <th>Ciwaanka Delivery</th>
                            <th>Xaaladda Delivery (Status)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($customer_orders && $customer_orders->num_rows > 0) {
                              while ($ord = $customer_orders->fetch_assoc()) {
                                  $status = isset($ord['status']) ? $ord['status'] : 'Pending';
                                  $badge_class = (strtolower($status) == 'completed' || strtolower($status) == 'delivered') ? 'badge-completed' : 'badge-pending';
                          ?>
                          <tr>
                            <td>#<?php echo $ord['id']; ?></td>
                            <td>$<?php echo number_format($ord['total_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($ord['payment_method'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ord['order_date'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars(($ord['town_city'] ?? '') . ' - ' . ($ord['street_address'] ?? '')); ?></td>
                            <td><span class="<?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span></td>
                          </tr>
                          <?php
                              }
                          } else {
                              echo '<tr><td colspan="6" class="text-center py-4">Wali maadan sameyn wax dalab ah.</td></tr>';
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </section>

    <!-- FOOTER -->
    <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Naaxi Coffee</p>
          </div>
        </div>
      </div>
    </footer>
    
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