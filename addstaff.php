<?php
require_once 'auth.php';
include '../../connection.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $name                   = mysqli_real_escape_string($conn, $_POST['name']);
    $age                    = intval($_POST['age']);
    $tell                   = mysqli_real_escape_string($conn, $_POST['tell']);
    $email                  = mysqli_real_escape_string($conn, $_POST['email']);
    $emergency_contact_name  = mysqli_real_escape_string($conn, $_POST['emergency_contact_name']);
    $emergency_contact_phone = mysqli_real_escape_string($conn, $_POST['emergency_contact_phone']);
    $educationLevel         = mysqli_real_escape_string($conn, $_POST['educationLevel']);
    $cv_summary             = mysqli_real_escape_string($conn, $_POST['cv_summary']);
    $branch_id              = intval($_POST['branch_id']);
    $job_title_id           = intval($_POST['job_title_id']);
    $salary                 = floatval($_POST['salary']);

    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/avatar/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = "assets/images/avatar/" . $image_name;
        }
    }

    $insert_query = "INSERT INTO staff (`name`, `age`, `tell`, `email`, `emergency_contact_name`, `emergency_contact_phone`, `educationLevel`, `cv_summary`, `branch_id`, `job_title_id`, `salary`, `image`) 
                     VALUES ('$name', '$age', '$tell', '$email', '$emergency_contact_name', '$emergency_contact_phone', '$educationLevel', '$cv_summary', '$branch_id', '$job_title_id', '$salary', '$image_path')";

    if (mysqli_query($conn, $insert_query)) {
        $success_message = "Staff member added successfully!";
    } else {
        $error_message = "Error adding staff: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <?php include 'css2.php';?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff | Coffee Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f7fb; font-family: "Segoe UI", sans-serif; color: #1e293b; }
        a { text-decoration: none; }
        .main-content { margin-left: 260px; min-height: 100vh; padding: 30px; transition: all 0.3s ease; }
        .content-card { background: white; border-radius: 18px; border: 1px solid #e9eef5; box-shadow: 0 5px 25px rgba(15,23,42,0.04); padding: 30px; }
        @media (max-width: 991.98px) {
            .main-content { margin-left: 0 !important; padding: 15px; }
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<main class="main-content">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Add New Staff</h2>
        <p class="text-muted mb-2" style="font-size: 13px;">Register a new employee and assign them to a branch.</p>
        <a href="stafflist.php" class="text-primary fw-semibold" style="font-size: 14px;"><i class="bi bi-arrow-left me-1"></i> Back to List</a>
    </div>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="content-card">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Age</label>
                    <input type="number" name="age" class="form-control" placeholder="Enter age">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone Number</label>
                    <input type="text" name="tell" class="form-control" placeholder="Enter phone number">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email address">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" class="form-control" placeholder="Contact person name">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Emergency Contact Number</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" placeholder="Contact phone number">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Education Level</label>
                    <input type="text" name="educationLevel" class="form-control" placeholder="e.g. Bachelor Degree, Diploma">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Assign Branch</label>
                    <select name="branch_id" class="form-control" required>
                        <option value="">-- Choose Branch --</option>
                        <?php
                        $branch_query = "SELECT ID, NAME FROM branch WHERE 1";
                        $branch_result = mysqli_query($conn, $branch_query);
                        if ($branch_result && mysqli_num_rows($branch_result) > 0) {
                            while ($b_row = mysqli_fetch_assoc($branch_result)) {
                                echo "<option value='" . $b_row['ID'] . "'>" . htmlspecialchars($b_row['NAME']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Job Title</label>
                    <select name="job_title_id" class="form-control" required>
                        <option value="">-- Choose Job Title --</option>
                        <?php
                        $title_query = "SELECT ID, NAME FROM title WHERE 1";
                        $title_result = mysqli_query($conn, $title_query);
                        if ($title_result && mysqli_num_rows($title_result) > 0) {
                            while ($t_row = mysqli_fetch_assoc($title_result)) {
                                echo "<option value='" . $t_row['ID'] . "'>" . htmlspecialchars($t_row['NAME']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Salary ($)</label>
                    <input type="number" step="0.01" name="salary" class="form-control" placeholder="e.g. 500.00">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Staff Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">CV / Bio Summary</label>
                    <textarea name="cv_summary" class="form-control" rows="4" placeholder="Short description or work history..."></textarea>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" name="add_staff" class="btn btn-primary px-4 py-2" style="background: #6366f1; border: none; border-radius: 10px;">
                        <i class="bi bi-person-plus-fill me-1"></i> Save Staff Member
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>