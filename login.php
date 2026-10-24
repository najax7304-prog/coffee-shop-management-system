<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../../connection.php';

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Hubi in magaca tiirka (ID ama id) uu sax ku yahay database-kaaga
    $stmt = $conn->prepare("SELECT ID, firstname, password FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Hubi in password-ku sax yahay
        if (password_verify($password, $row['password'])) {
            $_SESSION['customer_id'] = $row['ID']; // Haddii database-kaagu qoro 'id' oo yaryar beddel oo ka dhig $row['id']
            $_SESSION['customer_name'] = $row['firstname'];
            header("Location: customer.php");
            exit();
        } else {
            $error = "Password-ka aad gelisay waa khalad.";
        }
    } else {
        $error = "Email-kan lama helin.";
    }
}
?>
<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8">
    <title>Customer Login | Safa & Naxwo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Enter Your Account</h3>

                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p class="small">Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>