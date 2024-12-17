<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  // Lấy tên người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  // Lấy role từ session (1 là admin)

$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $publish_year = $_POST['publish_year'];
    $publisher = $_POST['publisher'];
    $stock = $_POST['stock'];

    // Xử lý upload hình ảnh bìa sách
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $imageName = $_FILES['cover_image']['name'];
        $imageTmp = $_FILES['cover_image']['tmp_name'];
        $imagePath = "uploads/" . $imageName;

        // Di chuyển file hình ảnh vào thư mục uploads
        move_uploaded_file($imageTmp, $imagePath);
    }

    // Chèn dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO Books (Title, Author, Price, CategoryID, Description, CoverImage, PublishYear, Publisher, Stock) 
            VALUES ('$title', '$author', '$price', '$category', '$description', '$imagePath', '$publish_year', '$publisher', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sản phẩm đã được thêm thành công!'); window.location.href='admin_books.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm sản phẩm: " . $conn->error . "');</script>";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <link rel="stylesheet" href="style.css"> <!-- Đảm bảo rằng bạn đã thêm file style.css -->
</head>

<body>
    <header>
        <div class="container">
            <h1>Thêm Sản Phẩm Mới</h1>
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
                        <!-- Hiển thị tên tài khoản và menu thả xuống -->
                        <li class="account-menu">
                            <a href="profile.php">Chào, <?php echo $username; ?></a>
                            <div class="dropdown-menu">
                                <?php if ($role == 1): ?>
                                    <!-- Nếu là Admin, hiển thị biểu tượng Admin -->
                                <?php endif; ?>
                                <a href="logout.php">Đăng xuất</a> <!-- Đường dẫn đăng xuất -->
                            </div>
                        </li>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập, hiển thị Đăng nhập và Đăng ký -->
                        <li><a href="login.php">Đăng nhập</a></li>
                        <li><a href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <section class="add-book-form">
                <h2>Nhập Thông Tin Sản Phẩm</h2>
                <a href="admin_books.php" class="back-button">Quay lại</a>

                <form action="add_book.php" method="POST" enctype="multipart/form-data">
                    <label for="title">Tên Sách:</label>
                    <input type="text" id="title" name="title" required><br><br>

                    <label for="author">Tác Giả:</label>
                    <input type="text" id="author" name="author" required><br><br>

                    <label for="price">Giá:</label>
                    <input type="number" id="price" name="price" step="0.01" required><br><br>

                    <label for="category">Danh Mục:</label>
                    <select id="category" name="category" required>
                        <option value="1">Sách Văn Học</option>
                        <option value="2">Sách Kinh Doanh</option>
                        <option value="3">Sách Thiếu nhi</option>
                        <option value="4">Sách Học Tập</option>

                        <!-- Các danh mục sẽ được hiển thị từ cơ sở dữ liệu -->
                    </select><br><br>

                    <label for="description">Mô Tả:</label>
                    <textarea id="description" name="description" rows="5" required></textarea><br><br>

                    <label for="publish_year">Năm Xuất Bản:</label>
                    <input type="number" id="publish_year" name="publish_year" required><br><br>

                    <label for="publisher">Nhà Xuất Bản:</label>
                    <input type="text" id="publisher" name="publisher" required><br><br>

                    <label for="stock">Số Lượng:</label>
                    <input type="number" id="stock" name="stock" required><br><br>

                    <label for="cover_image">Hình Ảnh Bìa:</label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" required><br><br>

                    <button type="submit">Thêm Sản Phẩm</button>
                </form>
            </section>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>

</html>
