<?php
session_start();
$username = $_SESSION['username'] ?? '';  // Lấy tên người dùng từ session
$role = $_SESSION['role'] ?? '';  // Lấy vai trò từ session (1 là admin)

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn lấy danh sách đơn hàng
$sql = "SELECT o.OrderID, o.TotalPrice, o.OrderDate, o.Status, o.DeliveryStatus, u.FullName
        FROM Orders o
        JOIN users u ON o.UserID = u.UserID";
$result = $conn->query($sql);

// Xử lý cập nhật trạng thái giao hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_delivery_status'])) {
    $orderID = intval($_POST['order_id']);
    $newStatus = $conn->real_escape_string($_POST['delivery_status']);

    // Kiểm tra trạng thái và cập nhật
    $updateSQL = $newStatus === 'Đã giao'
        ? "UPDATE Orders SET DeliveryStatus = '$newStatus', Status = 'Hoàn tất' WHERE OrderID = $orderID"
        : "UPDATE Orders SET DeliveryStatus = '$newStatus' WHERE OrderID = $orderID";

    if ($conn->query($updateSQL) === TRUE) {
        echo "<script>alert('Cập nhật trạng thái giao hàng thành công.'); window.location.href = 'admin_orders.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật trạng thái giao hàng: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Quản Lý Đơn Hàng</h1>
        </div>
    </header>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Trang Quản Trị</a></li>
                    <li><a href="admin_books.php">Quản Lý Sách</a></li>
                    <li><a href="admin_orders.php">Quản Lý Đơn Hàng</a></li>
                    <li><a href="admin_users.php">Quản Lý Người Dùng</a></li>
                    <li><a href="contact.php">Quản Lý Liên Hệ</a></li>
                    <?php if ($username): ?>
                        <li class="account-menu">
                            <a href="profile.php">Chào, <?php echo htmlspecialchars($username); ?></a>
                            <div class="dropdown-menu">
                                <?php if ($role == 1): ?>
                                    <p>Admin</p>
                                <?php endif; ?>
                                <a href="logout.php">Đăng xuất</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php">Đăng nhập</a></li>
                        <li><a href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Người Mua</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái Giao Hàng</th>
                        <th>Thao Tác</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                                <td><?php echo htmlspecialchars($order['FullName']); ?></td>
                                <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                                <td><?php echo number_format($order['TotalPrice'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?php echo htmlspecialchars($order['DeliveryStatus']); ?></td>
                                <td>
                                    <form method="POST" action="admin_orders.php" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['OrderID']); ?>">
                                        <select name="delivery_status">
                                            <option value="Chưa giao" <?php echo $order['DeliveryStatus'] == 'Chưa giao' ? 'selected' : ''; ?>>Chưa giao</option>
                                            <option value="Đang giao" <?php echo $order['DeliveryStatus'] == 'Đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                                            <option value="Đã giao" <?php echo $order['DeliveryStatus'] == 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                                        </select>
                                        <button type="submit" name="update_delivery_status">Cập nhật</button>
                                    </form>
                                </td>
                                <td><a href="view_order.php?order_id=<?php echo htmlspecialchars($order['OrderID']); ?>">Xem Chi Tiết</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8">Không có đơn hàng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>
