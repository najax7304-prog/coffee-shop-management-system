<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// include '../../connection.php';
// Isku xirka Database-ka
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
<style>
  
    /* Ka dhig qoraalka iyo placeholder-ka kuwa si cad u muuqda */
    .appointment-form .form-control {
        color: #000 !important;
        background-color: #dae3ed !important;
        border: 1px solid #ced4da !important;
    }
    .appointment-form .form-control::placeholder {
        color: #6c757d !important;
        opacity: 1;
    }
    .appointment h3 {
        color: #000 !important;
    }

  /* Habaynta guud ee tab-yada menu-ga */
.ftco-section .nav-pills p a, 
.ftco-section .nav-link {
    color: #fff !important;
    background-color: transparent !important;
    padding: 10px 10px !important;
    border-radius: 4px;
    transition: all 0.3s ease-in-out;
    border-bottom: none !important; /* Wuxuu tirtirayaa xariiqda hoose */
}
.ftco-section .nav-pills p, 
.ftco-section .nav-link {
    display: inline-block;
    margin: 0 5px !important; /* Waxay yareyneysaa fogaanta u dhexaysa tab-yada */
}

/* Marka la dul-saaro (hover) ama la doorto (active) waxaa noqonaya sanduuq buuxa */
.ftco-section .nav-pills p a:hover, 
.ftco-section .nav-pills p a.active,
.ftco-section .nav-link:hover, 
.ftco-section .nav-link.active {
    background-color: #c49b63 !important; /* Midabka sanduuqa */
    color: #000 !important; /* Midabka qoraalka marka uu sanduuqa buuxa noqdo */
    border-bottom: none !important;
    
}
</style>
    <title>Coffee - Free Bootstrap 4 Template by Colorlib</title>
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
                <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
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
      <div class="slider-item" style="background-image: url(images/bg_3.jpg);">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-8 col-sm-12 text-center ftco-animate">
                <span class="subheading">Welcome</span>
              <h1 class="mb-4">Amazing taste &amp; beautiful place</h1>
              <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              <p><a href="cart.php" class="btn btn-primary p-3 px-xl-4 py-3 mr-1">Order Now</a> <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-3">View Menu</a></p>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(images/bg_1.jpg);">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-8 col-sm-12 text-center ftco-animate">
                <span class="subheading">Welcome</span>
              <h1 class="mb-4">The best coffee testing experience</h1>
              <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              <p><a href="cart.php" class="btn btn-primary p-3 px-xl-4 py-3 mr-1">Order Now</a> <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-3">View Menu</a></p>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(images/bg_2.jpg);">
        <div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
            <div class="col-md-8 col-sm-12 text-center ftco-animate">
                <span class="subheading">Welcome</span>
              <h1 class="mb-4">Creamy hot and ready to serve</h1>
              <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              <p><a href="cart.php" class="btn btn-primary p-3 px-xl-4 py-3 mr-1">Order Now</a> <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-3">View Menu</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- OUR STORY -->
   <section class="ftco-about d-md-flex">
        <div class="one-half img" style="background-image: url(images/about.jpg);"></div>
        <div class="one-half ftco-animate">
            <div class="overlap">
            <div class="heading-section ftco-animate ">
                <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Our Story</h2>
            </div>
            <div>
                    <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
                </div>
            </div>
        </div>
    </section>
 
    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row">
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
                <span class="flaticon-choices"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Easy to Order</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
                <span class="flaticon-delivery-truck"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Fastest Delivery</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
                <span class="flaticon-coffee-bean"></span></div>
              <div class="media-body">
                <h3 class="heading">Quality Coffee</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
        </div>
        </div>
    </section>

    <!-- MENU -->
    <!-- MENU -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Our Menu</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>
        
        <!-- Filter Tabs -->
        <?php
        $category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
        ?>
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <div class="nav nav-pills justify-content-center" id="v-pills-tab" role="tablist">
                    <a class="nav-link <?php echo ($category_filter == 'all') ? 'active' : ''; ?>" href="index.php?category=all#menu-section">All Products</a>
                    <a class="nav-link <?php echo ($category_filter == 'coffee') ? 'active' : ''; ?>" href="index.php?category=coffee#menu-section">Coffee</a>
                    <a class="nav-link <?php echo ($category_filter == 'main_dish') ? 'active' : ''; ?>" href="index.php?category=main_dish#menu-section">Main Dish</a>
                    <a class="nav-link <?php echo ($category_filter == 'drinks') ? 'active' : ''; ?>" href="index.php?category=drinks#menu-section">Drinks</a>
                    <a class="nav-link <?php echo ($category_filter == 'desserts') ? 'active' : ''; ?>" href="index.php?category=desserts#menu-section">Desserts</a>
                </div>
            </div>
        </div>

        <!-- Waxaan halkan u sameynay id="menu-section" si uu browser-ku toos ugu soo dhaco halkaan marka uu refresh-garo -->
        <div class="row" id="menu-section">
            <?php
            if ($category_filter == 'all') {
                $select_products = "SELECT * FROM products";
            } else {
                $select_products = "SELECT products.* FROM products 
                                    JOIN categories ON products.category_id = categories.ID 
                                    WHERE categories.category_name LIKE '%$category_filter%' OR products.category_id = '$category_filter'";
            }

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
                echo "<div class='col-md-12 text-center'><p>Ma jiraan badeecado la heli karo qaybtan hadda.</p></div>";
            }
            ?>
        </div>
    </div>
