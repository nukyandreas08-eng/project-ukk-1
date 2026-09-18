<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: login.php");
    exit;
}
function hanya_role(...$roles) {
    if (!in_array($_SESSION['level'] ?? '', $roles, true)) {
        header("Location: dashboard.php");
        exit;
    }
}
?>