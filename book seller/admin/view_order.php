<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$orderID = intval($_GET['order_id']);

$sql = "
SELECT b.Title, b.Author, od.Quantity, od.Price, (od.Quantity * od.Price) AS Subtotal
FROM OrderDetails od
JOIN Books b ON od.BookID = b.BookID
WHERE od.OrderID = $orderID
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <h1>Chi tiết đơn hàng</h1>
    <a href="admin_orders.php">Quay lại</a>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $detail['Title']; ?></td>
                        <td><?php echo $detail['Author']; ?></td>
                        <td><?php echo $detail['Quantity']; ?></td>
                        <td><?php echo number_format($detail['Price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($detail['Subtotal'], 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không tìm thấy thông tin chi tiết đơn hàng.</p>
    <?php endif; ?>
</body>
</html>
