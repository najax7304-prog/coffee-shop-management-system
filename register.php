<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../../connection.php'; // Ku beddel wadada saxda ah ee connection-kaaga

$msg = "";
$error = "";

if (isset($_POST['register'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Si loo ilaaliyo amaanka password-ka

    // Hubi in email-ku uusan horay u jirin
    $check = $conn->prepare("SELECT ID FROM customers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email-kan horay ayaa loo diiwaangeliyay, fadlan mid kale isticmaal.";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (firstname, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $password);
        
        if ($stmt->execute()) {
            $msg = "Waa lagu guuleystay diiwaangelinta! Hadda waad geli kartaa.";
        } else {
            $error = "Khalad ayaa dhacay: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8">
    <title>Customer Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">(Register)</h3>

                <?php if(!empty($msg)): ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">First Name </label>
                        <input type="text" class="form-control" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tell</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <p class="small">Do You Have An Account? <a href="login.php">Enter Here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>