<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'coffee_shop_db';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = "";
$error = "";

// 1. Qabashada codsiga lagu darayo bog cusub (Add New Page)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_page') {
    $page      = trim($_POST['page']);
    $link      = trim($_POST['link']);
    $icon      = trim($_POST['icon']);
    $page_type = trim($_POST['page_type']);
    $current_user = $_SESSION['username'] ?? 'Admin';

    if (!empty($page) && !empty($link)) {
        $stmt = $conn->prepare("INSERT INTO page (page, link, icon, page_type, user, regDate) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("sssss", $page, $link, $icon, $page_type, $current_user);
            if ($stmt->execute()) {
                $msg = "Bogga cusub si guul leh ayaa loo daray oo wuxuu ka muuqan doonaa liiska ruqhsadaha hoos!";
            } else {
                $error = "Khalad ayaa dhacay: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error = "Fadlan buuxi magaca bogga iyo link-ga.";
    }
}

// 2. Qabashada keydinta ruqhsadaha user-ka (Assigning Pages to Users via user_page)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_permissions') {
    $target_user_id = intval($_POST['user_id']);
    
    // Hel magaca user-ka si loo geliyo miiska user_page
    $uname_res = $conn->query("SELECT username FROM users WHERE id = $target_user_id");
    $uname_row = $uname_res->fetch_assoc();
    $current_username = $uname_row['username'] ?? '';

    // Tirtir ruqhsadihii hore ee user-kan si loo cusboonaysiiyo
    $conn->query("DELETE FROM user_page WHERE user_id = $target_user_id");

    if (!empty($_POST['selected_pages'])) {
        foreach ($_POST['selected_pages'] as $page_id) {
            $stmt = $conn->prepare("INSERT INTO user_page (user_id, page_id, user, regdate) VALUES (?, ?, ?, NOW())");
            if ($stmt) {
                $page_id_int = intval($page_id);
                $stmt->bind_param("iis", $target_user_id, $page_id_int, $current_username);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    $msg = "Ruqhsadaha user-ka si guul leh ayaa loo badelay!";
}

// Xogta loo baahan yahay in la soo bandhigo
$selected_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1;
$users_result = $conn->query("SELECT id, username FROM users");

// Soo qaado bogagga uu user-kan hore u haystay
$user_pages = [];
$up_res = $conn->query("SELECT page_id FROM user_page WHERE user_id = $selected_user_id");
while ($row = $up_res->fetch_assoc()) {
    $user_pages[] = $row['page_id'];
}
?>

<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8">
    <title>Manage Pages & Permissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light p-4">

<div class="container" style="max-width: 1000px;">
    <h2 class="mb-4 text-center">Maamulka Bogagga & Ruqhsadaha (Pages & Permissions)</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- QAYBTA 1AAD: Ku darida Bog Cusub miiska 'page' -->
        <div class="col-md-5">
            <div class="card p-3 shadow-sm mb-4">
                <h4 class="mb-3">Ku dar Bog Cusub</h4>
                <form action="" method="POST">
                    <input type="hidden" name="action" value="add_page">
                    <div class="mb-2">
                        <label class="form-label">Magaca Bogga (Page):</label>
                        <input type="text" name="page" class="form-control" required placeholder="Tusaale: Orders">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Linkiga (Link):</label>
                        <input type="text" name="link" class="form-control" required placeholder="Tusaale: orders.php">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Calaamadda (Icon):</label>
                        <input type="text" name="icon" class="form-control" placeholder="Tusaale: bi bi-cart">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nooca Bogga (Page Type):</label>
                        <input type="text" name="page_type" class="form-control" placeholder="Tusaale: Main">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kaydi Bogga</button>
                </form>
            </div>
        </div>

        <!-- QAYBTA 2AAD: Aragtida iyo Siiyida Permissions-ka User-ka (user_page) -->
        <div class="col-md-7">
            <div class="card p-3 shadow-sm">
                <h4 class="mb-3">Maaree Ruqhsadaha User-ka</h4>
                
                <!-- Dooro User-ka -->
                <form method="GET" action="" class="mb-3">
                    <label class="form-label">Xulo User-ka:</label>
                    <select name="user_id" class="form-select" onchange="this.form.submit()">
                        <?php 
                        if ($users_result) {
                            while($u = $users_result->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $u['id']; ?>" <?php if($u['id'] == $selected_user_id) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($u['username']); ?>
                            </option>
                        <?php 
                            endwhile;
                        } 
                        ?>
                    </select>
                </form>

                <!-- Form-ka Permissions-ka -->
                <form action="" method="POST">
                    <input type="hidden" name="action" value="save_permissions">
                    <input type="hidden" name="user_id" value="<?php echo $selected_user_id; ?>">

                    <div class="mb-3" style="max-height: 280px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                        <label class="form-label fw-bold">Bogagga La heli karo (Dynamic):</label>
                        <?php 
                        // Bogagga waxaa laga soo akhrinyaa miiska 'page' si toos ah
                        $pages_result = $conn->query("SELECT * FROM page");
                        if ($pages_result && $pages_result->num_rows > 0) {
                            while($p = $pages_result->fetch_assoc()): 
                                $is_checked = in_array($p['id'], $user_pages) ? 'checked' : '';
                        ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="selected_pages[]" value="<?php echo $p['id']; ?>" id="page_<?php echo $p['id']; ?>" <?php echo $is_checked; ?>>
                                <label class="form-check-label" for="page_<?php echo $p['id']; ?>">
                                    <strong><?php echo htmlspecialchars($p['page']); ?></strong> 
                                    <small class="text-muted">(<?php echo htmlspecialchars($p['link']); ?>)</small>
                                </label>
                            </div>
                        <?php 
                            endwhile;
                        } else {
                            echo '<p class="text-muted">Weli bog ma jiro. Fadlan dhinaca bidix ka dar bog cusub.</p>';
                        }
                        ?>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Keydi Ruqhsadaha</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>