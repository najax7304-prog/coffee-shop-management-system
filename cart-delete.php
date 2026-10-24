<?php
// Include database connection
include '../../connection.php';

// Check if ID is passed in URL
if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];

    // Delete query
    $delete_query = "DELETE FROM cart WHERE ID = $cart_id";
    
    if (mysqli_query($conn, $delete_query)) {
        // Fariinta guusha iyo dib u celinta bogga
        echo "<script>
                alert('Badeecaddu si guul leh ayay u tirtirmatay .');
                window.location.href='cart.php';
              </script>";
        exit();
    } else {
        // Fariinta guul-darrada haddii cilad dhacdo
        echo "<script>
                alert('Cillad ayaa dhacday, fadlan ku celi markle. Mahadsanid');
                window.location.href='cart.php';
              </script>";
        exit();
    }
} else {
    header("Location: cart.php");
    exit();
}
?>