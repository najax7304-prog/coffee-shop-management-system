<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = mysqli_connect("localhost", "root", "", "coffee_shop_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Kaydinta Comment-ka cusub marka la xarriiqo (Submit)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        $insert_query = "INSERT INTO comments (blog_id, name, email, message) VALUES ($id, '$name', '$email', '$message')";
        mysqli_query($conn, $insert_query);
        
        // Kordhi tirada comments-ka ee ku jirta table-ka blogs
        mysqli_query($conn, "UPDATE blogs SET comments_count = comments_count + 1 WHERE id = $id");
        
        header("Location: blog-single.php?id=$id");
        exit();
    }
}

// Ka soo jiid maqaalka database-ka
$query = "SELECT * FROM blogs WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    die("Blog post not found.");
}

// Ka soo jiid faallooyinka maqaalkan u gaarka ah
$comments_query = "SELECT * FROM comments WHERE blog_id = $id ORDER BY id DESC";
$comments_result = mysqli_query($conn, $comments_query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Coffee - <?php echo htmlspecialchars($row['title']); ?></title>
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
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
            <li class="nav-item active"><a href="blog.php" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="room.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="shop.html">Shop</a>
                <a class="dropdown-item" href="product-single.html">Single Product</a>
                <a class="dropdown-item" href="cart.html">Cart</a>
                <a class="dropdown-item" href="checkout.html">Checkout</a>
              </div>
            </li> -->
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
            <!-- <li class="nav-item cart"><a href="cart.html" class="nav-link"><span class="icon icon-shopping_cart"></span><span class="bag d-flex justify-content-center align-items-center"><small>1</small></span></a></li> -->
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
                                <a class="nav-link dropdown-toggle mt-3 btn-sm px-2 text-white" href="#" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
              <h1 class="mb-3 mt-5 bread">Blog Single</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span class="mr-2"><a href="blog.php">Blog</a></span> <span>Blog Single</span></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate">
            <h2 class="mb-3"><?php echo htmlspecialchars($row['title']); ?></h2>
            <p><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="" class="img-fluid"></p>
            <p class="meta">
              <span><icon class="icon-calendar"></icon> <?php echo htmlspecialchars($row['post_date']); ?></span> &nbsp;|&nbsp; 
              <span><icon class="icon-person"></icon> <?php echo htmlspecialchars($row['author']); ?></span> &nbsp;|&nbsp; 
              <span><icon class="icon-chat"></icon> <?php echo htmlspecialchars($row['comments_count']); ?> Comments</span>
            </p>
            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

            <!-- Qaybta Muujinta Faallooyinka (Comments List) -->
            <div class="pt-5 mt-5">
              <h3 class="mb-5" style="color: #fff;"><?php echo mysqli_num_rows($comments_result); ?> Comments</h3>
              <ul class="comment-list" style="list-style: none; padding: 0;">
                <?php
                if ($comments_result && mysqli_num_rows($comments_result) > 0) {
                    while ($comment = mysqli_fetch_assoc($comments_result)) {
                ?>
                  <li class="comment" style="background: #1a1a1a; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
                    <div class="vcard bio" style="color: #c49b63; font-weight: bold; font-size: 18px; margin-bottom: 5px;">
                      <?php echo htmlspecialchars($comment['name']); ?>
                    </div>
                    <div class="meta" style="font-size: 12px; color: #888; margin-bottom: 10px;">
                      <?php echo htmlspecialchars($comment['created_at']); ?>
                    </div>
                    <p style="color: #ccc;"><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
                  </li>
                <?php
                    }
                } else {
                    echo '<p style="color: #888;">No comments yet. Be the first to comment!</p>';
                }
                ?>
              </ul>
              
              <!-- Foomka Qorista Faallooyinka (Leave a Comment Form) -->
              <div class="comment-form-wrap pt-5">
                <h3 class="mb-5" style="color: #fff;">Leave a comment</h3>
                <form action="" method="POST" class="p-5 bg-dark">
                  <div class="form-group">
                    <label for="name" style="color: #fff;">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="email" style="color: #fff;">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="message" style="color: #fff;">Message</label>
                    <textarea name="message" id="message" cols="30" rows="5" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="submit_comment" value="Post Comment" class="btn py-3 px-4 btn-primary">
                  </div>
                </form>
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
          <div class="col-lg-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Coffee Blend</p>
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