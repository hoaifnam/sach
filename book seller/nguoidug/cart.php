<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'] ?? 1; // Giả sử người dùng có ID = 1

// Kiểm tra và xử lý yêu cầu cập nhật số lượng
if (isset($_POST['update_quantity'])) {
    $cartID = $_POST['cartID'];
    $new_quantity = $_POST['quantity'];

    if ($new_quantity > 0) {
        $update_sql = "UPDATE Cart SET Quantity = $new_quantity WHERE CartID = $cartID AND UserID = $userID";
        $conn->query($update_sql);
    }
}

// Lấy thông tin giỏ hàng
$sql = "
SELECT c.CartID, b.Title, b.Price, c.Quantity, (b.Price * c.Quantity) AS Subtotal
FROM Cart c
JOIN Books b ON c.BookID = b.BookID
WHERE c.UserID = $userID
";
$result = $conn->query($sql);

// Kiểm tra xem có kết quả không
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Giỏ hàng</h1>
    <button onclick="goBack()">Quay lại</button>

    <form method="POST" action="cart.php">
    <table>
        <tr>
            <th>Tên sách</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
            <th>Hành động</th>
        </tr>

        <?php
        $total = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total += $row['Subtotal'];
                echo "
                <tr>
                    <td>{$row['Title']}</td>
                    <td>" . number_format($row['Price'], 0, ',', '.') . " VNĐ</td>
                    <td>
                        <button type='submit' name='update_quantity' value='decrease' class='quantity-btn' onclick='updateQuantity({$row['CartID']}, \"decrease\")'>-</button>
                        <input type='number' name='quantity' value='{$row['Quantity']}' min='1' class='quantity-input' id='quantity-{$row['CartID']}' />
                        <button type='submit' name='update_quantity' value='increase' class='quantity-btn' onclick='updateQuantity({$row['CartID']}, \"increase\")'>+</button>
                        <input type='hidden' name='cartID' value='{$row['CartID']}' />
                    </td>
                    <td><span id='subtotal-{$row['CartID']}'>" . number_format($row['Subtotal'], 0, ',', '.') . "</span> VNĐ</td>
                    <td><a href='remove_from_cart.php?id={$row['CartID']}'>Xóa</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Giỏ hàng trống</td></tr>";
        }
        ?>
    </table>
    </form>

    <h3>Tổng cộng: <span id="total"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span></h3>
    <a href="checkout.php"><button>Thanh toán</button></a>

    <script>
    function goBack() {
        window.history.back(); // Quay lại trang trước đó
    }

    function updateQuantity(cartID, action) {
        const quantityInput = document.querySelector(`#quantity-${cartID}`);
        let currentQuantity = parseInt(quantityInput.value);

        if (action === 'increase') {
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }

        quantityInput.value = currentQuantity;

        // Gửi yêu cầu cập nhật số lượng
        const form = document.querySelector('form');
        form.submit();
        
        // Cập nhật lại tổng giá cho sản phẩm này
        const price = parseFloat(document.querySelector(`#price-${cartID}`).innerText.replace(' VNĐ', '').replace(',', ''));
        const subtotal = currentQuantity * price;
        document.querySelector(`#subtotal-${cartID}`).innerText = subtotal.toFixed(0) + " VNĐ";
        
        // Cập nhật lại tổng cộng
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        const subtotals = document.querySelectorAll('[id^="subtotal-"]');
        subtotals.forEach(function(subtotal) {
            total += parseFloat(subtotal.innerText.replace(' VNĐ', '').replace(',', ''));
        });
        document.querySelector('#total').innerText = total.toFixed(0) + " VNĐ";
    }
    </script>
</body>
</html>
