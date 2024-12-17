<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  // Lấy tên người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  // Lấy role từ session (1 là admin)

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách người dùng
$sql = "SELECT UserID, Username, FullName, Email, CreatedAt, Role FROM users";
$result = $conn->query($sql);

// Xử lý xóa người dùng nếu có yêu cầu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $userID = $_POST['user_id'];

    // Xóa người dùng khỏi cơ sở dữ liệu
    $delete_sql = "DELETE FROM users WHERE UserID = $userID";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Xóa người dùng thành công.";
    } else {
        echo "Lỗi khi xóa người dùng: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Quản Lý Người Dùng</h1>
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
            <table class="user-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Tài Khoản</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Ngày Tạo</th>
                        <th>Vai Trò</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($user = $result->fetch_assoc()) {
                            // Xử lý vai trò người dùng
                            $role = $user['Role'] == 1 ? 'Admin' : 'Khách Hàng';

                            // Hiển thị thông tin người dùng
                            echo "<tr>
                                    <td>" . $counter . "</td>
                                    <td>" . $user['Username'] . "</td>
                                    <td>" . $user['FullName'] . "</td>
                                    <td>" . $user['Email'] . "</td>
                                    <td>" . $user['CreatedAt'] . "</td>
                                    <td>" . $role . "</td>
                                    <td>
                                        <form method='POST' action='admin_users.php' style='display:inline;'>
                                            <input type='hidden' name='user_id' value='" . $user['UserID'] . "'>
                                        </form>
                                    </td>
                                  </tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Không có người dùng nào.</td></tr>";
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>
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
