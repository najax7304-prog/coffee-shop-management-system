<?php
// Hubi in session uusan laba jeer bilaabmin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../connection.php';
$session_id = session_id();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cart - Coffee Blend</title>
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
      .custom-dark-box span {
        color: #ccc !important;
      }
    </style>
  </head>
  <body>
   <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">Nacfi<small>Coffee</small></a>
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
                    <a class="nav-link  dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-shopping-cart"></span> Cart
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item " href="cart.php">Cart</a>
                        <a class="dropdown-item" href="checkout.php">Checkout</a>
                    </div>
                </li>

                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>

              
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
              <h1 class="mb-3 mt-5 bread">Cart</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                          <tr class="text-center">
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Soo qaadashada alaabta cart-ka iyadoo la isticmaalayo session_id
                          $select_cart = "SELECT * FROM cart WHERE session_id = '$session_id'";
                          $cart_result = mysqli_query($conn, $select_cart);
                          $subtotal_all = 0;

                          if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                              while($row = mysqli_fetch_assoc($cart_result)) {
                                  $item_total = $row['price'] * $row['quantity'];
                                  $subtotal_all += $item_total;
                          ?>
                          <tr class="text-center">
                            <td class="product-remove"><a href="cart-delete.php?id=<?php echo $row['id']; ?>"><span class="icon-close"></span></a></td>
                            
                            <td class="image-prod"><div class="img" style="background-image:url(images/<?php echo $row['image']; ?>);"></div></td>
                            
                            <td class="product-name">
                                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                            </td>

                            <td class="product-size"><?php echo htmlspecialchars($row['size']); ?></td>
                            
                            <td class="price">$<?php echo number_format($row['price'], 2); ?></td>
                            
                            <td class="quantity">
                                <div class="input-group mb-3">
                                    <input type="text" name="quantity" class="quantity form-control input-number text-center" value="<?php echo $row['quantity']; ?>" readonly>
                                </div>
                            </td>
                            
                            <td class="total">$<?php echo number_format($item_total, 2); ?></td>
                          </tr><!-- END TR-->
                          <?php 
                              }
                          } else {
                              echo '<tr><td colspan="7" class="text-center py-4">Dambiishaadu waa madhan tahay.</td></tr>';
                          }

                          // Xisaabinta qiimaha Delivery iyo Discount
                          $discount = 2.00;
                          $delivery = 3.00;
                          $total_price = ($subtotal_all > 0) ? ($subtotal_all + $delivery - $discount) : 0;
                          if($total_price < 0) {
                              $total_price = 0;
                          }
                          ?>
                        </tbody>
                      </table>
                  </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col col-lg-4 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total custom-dark-box p-3 p-md-4 mb-3">
                    <h3 class="billing-heading mb-4">Cart Totals</h3>
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
                <p class="text-center"><a href="checkout.php" class="btn btn-primary py-3 px-4 w-100">Proceed to Checkout</a></p>
            </div>
        </div>
    </div> 
</section>

    <!-- Related Products Section -->
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <span class="subheading">Discover</span>
            <h2 class="mb-4">Related products</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <div class="row">
            <?php
            $select_products = "SELECT * FROM products LIMIT 4";
            $prod_result = mysqli_query($conn, $select_products);

            if ($prod_result && mysqli_num_rows($prod_result) > 0) {
                while ($prod = mysqli_fetch_assoc($prod_result)) {
            ?>
            <div class="col-md-3">
                <div class="menu-entry">
                    <a href="product-single.php?id=<?php echo $prod['ID']; ?>" class="img" style="background-image: url(images/<?php echo $prod['image']; ?>);"></a>
                    <div class="text text-center pt-4">
                        <h3><a href="product-single.php?id=<?php echo $prod['ID']; ?>"><?php echo htmlspecialchars($prod['product_name']); ?></a></h3>
                        <p><?php echo htmlspecialchars(substr($prod['discription'], 0, 50)); ?>...</p>
                        <p class="price"><span>$<?php echo $prod['price']; ?></span></p>
                        <p><a href="product-single.php?id=<?php echo $prod['ID']; ?>" class="btn btn-primary btn-outline-primary">View Product</a></p>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<p class='text-center'>Ma jiraan badeecado la heli karo hadda.</p>";
            }
            ?>
        </div>
      </div>
    </section>

    <!-- <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
          </div>
        </div>
      </div>
    </footer>
     -->
    <footer class="ftco-footer ftco-section img">
      <div class="overlay"></div>
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">About Us</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Recent Blog</h2>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 mb-5 mb-md-5">
             <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Services</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Cooked</a></li>
                <li><a href="#" class="py-2 d-block">Deliver</a></li>
                <li><a href="#" class="py-2 d-block">Quality Foods</a></li>
                <li><a href="#" class="py-2 d-block">Mixed</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Naxwo</a></p>
          </div>
        </div>
      </div>
    </footer>
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

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