</section>
    <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mt-2 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <span class="subheading" style="display: block; margin-bottom: 10px;">Discover</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Best Coffee Sellers</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <div class="row">
            <?php
            $sql_best = "SELECT * FROM products LIMIT 4";
            $result_best = $conn->query($sql_best);

            if ($result_best && $result_best->num_rows > 0) {
                while($row_best = $result_best->fetch_assoc()) {
            ?>
            <div class="col-md-3">
                <div class="menu-entry">
                    <a href="product-single.php?id=<?php echo $row_best['ID']; ?>" class="img" style="background-image: url('images/<?php echo htmlspecialchars($row_best['image'] ?? 'menu-1.jpg'); ?>');"></a>
                    <div class="text text-center pt-4">
                        <h3><a href="product-single.php?id=<?php echo $row_best['ID']; ?>"><?php echo htmlspecialchars($row_best['product_name']); ?></a></h3>
                        <p><?php echo htmlspecialchars($row_best['discription']); ?></p>
                        <p class="price"><span>$<?php echo htmlspecialchars($row_best['price']); ?></span></p>
                        <p><a href="#" class="add-to-cart btn btn-primary btn-outline-primary" data-id="<?php echo $row_best['ID']; ?>">Add to Cart</a></p>
                    </div>
                </div>
            </div>
            <?php 
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="ftco-gallery">
    <div class="container-wrap">
        <div class="row no-gutters">
            <?php
            $gallery_images = ['gallery-1.jpg', 'gallery-2.jpg', 'gallery-3.jpg', 'gallery-4.jpg'];
            foreach($gallery_images as $img) {
            ?>
            <div class="col-md-3 ftco-animate">
                <a href="images/<?php echo $img; ?>" class="gallery img d-flex align-items-center" style="background-image: url('images/<?php echo $img; ?>');">
                    <div class="icon mb-4 d-flex align-items-center justify-content-center">
                        <span class="icon-search"></span>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Testimony Section -->
    <section class="ftco-section img" id="ftco-testimony" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
          <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
               <span class="subheading" style="display: block; margin-bottom: 10px;">Testimony</span>
                    <h2 class="mb-4" style="margin-top: 5px;">Customers Says</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
          </div>
        </div>
        <div class="container-wrap">
          <div class="row d-flex no-gutters">
            <?php
            $sql_testi = "SELECT * FROM testimonials ORDER BY id ASC LIMIT 5";
            $result_testi = $conn->query($sql_testi);

            if ($result_testi && $result_testi->num_rows > 0) {
                $i = 0;
                while($row_t = $result_testi->fetch_assoc()) {
                    $overlay_class = ($i % 2 == 1) ? "testimony overlay" : "testimony";
                    $animate_class = ($i % 2 == 0) ? "ftco-animate" : "";
                    ?>
                    <div class="col-lg align-self-sm-end <?php echo $animate_class; ?>">
                      <div class="<?php echo $overlay_class; ?>">
                           <blockquote>
                              <p>&ldquo;<?php echo htmlspecialchars($row_t['message']); ?>&rdquo;</p>
                           </blockquote>
                           <div class="author d-flex mt-4">
                              <div class="image mr-3 align-self-center">
                                <img src="images/<?php echo htmlspecialchars($row_t['image']); ?>" alt="">
                              </div>
                              <div class="name align-self-center">
                                  <?php echo htmlspecialchars($row_t['customer_name']); ?> 
                                  <span class="position"><?php echo htmlspecialchars($row_t['position']); ?></span>
                              </div>
                           </div>
                      </div>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
          </div>
        </div>
    </section>

    <!-- BLOG -->
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
            <h2 class="mb-4">Recent from blog</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <div class="row d-flex">
            <?php
            $sql_blogs = "SELECT * FROM blogs LIMIT 3";
            $result_blogs = $conn->query($sql_blogs);

            if ($result_blogs && $result_blogs->num_rows > 0) {
                while($row_blog = $result_blogs->fetch_assoc()) {
            ?>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="blog-entry align-self-stretch">
              <a href="blog-single.php?id=<?php echo $row_blog['id']; ?>" class="block-20" style="background-image: url('<?php echo htmlspecialchars($row_blog['image']); ?>');">
              </a>
              <div class="text py-4 d-block">
                <div class="meta">
                  <div><a href="#"><?php echo htmlspecialchars($row_blog['post_date']); ?></a></div>
                  <div><a href="#"><?php echo htmlspecialchars($row_blog['author']); ?></a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> <?php echo htmlspecialchars($row_blog['comments_count']); ?></a></div>
                </div>
                <h3 class="heading mt-2"><a href="blog-single.php?id=<?php echo $row_blog['id']; ?>"><?php echo htmlspecialchars($row_blog['title']); ?></a></h3>
                <p><?php echo htmlspecialchars($row_blog['content']); ?></p>
              </div>
            </div>
          </div>
          <?php 
                }
            }
          ?>
        </div>
        </div>
    </section>

    <!-- Appointment / Book a Table Section -->
  <?php
// include '../../connection.php'; // Hubi in wadada xiriirka database-kaaga ay sax tahay

$success_msg = "";
if (isset($_POST['book_table'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $date       = mysqli_real_escape_string($conn, $_POST['date']);
    $time       = mysqli_real_escape_string($conn, $_POST['time']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $message    = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_query = "INSERT INTO reservations (first_name, last_name, date, time, phone, message) 
                     VALUES ('$first_name', '$last_name', '$date', '$time', '$phone', '$message')";
    
    if (mysqli_query($conn, $insert_query)) {
        $success_msg = "Miiskaaga si guul leh ayaa loo diiwaan geliyey!";
    } else {
        $success_msg = "Cillad ayaa dhacday: " . mysqli_error($conn);
    }
}
?>

<section class="ftco-appointment">
    <div class="overlay"></div>
    <div class="container-wrap">
    		<div class="row no-gutters d-md-flex align-items-center">
            <div class="col-md-4 appointment ftco-animate bg- p-5 rounded">
                <h3 class="mb-3 text-center">Book a Table</h3>
                
                <?php if (!empty($success_msg)) { echo "<div class='alert alert-success text-center'>$success_msg</div>"; } ?>

                <form action="" method="POST" class="appointment-form">
                    <div class="d-md-flex">
                        <div class="form-group w-100 mr-md-2">
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="form-group w-100 ml-md-2">
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group w-100 mr-md-2">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-md-calendar"></span></div>
                                <input type="text" name="date" class="form-control appointment_date" placeholder="Date" required>
                            </div>
                        </div>
                        <div class="form-group w-100 mx-md-2">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-ios-clock"></span></div>
                                <input type="text" name="time" class="form-control appointment_time" placeholder="Time" required>
                            </div>
                        </div>
                        <div class="form-group w-100 ml-md-2">
                            <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group w-100 mr-md-2">
                            <textarea name="message" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group w-100 ml-md-2 align-self-end">
                            <input type="submit" name="book_table" value="Appointment" class="btn btn-primary py-3 px-4 btn-block">
                        </div>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</section>
    <!-- FOOTER -->
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
            <p>
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Naxwo</a></p>
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

  <!-- Add to Cart AJAX Script -->
  <script>
  $(document).on('click', '.add-to-cart', function(e) {
    e.preventDefault();
    var productId = $(this).data('id');
    
    $.ajax({
        url: 'add_to_cart.php',
        method: 'POST',
        data: { id: productId },
        success: function(response) {
            alert('Badeecaddu waxay ku dartay gaari-gaariimada (Cart)!');
        }
    });
});
   </script> 
  </body>
</html>
<?php 
$conn->close(); 
?>