<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  // Lấy tên người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  // Lấy role từ session (1 là admin)

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy tổng số sách
$sql_books = "SELECT SUM(Stock) AS total_books FROM Books";
$result_books = $conn->query($sql_books);
$total_books = 0;
if ($result_books->num_rows > 0) {
    $row = $result_books->fetch_assoc();
    $total_books = $row['total_books'];
}

// Lấy tổng số đơn hàng từ bảng orderdetails
$sql_orders = "SELECT COUNT(DISTINCT OrderID) AS total_orders FROM orderdetails";
$result_orders = $conn->query($sql_orders);
$total_orders = 0;
if ($result_orders->num_rows > 0) {
    $row = $result_orders->fetch_assoc();
    $total_orders = $row['total_orders'];
}

// Lấy tổng doanh thu từ bảng orders
$sql_revenue = "SELECT SUM(TotalPrice) AS total_revenue FROM orders";
$result_revenue = $conn->query($sql_revenue);
$total_revenue = 0;
if ($result_revenue->num_rows > 0) {
    $row = $result_revenue->fetch_assoc();
    $total_revenue = $row['total_revenue'];
}

// Lấy tổng số người dùng
$sql_users = "SELECT COUNT(*) AS total_users FROM Users";
$result_users = $conn->query($sql_users);
$total_users = 0;
if ($result_users->num_rows > 0) {
    $row = $result_users->fetch_assoc();
    $total_users = $row['total_users'];
}

// Kiểm tra có đơn hàng mới không và thêm thông báo vào bảng notifications
$sql_last_order = "SELECT MAX(OrderID) AS last_order FROM orderdetails";
$result_last_order = $conn->query($sql_last_order);
$last_order = 0;
if ($result_last_order->num_rows > 0) {
    $row = $result_last_order->fetch_assoc();
    $last_order = $row['last_order'];
}

// Kiểm tra nếu đơn hàng mới được thêm vào (so với đơn hàng cuối cùng đã biết)
$notification_added = false;
if ($last_order > 0) {
    // Thêm thông báo nếu có đơn hàng mới
    $sql_notify_order = "SELECT * FROM notifications WHERE type = 'Đơn Hàng Mới' AND message = 'Có đơn hàng mới đã được tạo' ORDER BY created_at DESC LIMIT 1";
    $result_notify_order = $conn->query($sql_notify_order);
    
    if ($result_notify_order->num_rows == 0) {
        // Thêm thông báo nếu chưa có thông báo nào về đơn hàng mới
        $sql_notify_order_insert = "INSERT INTO notifications (type, message) VALUES ('Đơn Hàng Mới', 'Có đơn hàng mới đã được tạo')";
        $conn->query($sql_notify_order_insert);
        $notification_added = true;
    }
}

// Lấy thông báo mới nhất
$sql_notifications = "SELECT * FROM notifications WHERE type IN ('Đơn Hàng Mới', 'Blog Mới') ORDER BY created_at DESC LIMIT 1";
$result_notifications = $conn->query($sql_notifications);
$notifications = [];
if ($result_notifications->num_rows > 0) {
    while ($row = $result_notifications->fetch_assoc()) {
        $notifications[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Trang Quản Trị</h1>
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
                            <a href="profile.php">Chào, <?php echo $username; ?></a>
                            <div class="dropdown-menu">
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
            <section class="dashboard-stats">
                <div class="stat-box">
                    <h3>Số Sách</h3>
                    <p><?php echo $total_books; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Số Đơn Hàng</h3>
                    <p><?php echo $total_orders; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Doanh Thu</h3>
                    <p><?php echo number_format($total_revenue, 0, ',', '.'); ?> VNĐ</p>
                </div>
                <div class="stat-box">
                    <h3>Số Người Dùng</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
            </section>

            <section class="recent-activities">
                <h2>Hoạt Động Mới Nhất</h2>

                <div class="activity-box">
                    <h3>Thông Báo Mới Nhất</h3>
                    <ul>
                        <?php if (!empty($notifications)): ?>
                            <li>
                                <strong><?php echo $notifications[0]['type']; ?>:</strong> 
                                <?php echo $notifications[0]['message']; ?> 
                                <br><small>Ngày: <?php echo $notifications[0]['created_at']; ?></small>
                            </li>
                        <?php else: ?>
                            <li>Không có thông báo mới.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
<script>
    function fetchNotifications() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_notifications.php", true);
        xhr.onload = function () {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                const notificationBox = document.querySelector(".activity-box ul");
                if (response.notifications.length > 0) {
                    const latestNotification = response.notifications[0];
                    notificationBox.innerHTML = `
                        <li>
                            <strong>${latestNotification.type}:</strong> 
                            ${latestNotification.message} 
                            <br><small>Ngày: ${latestNotification.created_at}</small>
                        </li>
                    `;
                } else {
                    notificationBox.innerHTML = `<li>Không có thông báo mới.</li>`;
                }
            }
        };
        xhr.send();
    }

    // Gọi hàm fetchNotifications mỗi 10 giây
    setInterval(fetchNotifications, 10000);
</script>


</html>
