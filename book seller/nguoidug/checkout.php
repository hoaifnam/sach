<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'] ?? 1; // Giả sử người dùng có ID = 1

// Lấy giỏ hàng của người dùng
$sql = "
SELECT c.CartID, b.BookID, b.Title, b.Price, c.Quantity, (b.Price * c.Quantity) AS Subtotal
FROM Cart c
JOIN Books b ON c.BookID = b.BookID
WHERE c.UserID = $userID
";
$result = $conn->query($sql);

$total = 0;
$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total += $row['Subtotal'];
        $cart_items[] = $row;
    }
} else {
    echo "Giỏ hàng của bạn trống.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method']; // Lấy phương thức thanh toán

    // Mô phỏng kiểm tra thanh toán (nếu không phải COD)
    if ($payment_method != "COD") {
        // Giả sử thanh toán luôn thành công
        $is_paid = true; // Biến giả định
        if ($is_paid) {
            $status = "Hoàn tất"; // Thanh toán thành công
        } else {
            $status = "Chưa thanh toán"; // Thanh toán thất bại
        }
    } else {
        $status = "Đang xử lý"; // Với COD, cập nhật trạng thái đang xử lý
    }

    // Thêm đơn hàng vào bảng Orders
    $order_sql = "INSERT INTO Orders (UserID, TotalPrice, Address, Phone, PaymentMethod, Status) VALUES ($userID, $total, '$address', '$phone', '$payment_method', '$status')";
    if ($conn->query($order_sql) === TRUE) {
        $orderID = $conn->insert_id; // Lấy ID đơn hàng vừa tạo

        // Thêm chi tiết đơn hàng vào bảng OrderDetails
        foreach ($cart_items as $item) {
            $bookID = $item['BookID'];
            $quantity = $item['Quantity'];
            $order_detail_sql = "INSERT INTO OrderDetails (OrderID, BookID, Quantity, Price) VALUES ($orderID, $bookID, $quantity, {$item['Price']})";
            $conn->query($order_detail_sql);

            // Giảm số lượng sách trong kho
            $update_stock_sql = "UPDATE Books SET Stock = Stock - $quantity WHERE BookID = $bookID";
            $conn->query($update_stock_sql);
        }

        // Xóa giỏ hàng của người dùng sau khi thanh toán
        $delete_cart_sql = "DELETE FROM Cart WHERE UserID = $userID";
        $conn->query($delete_cart_sql);

        // Chuyển hướng đến trang cảm ơn hoặc trang xác nhận
        header("Location: thank_you.php?status=$status");
        exit();
    } else {
        echo "Lỗi khi tạo đơn hàng!";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
</head>
<body>
    <h2>Thông tin thanh toán</h2>
    <form method="POST" action="">
        <h3>Giỏ hàng của bạn</h3>
        <ul>
            <?php foreach ($cart_items as $item): ?>
                <li><?php echo $item['Title']; ?> - <?php echo number_format($item['Price'], 0, ',', '.'); ?> VNĐ x <?php echo $item['Quantity']; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</p>

        <label for="address">Địa chỉ giao hàng:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="payment_method">Hình thức thanh toán:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
            <option value="CreditCard">Thanh toán qua thẻ tín dụng</option>
            <option value="EWallet">Thanh toán qua ví điện tử</option>
        </select><br><br>

        <button type="submit">Thanh toán</button>
    </form>
</body>
</html>
