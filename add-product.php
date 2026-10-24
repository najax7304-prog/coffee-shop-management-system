<?php
require_once 'auth.php';
include '../../connection.php';

if (isset($_POST['add_product'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $discription = mysqli_real_escape_string($conn, $_POST['discription']);
    
    // Maamulka sawirka (Image upload) - Ku kaydi galkaaga saxda ah ee customer/coffee1-1.0.0/images/
    $image = $_FILES['image']['name'];
    $target_dir = "../../customer/coffee1-1.0.0/images/"; 
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($image);
    
    if (!empty($image) && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Ku darista xogta iyo sawirka database-ka
        $query = "INSERT INTO products (category_id, product_name, price, image, discription, status) VALUES ('$category_id', '$product_name', '$price', '$image', '$discription', '$status')";
    } else {
        // Haddii uusan sawir soo gelin ama ay cilad timaado, ku kaydi adigoo aan sawir haysan ama magac madhan wata
        $image = "";
        $query = "INSERT INTO products (category_id, product_name, price, image, discription, status) VALUES ('$category_id', '$product_name', '$price', '$image', '$discription', '$status')";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: products.php?msg=added");
        exit();
    } else {
        $error = "Database Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'css2.php';?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | My Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            background: #f4f7fb;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
        }
        a {
            text-decoration: none;
        }

        /* SIDEBAR */
        /* .sidebar {
            width: 260px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #111827 0%, #172033 50%, #0f172a 100%);
            padding: 20px 15px;
            z-index: 1000;
            box-shadow: 8px 0 30px rgba(15, 23, 42, 0.08);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 5px 20px;
        }
        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-size: 20px;
        }
        .brand h4 {
            margin: 0;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }
        .brand small {
            color: #94a3b8;
            font-size: 11px;
        }
        .menu-title {
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            padding: 10px 10px 6px;
            text-transform: uppercase;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            padding: 10px 12px;
            margin-bottom: 4px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: 0.3s;
        }
        .sidebar .nav-link i {
            font-size: 16px;
            width: 20px;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(99, 102, 241, 0.15);
        }
        .sidebar .nav-link.active {
            color: white;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
        }

        /* SIDEBAR BOTTOM */
        /* .sidebar-bottom {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
        }
        .admin-box {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 10px;
        }
        .admin-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: white;
            font-weight: 700;
            font-size: 13px;
        }
        .admin-name {
            color: white;
            font-size: 12px;
            font-weight: 600;
        }
        .admin-role {
            color: #64748b;
            font-size: 10px;
        } */ 

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
        }
        .content-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e9eef5;
            box-shadow: 0 5px 25px rgba(15,23,42,0.04);
            padding: 30px;
        }
    </style>
</head>
<body>
<!-- <?php include //'sidebar.php' ;?> -->
<!-- SIDEBAR -->
<!-- <aside class="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-cup-hot-fill"></i>
        </div>
        <div>
            <h4>My Admin</h4>
            <small>Store Management</small>
        </div>
    </div>

    <div class="menu-title">Main Menu</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="index.php" class="nav-link">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="products.php" class="nav-link active">
                <i class="bi bi-box-seam-fill"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="users.html" class="nav-link">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="tables.html" class="nav-link">
                <i class="bi bi-table"></i>
                <span>Tables</span>
            </a>
        </li>

        <div class="menu-title">Management</div>
        <li class="nav-item">
            <a href="forms.html" class="nav-link">
                <i class="bi bi-ui-checks-grid"></i>
                <span>Forms</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-cart-check-fill"></i>
                <span>Orders</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-bottom">
        <div class="admin-box">
            <div class="d-flex align-items-center gap-2">
                <div class="admin-avatar">A</div>
                <div>
                                                       <div class="admin-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Administrator'); ?></div>

                    <div class="admin-role">Store Manager</div>
                </div>
                <i class="bi bi-three-dots-vertical text-secondary ms-auto"></i>
            </div>
        </div>
    </div>
</aside> -->

<!-- MAIN CONTENT -->
<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <h2 class="fw-bold text-dark mb-1">Add New Product</h2>
            <p class="text-muted mb-0" style="font-size: 13px;">Add a new item to your store inventory.</p>
        </div>
        <a href="products.php" class="btn btn-outline-secondary btn-sm px-3" style="border-radius: 10px;">
            <i class="bi bi-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="content-card">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Category ID</label>
                <input type="number" name="category_id" class="form-control" placeholder="Enter category ID" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name</label>
                <input type="text" name="product_name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Price ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Product Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-control">
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="discription" class="form-control" rows="4" placeholder="Enter product description"></textarea>
            </div>

            <button type="submit" name="add_product" class="btn btn-primary px-4 py-2 mt-2" style="background: #6366f1; border: none; border-radius: 10px;">
                <i class="bi bi-plus-lg me-1"></i> Save Product
            </button>
        </form>
    </div>
</main>

</body>
</html>