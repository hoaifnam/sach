<?php
session_start();
$userID = $_SESSION['user_id'] ?? 0; // Lấy UserID từ session

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn danh sách đơn hàng của người dùng
$sql = "SELECT OrderID, TotalPrice, OrderDate, DeliveryStatus 
        FROM Orders 
        WHERE UserID = $userID 
        ORDER BY OrderDate DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đơn Hàng</title>
</head>
<body>
    <h1>Lịch Sử Đơn Hàng</h1>
    <a href="index.php">Quay lại trang chủ</a>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái Giao Hàng</th>
                    <th>Xem chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                        <td><?php echo number_format($order['TotalPrice'], 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <?php
                            // Xử lý trạng thái giao hàng
                            switch ($order['DeliveryStatus']) {
                                case 'Chưa giao':
                                    echo "Chưa giao";
                                    break;
                                case 'Đang giao':
                                    echo "Đang giao hàng";
                                    break;
                                case 'Đã giao':
                                    echo "Đã giao";
                                    break;
                                default:
                                    echo "Không xác định";
                                    break;
                            }
                            ?>
                             </td>
                        <td><a href="order_detail.php?order_id=<?php echo htmlspecialchars($order['OrderID']); ?>">Xem chi tiết</a></td>
                    </tr>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Bạn chưa có đơn hàng nào.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
