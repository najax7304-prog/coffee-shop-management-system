<?php
// 1. Bilaab ama fur session-ka haddii uusan furneyn
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Masax dhammaan xogta ku jirta session-ka
$_SESSION = array();

// 3. Haddii la isticmaalayo cookies-ka session-ka, iyagana tirtir
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Gebi ahaanba burburi session-ka
session_destroy();

// 5. Dib ugu celi ama u leexi macmiilka bogga Hoga (Home/Index) ama Login-ka
header("Location: index.php");
exit();
?>