<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ku xirirka Database-ka (Beddel macluumaadkaaga haddii ay kala duwan yihiin)
$host = 'localhost';
$db   = 'coffee_shop_db'; // Magaca database-kaaga
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Soo qaadashada badeecadaha Menu-ga
    $stmt = $pdo->query("SELECT * FROM products LIMIT 4");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Soo qaadashada ra'yiga macaamiisha (Customers Testimonials) database-ka
    $testi_stmt = $pdo->query("SELECT * FROM testimonials");
    $testimonials = $testi_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (\PDOException $e) {
    $products = [];
    $testimonials = [];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>About</title>
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
                <li class="nav-item active"><a href="about.php" class="nav-link">ABOUT</a></li>
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
                                <a class="nav-link dropdown-toggle"  href="#" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <h1 class="mb-3 mt-5 bread">About Us</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>About</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-about d-md-flex">
        <div class="one-half img" style="background-image: url(images/about.jpg);"></div>
        <div class="one-half ftco-animate">
            <div class="overlap">
            <div class="heading-section ftco-animate ">
                  <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Our Story</h2>
            </div>
            <div>
<p>Founded with a deep passion for exceptional coffee and genuine community, our journey began from a simple love for the perfect brew. We source the finest beans from around the world, roasting them with care to bring out rich, unforgettable flavors in every cup. More than just a coffee shop, we strive to create a warm, welcoming space where friends gather, ideas spark, and every visitor feels right at home. Come experience the dedication and artistry poured into every single cup we serve.</p>            </div>
            </div>
        </div>
    </section>

    <!-- QAYBTA CUSTOMER TESTIMONY (Waa laga soo akhriyay database-ka iyadoo wadata magacyadii aad soo gudbisay) -->
    <section class="ftco-section img" id="ftco-testimony" style="background-image: url(images/bg_1.jpg);"  data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                  <span class="subheading" style="display: block; margin-bottom: 10px;">Testimony</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Customers Says</h2>
<p>Hear what our wonderful patrons have to say about their daily coffee experience and time spent with us.</p>            </div>
          </div>
        </div>
        <div class="container-wrap">
          <div class="row d-flex no-gutters">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $index => $testi): ?>
                    <?php 
                        $testiImg = !empty($testi['image']) ? "images/" . $testi['image'] : "images/person_1.jpg";
                        $overlayClass = ($index % 2 != 0) ? 'testimony overlay' : 'testimony';
                    ?>
                    <div class="col-lg align-self-sm-end">
                      <div class="<?php echo $overlayClass; ?>">
                         <blockquote>
                            <p>&ldquo;<?php echo htmlspecialchars($testi['message']); ?>&rdquo;</p>
                          </blockquote>
                          <div class="author d-flex mt-4">
                            <div class="image mr-3 align-self-center">
                              <img src="<?php echo htmlspecialchars($testiImg); ?>" alt="">
                            </div>
                            <div class="name align-self-center">
                                <?php echo htmlspecialchars($testi['customer_name']); ?> 
                                <span class="position"><?php echo htmlspecialchars($testi['position']); ?></span>
                            </div>
                          </div>
                      </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12 text-center text-white">
                    <p>Ma jiraan ra'yi macaamiil ah oo la helay hadda.</p>
                </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

    <!-- QAYBTA MENU-GA -->
    <section class="ftco-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 pr-md-5">
                    <div class="heading-section text-md-right ftco-animate">
                  <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Our Menu</h2>
                <p class="mb-4">Explore our carefully curated menu featuring freshly brewed coffees, artisan teas, and delicious treats crafted to brighten your day. Taste the perfection in every single sip and bite.</p>                <p><a href="menu.php" class="btn btn-primary btn-outline-primary px-4 py-3">View Full Menu</a></p>
              </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $index => $row): ?>
                                <?php $imgSrc = "images/" . $row['image']; ?>
                                <div class="col-md-6">
                                    <div class="menu-entry <?php echo ($index % 2 != 0) ? 'mt-lg-4' : ''; ?>">
                                        <a href="product-single.php?id=<?php echo $row['ID']; ?>" class="img" style="background-image: url('<?php echo htmlspecialchars($imgSrc); ?>');"></a>
                                        <div class="text text-center pt-4">
                                            <h3><a href="product-single.php?id=<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['product_name']); ?></a></h3>
                                            <p><?php echo htmlspecialchars($row['discription'] ?? ''); ?></p>
                                            <p class="price"><span>$<?php echo number_format($row['price'], 2); ?></span></p>
                                            <p><a href="product-single.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary btn-outline-primary">Add to Cart</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-md-12 text-center">
                                <p>Ma jiraan badeecado la helay.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                  <!-- 1. Coffee Branches -->
                  <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                      <div class="text">
                        <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                        <strong class="number" data-number="48">0</strong>
                        <span>Coffee Branches</span>
                      </div>
                    </div>
                  </div>
                  <!-- 2. Number of Awards -->
                  <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                      <div class="text">
                        <div class="icon"><span class="icon-award"></span></div>
                        <strong class="number" data-number="41">0</strong>
                        <span>Number of Awards</span>
                      </div>
                    </div>
                  </div>

                  <!-- 3. Happy Customer -->
                  <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                      <div class="text">
                        <div class="icon"><span class="icon-heart"></span></div>
                        <strong class="number" data-number="5128">0</strong>
                        <span>Happy Customer</span>
                      </div>
                    </div>
                  </div>

                  <!-- 4. Staff -->
                  <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                      <div class="text">
                        <div class="icon"><span class="icon-people"></span></div>
                        <strong class="number" data-number="436">0</strong>
                        <span>Staff</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control column</a></h3>
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
            <p>
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Naxwo</a>
            </p>
          </div>
        </div>
      </div>
    </footer>
    
  <!-- loader -->
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>