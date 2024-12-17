<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID sản phẩm từ URL
if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);
    // Lấy thông tin chi tiết sản phẩm
    $sql = "SELECT * FROM Books WHERE BookID = $book_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("Sản phẩm không tồn tại.");
    }
} else {
    die("Không có ID sản phẩm.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - <?php echo $book['Title']; ?></title>
</head>
<body>
    <header>
        <h1><a href="index.php">BookStore</a></h1>
    </header>

    <main>
        <h2>Chi tiết sản phẩm</h2>
        <div class="product-detail">
            <img src="<?php echo $book['CoverImage']; ?>" alt="<?php echo $book['Title']; ?>" width="200">
            <h3><?php echo $book['Title']; ?></h3>
            <p><strong>Tác giả:</strong> <?php echo $book['Author']; ?></p>
            <p><strong>Danh mục:</strong> <?php echo $book['CategoryID']; ?></p>
            <p><strong>Giá:</strong> <?php echo number_format($book['Price'], 0, ',', '.') . " VNĐ"; ?></p>
            <p><strong>Mô tả:</strong> <?php echo $book['Description']; ?></p>
            <button onclick="addToCart(<?php echo $book['BookID']; ?>)">Thêm vào giỏ hàng</button>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
    </footer>

    <script>
        function addToCart(bookID) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'book_id=' + bookID
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => console.error('Lỗi:', error));
        }
    </script>
</body>
</html>
