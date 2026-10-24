<?php
// Hubi in session uusan laba jeer bilaabmin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../connection.php';
$session_id = session_id();

// Tusaale ahaan: Waxaan email-ka ama session-ka ku xiri karnaa haddii customer-ka uu soo galay (logged in), 
// Laakin maadaama nidaamkan uu isticmaalo session_id iyo xogaha orders-ka, waxaan ku saleynaa email-kii uu dhiibtay markii uu checkout-ka sameeyay ama session-kaaga guud.
// Halkan waxaan ku soo bandhigeynaa orders-kii ugu dambeeyay ee uu user-kan sameeyay (tusaale ahaan iyadoo la raacayo session ama email haddii la keydiyo, ama dhammaan orders-ka haddii nidaamku yahay mid hal qof tijaabinayo).
// Si loo suurtageliyo in qof walba uu arko xogtiisa, waxaa fiican in order-ka lagu keydiyo session_id ama email. Halkan waxaan ka eegeynaa miiska orders.
$select_orders = "SELECT * FROM orders ORDER BY id DESC"; 
$orders_result = mysqli_query($conn, $select_orders);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>My Account - Coffee Blend</title>
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
      .badge-completed {
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
        <a class="navbar-brand" href="index.php">Coffee<small>Blend</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
            <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="cart.php" class="nav-link"><span class="icon-shopping-cart"></span> Cart</a></li>
            <li class="nav-item active"><a href="account.php" class="nav-link">My Account</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
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
              <h1 class="mb-3 mt-5 bread">My Account & Orders</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Account</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row">
          <!-- Qeybta Dalabyada (Orders & Delivery Status) -->
          <div class="col-md-12 ftco-animate mb-5">
            <h3 class="mb-4 billing-heading">Dalabyadii aad dirtay (Order History & Delivery Status)</h3>
            <div class="table-responsive">
              <table class="table table-bordered custom-dark-box text-center">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Magaca</th>
                    <th>Telefoonka</th>
                    <th>Wadarta Lacagta</th>
                    <th>Habka Bixinta</th>
                    <th>Xaaladda Delivery (Status)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($orders_result && mysqli_num_rows($orders_result) > 0) {
                      while ($order = mysqli_fetch_assoc($orders_result)) {
                          // Waxaad ku xiri kartaa miiska deliveries ama column ku jira orders. 
                          // Halkan waxaan ka soo qaadnay in haddii uusan status jirin uu yahay 'Pending' si toos ah.
                          $status = isset($order['status']) ? $order['status'] : 'Pending';
                          $badge_class = ($status == 'Completed' || $status == 'Delivered') ? 'badge-completed' : 'badge-pending';
                  ?>
                  <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    <td><span class="<?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                  </tr>
                  <?php
                      }
                  } else {
                      echo '<tr><td colspan="6" class="text-center py-4">Wali ma aadan sameynin wax dalab ah.</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Qeybta Dambiishaada Hadda (Current Cart) -->
          <div class="col-md-12 ftco-animate">
            <h3 class="mb-4 billing-heading">Dambiishaada Hadda (Current Cart Items)</h3>
            <div class="table-responsive">
              <table class="table table-bordered custom-dark-box text-center">
                <thead>
                  <tr>
                    <th>Badeecada</th>
                    <th>Cabirka (Size)</th>
                    <th>Qiimaha</th>
                    <th>Tirada (Qty)</th>
                    <th>Wadarta</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $select_cart = "SELECT * FROM cart";
                  $cart_res = mysqli_query($conn, $select_cart);
                  $cart_subtotal = 0;

                  if ($cart_res && mysqli_num_rows($cart_res) > 0) {
                      while ($c_row = mysqli_fetch_assoc($cart_res)) {
                          $c_total = $c_row['price'] * $c_row['quantity'];
                          $cart_subtotal += $c_total;
                  ?>
                  <tr>
                    <td><?php echo htmlspecialchars($c_row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($c_row['size']); ?></td>
                    <td>$<?php echo number_format($c_row['price'], 2); ?></td>
                    <td><?php echo $c_row['quantity']; ?></td>
                    <td>$<?php echo number_format($c_total, 2); ?></td>
                  </tr>
                  <?php
                      }
                  } else {
                      echo '<tr><td colspan="5" class="text-center py-4">Dambiishaadu waa madhan tahay hadda.</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php if($cart_subtotal > 0): ?>
              <div class="text-right mt-3">
                <a href="cart.php" class="btn btn-primary py-2 px-4">Fiiri Cart-ka oo Buuxiso Checkout</a>
              </div>
            <?php endif; ?>
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
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"]/script>
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