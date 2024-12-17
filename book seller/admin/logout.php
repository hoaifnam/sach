<?php
session_start();
session_unset();  // Hủy tất cả session variables
session_destroy();  // Hủy session

// Chuyển hướng về trang quản trị (admin_dashboard.php) sau khi đăng xuất thành công
header("Location: admin_dashboard.php");
exit;
?>
