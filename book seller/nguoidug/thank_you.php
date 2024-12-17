<?php
$status = $_GET['status'] ?? 'Chưa rõ';

if ($status == "Hoàn tất") {
    $message = "Cảm ơn bạn! Đơn hàng của bạn đã được thanh toán thành công.";
} elseif ($status == "Đang xử lý") {
    $message = "Đơn hàng của bạn đã được đặt. Chúng tôi sẽ liên hệ để xác nhận.";
} else {
    $message = "Đơn hàng của bạn chưa được thanh toán. Vui lòng kiểm tra lại!";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn</title>
</head>
<body>
    <h1>Cảm ơn bạn đã mua sắm tại BookStore!</h1>
    <p>Đơn hàng của bạn đã được xác nhận. Chúng tôi sẽ giao sách đến địa chỉ của bạn trong thời gian sớm nhất.</p>
    <a href="index.php">Quay lại trang chủ</a>
</body>
</html>
