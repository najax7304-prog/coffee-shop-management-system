<?php
// Hubi in session uusan laba jeer bilaabmin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include '../../connection.php';

// Check if product ID is passed in URL (e.g., product-single.php?id=1)
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch product data using its ID
    $query = "SELECT products.*, categories.category_name 
              FROM products 
              JOIN categories ON products.category_id = categories.ID 
              WHERE products.ID = $product_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "ID not found.";
    exit();
}

// Handle Add to Cart Form Submission
if (isset($_POST['add_to_cart'])) {
    $p_id = $product_id;
    $session_id = session_id();
    $p_name = $product['product_name'];
    $base_price = $product['price']; // Qiimaha asaasiga ah
    $p_image = $product['image'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $size = isset($_POST['size']) ? $_POST['size'] : 'Small'; 

    // Xisaabinta qiimaha cusub iyadoo la eegayo size-ka la doortay
    $p_price = $base_price;
    if ($size == 'Medium') {
        $p_price += 1.00;
    } elseif ($size == 'Large') {
        $p_price += 2.00;
    } elseif ($size == 'Extra Large') {
        $p_price += 3.00;
    }

    // 1. Hubi in alaabtan iyo size-kan ay hore ugu jirtay dambiisha
    $check_query = "SELECT * FROM cart WHERE session_id = '$session_id' AND product_id = $p_id AND size = '$size'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Haddii ay jirto alaabta iyo size-kii isku midka ahaa, kordhi tirada
        $cart_row = mysqli_fetch_assoc($check_result);
        $new_qty = $cart_row['quantity'] + $quantity;
        $update_query = "UPDATE cart SET quantity = $new_qty WHERE id = " . $cart_row['id'];
        mysqli_query($conn, $update_query);
    } else {
        // Haddii aysan jirin, ku dar database-ka adoo raacinaya size-ka iyo qiimaha saxda ah
        $insert_query = "INSERT INTO cart (session_id, product_id, product_name, price, image, size, quantity) 
                         VALUES ('$session_id', $p_id, '$p_name', $p_price, '$p_image', '$size', $quantity)";
        mysqli_query($conn, $insert_query);
    }

    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    .my-custom-btn {
        background-color: #1d1b18 !important;
        border-color: #e0d5c5 !important;
        color: #fff !important;
        transition: all 0.3s ease;
    }
    
    .my-custom-btn:hover {
        background-color: #c49b63 !important;
        border-color: #c49b63 !important;
        color: #fff !important;
    }
    </style>
    <title>Product Detail - Coffee Shop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Include CSS stylesheets -->
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
    <!-- Navbar section -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Nacfi<small>Coffee</small></a>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item active"><a href="menu.php" class="nav-link">Menu</a></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span> 0</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner section -->
    <section class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center">
                    <div class="col-md-7 col-sm-12 text-center ftco-animate">
                        <h1 class="mb-3 mt-5 bread">Product Detail</h1>
                        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Product Detail</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product detail section -->
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <!-- Product image from database -->
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="images/<?php echo $product['image']; ?>" class="image-popup">
                        <img src="images/<?php echo $product['image']; ?>" class="img-fluid" alt="<?php echo $product['product_name']; ?>">
                    </a>
                </div>

                <!-- Product name, price, description, and form section -->
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    
                    <!-- Qiimaha oo la siiyay data-base-price si JavaScript u aqoonsado -->
                    <p class="price">
                        <span id="product-price" data-base-price="<?php echo $product['price']; ?>">
                            $<?php echo $product['price']; ?>
                        </span>
                    </p>
                    
                    <p><?php echo htmlspecialchars($product['discription']); ?></p>
                    <p>Category: <strong><?php echo htmlspecialchars($product['category_name']); ?></strong></p>

                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <div class="select-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="size" class="form-control">
                                            <option value="Small">Small</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Large">Large</option>
                                            <option value="Extra Large">Extra Large</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="input-group col-md-6 d-flex mb-3">
                                <input type="number" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                            </div>
                        </div>
                        <p><button type="submit" name="add_to_cart" class="btn btn-primary py-3 px-5 my-custom-btn">Add to Cart</button></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer section -->
    <footer class="ftco-footer ftco-section img">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright &copy; 2026 All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Include JavaScript files -->
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

    <!-- JavaScript si qiimuhu u beddelmo marka size-ka la beddelo -->
    <script>
    $(document).ready(function(){
        $('select[name="size"]').change(function(){
            let basePrice = parseFloat($('#product-price').data('base-price'));
            let selectedSize = $(this).val();
            let additionalPrice = 0;

            if (selectedSize === 'Medium') {
                additionalPrice = 1.00;
            } else if (selectedSize === 'Large') {
                additionalPrice = 2.00;
            } else if (selectedSize === 'Extra Large') {
                additionalPrice = 3.00;
            }

            let finalPrice = basePrice + additionalPrice;
            $('#product-price').text('$' + finalPrice.toFixed(2));
        });
    });
    </script>
</body>
</html>