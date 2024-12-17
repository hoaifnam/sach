<?php
session_start();
session_unset(); // Hủy tất cả session
session_destroy(); // Hủy phiên làm việc

header("Location: index.php"); // Chuyển hướng về trang chủ
exit;
?>
