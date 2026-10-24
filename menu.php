<?php
session_start();
// Isku xirka Database-ka
$host = 'localhost';
$db   = 'coffee_shop_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    echo "Cillad ayaa ka dhacday isku xirka database-ka: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Coffee Blend - Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
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

    <!-- NAVIGATION BAR -->
   <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php"><small>Coffee</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item active"><a href="menu.php" class="nav-link">MENU</a></li>
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
    <!-- END NAV -->

    <!-- HERO SECTION -->
    <section class="home-slider owl-carousel img" style="background-image: url(images/bg_3.jpg);">
        <div class="slider-item" style="background-image: url(images/bg_3.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5">Our Menu</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Menu</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MENU SECTION WITH DYNAMIC TABS -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate text-center">
                    <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Our Products</h2>
                    <p>Freshly roasted coffee and delicious meals prepared with care to give our valued customers the best experience.</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <!-- All Products Tab -->
                        <a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-all" aria-selected="true">All Products</a>

                        <?php
                        $cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY ID ASC");
                        while ($cat = $cat_stmt->fetch(PDO::FETCH_ASSOC)) {
                            $cat_id   = $cat['ID'];
                            $cat_name = htmlspecialchars($cat['category_name']);
                        ?>
                            <a class="nav-link" id="v-pills-<?php echo $cat_id; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $cat_id; ?>" role="tab" aria-controls="v-pills-<?php echo $cat_id; ?>" aria-selected="false"><?php echo $cat_name; ?></a>
                        <?php 
                        } 
                        ?>
                    </div>
                </div>

                <div class="col-md-12 d-flex align-items-center mt-3">
                    <div class="tab-content ftco-animate w-100" id="v-pills-tabContent">
                        
                        <!-- ALL PRODUCTS PANE -->
                        <div class="tab-pane fade show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
                            <div class="row">
                                <?php
                                $all_prod_stmt = $pdo->query("SELECT * FROM products");
                                if ($all_prod_stmt->rowCount() > 0) {
                                    while ($prod = $all_prod_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $title       = htmlspecialchars($prod['product_name']);
                                        $description = htmlspecialchars($prod['discription']);
                                        $price       = htmlspecialchars($prod['price']);
                                        $image       = htmlspecialchars($prod['image']);
                                        $prod_id     = $prod['ID'];
                                ?>
                                        <div class="col-md-3 text-center">
                                            <div class="menu-wrap">
                                                <a href="product-single.php?id=<?php echo $prod_id; ?>" class="menu-img img mb-4" style="background-image: url(images/<?php echo $image; ?>);"></a>
                                                <div class="text">
                                                    <h3><a href="product-single.php?id=<?php echo $prod_id; ?>"><?php echo $title; ?></a></h3>
                                                    <p><?php echo $description; ?></p>
                                                    <p class="price"><span>$<?php echo $price; ?></span></p>
                                                    <p><a href="product-single.php?id=<?php echo $prod_id; ?>" class="btn btn-primary btn-outline-primary">View Details</a></p>
                                                </div>
                                            </div>
                                        </div>
                                <?php 
                                    }
                                } else {
                                    echo "<div class='col-md-12 text-center'><p>No products available.</p></div>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- CATEGORIES PANES -->
                        <?php
                        $cat_stmt2 = $pdo->query("SELECT * FROM categories ORDER BY ID ASC");
                        while ($cat_row = $cat_stmt2->fetch(PDO::FETCH_ASSOC)) {
                            $cat_id = $cat_row['ID'];
                        ?>
                            <div class="tab-pane fade" id="v-pills-<?php echo $cat_id; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $cat_id; ?>-tab">
                                <div class="row">
                                    <?php
                                    $prod_stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
                                    $prod_stmt->execute([$cat_id]);
                                    
                                    if ($prod_stmt->rowCount() > 0) {
                                        while ($prod = $prod_stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $title       = htmlspecialchars($prod['product_name']);
                                            $description = htmlspecialchars($prod['discription']);
                                            $price       = htmlspecialchars($prod['price']);
                                            $image       = htmlspecialchars($prod['image']);
                                            $prod_id     = $prod['ID'];
                                    ?>
                                            <div class="col-md-4 text-center">
                                                <div class="menu-wrap">
                                                    <a href="product-single.php?id=<?php echo $prod_id; ?>" class="menu-img img mb-4" style="background-image: url(images/<?php echo $image; ?>);"></a>
                                                    <div class="text">
                                                        <h3><a href="product-single.php?id=<?php echo $prod_id; ?>"><?php echo $title; ?></a></h3>
                                                        <p><?php echo $description; ?></p>
                                                        <p class="price"><span>$<?php echo $price; ?></span></p>
                                                        <p><a href="product-single.php?id=<?php echo $prod_id; ?>" class="btn btn-primary btn-outline-primary">View Details</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php 
                                        }
                                    } else {
                                        echo "<div class='col-md-12 text-center'><p>No items found in this category at the moment.</p></div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">About Us</h2>
                        <p>Enjoy the finest flavors and freshly brewed coffee crafted with passion every single day.</p>
                        <ul class="ftco-footer-social list-unstyled float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Recent Blog</h2>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                            <div class="text">
                                <h3 class="heading"><a href="#">Discover the secret behind our perfect espresso roast</a></h3>
                                <div class="meta">
                                    <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2026</a></div>
                                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
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
                <div class="col-md-3">
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

    <!-- Loader -->
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