<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (!isset($_GET['order_id'])) {
    echo "Lỗi: Không tìm thấy đơn hàng.";
    exit();
}

$orderID = intval($_GET['order_id']);

// Lấy thông tin đơn hàng từ cơ sở dữ liệu
$order_sql = "SELECT o.OrderDate, o.TotalPrice, o.Address, o.Phone, o.Status, u.Username
              FROM Orders o
              JOIN Users u ON o.UserID = u.UserID
              WHERE o.OrderID = $orderID";
$order_result = $conn->query($order_sql);

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    echo "Lỗi: Không tìm thấy thông tin đơn hàng.";
    exit();
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xác nhận Đơn Hàng</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="logo">
        <h1>BookStore</h1>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="cart.php">Giỏ hàng</a></li>
          <li><a href="order_history.php">Quản lý Đơn Hàng</a></li>
          <li><a href="profile.php">Chào, <?php echo $_SESSION['username']; ?></a></li>
          <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="order-confirmation">
    <h2>Xác nhận Đơn Hàng</h2>
    <p>Cảm ơn bạn, <strong><?php echo $order['Username']; ?></strong>! Đơn hàng của bạn đã được tiếp nhận.</p>
    <p><strong>Mã đơn hàng:</strong> #<?php echo $orderID; ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?php echo $order['OrderDate']; ?></p>
    <p><strong>Địa chỉ giao hàng:</strong> <?php echo $order['Address']; ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo $order['Phone']; ?></p>
    <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TotalPrice'], 0, ',', '.'); ?> VNĐ</p>
    <p><strong>Trạng thái:</strong> <?php echo $order['Status']; ?></p>
  </section>

  <footer>
    <div class="container">
      <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
    </div>
  </footer>
</body>
</html>
