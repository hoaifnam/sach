<?php
session_start(); // Bắt đầu phiên làm việc

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Khởi tạo danh sách danh mục
$categories = [];

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username']; // Lấy tên tài khoản người dùng từ session
} else {
    $username = ''; // Nếu chưa đăng nhập, không có tên người dùng
}

// Truy vấn danh sách sách
$sql = "SELECT BookID, Title, Author, Price, CoverImage FROM Books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Bán Sách</title>
  <link rel="stylesheet" href="style.css">
  </head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <div class="logo">
        <h1>BookStore</h1>
      </div>
      <div class="search-bar">
        <form method="GET" action="">
          <input type="text" name="search" placeholder="Tìm kiếm sách, tác giả...">
          <button type="submit">Tìm kiếm</button>
        </form>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li class="account-menu">
    <a href="#">Danh Mục</a>
    <div class="dropdown-menu">
        <!-- Danh mục sách -->
        <a href="#">Sách</a>
        <ul class="submenu">
            <?php
            // Lấy danh mục sách từ cơ sở dữ liệu
            $categories_sql = "SELECT * FROM Categories";
            $categories_result = $conn->query($categories_sql);
            if ($categories_result->num_rows > 0) {
                while ($category = $categories_result->fetch_assoc()) {
                    echo "<li><a href='?category=" . $category['CategoryID'] . "'>" . $category['Name'] . "</a></li>";
                }
            } else {
                echo "<li>Không có danh mục sách nào.</li>";
            }
            ?>
        </ul>
        
        <!-- Tác Giả -->
        <a href="#">Tác Giả</a>
        <ul class="submenu">
            <?php
            // Lấy danh sách tác giả từ cơ sở dữ liệu
            $authors_sql = "SELECT DISTINCT Author FROM Books ORDER BY Author ASC";
            $authors_result = $conn->query($authors_sql);
            if ($authors_result->num_rows > 0) {
                while ($author = $authors_result->fetch_assoc()) {
                    echo "<li><a href='?author=" . urlencode($author['Author']) . "'>" . $author['Author'] . "</a></li>";
                }
            } else {
                echo "<li>Không có tác giả nào.</li>";
            }
            ?>
        </ul>
    </div>
</li>

          <li><a href="blog.php">Blog</a></li>
          <li><a href="contact.php">Liên hệ</a></li>
          <li><a href="cart.php">Giỏ hàng</a></li>
          <?php if ($username): ?>
          <!-- Hiển thị tên tài khoản và menu thả xuống -->
          <li class="account-menu">
            <a href="profile.php">Chào, <?php echo $username; ?></a>
            <div class="dropdown-menu">
              <a href="order_history.php">Quản lý Đơn Hàng</a>
              <a href="logout.php">Đăng xuất</a>
            </div>
          </li>
          <?php else: ?>
            <li><a href="login.php">Đăng nhập</a></li>
            <li><a href="register.php">Đăng ký</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Banner -->
  <section class="banner">
    <h2>Khuyến mãi đặc biệt: Giảm giá 50% tất cả các đầu sách!</h2>
  </section>

  <!-- Main Content -->
  <main class="container">
    <aside class="sidebar">
      <h3>Danh mục sách</h3>
      <ul>
        <?php
        // Kết nối cơ sở dữ liệu
        $conn = new mysqli("localhost", "root", "", "BookStore");
        if ($conn->connect_error) {
          die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy danh mục sách
        $categories_sql = "SELECT * FROM Categories";
        $categories_result = $conn->query($categories_sql);

        if ($categories_result->num_rows > 0) {
          while ($category = $categories_result->fetch_assoc()) {
            echo "<li><a href='?category=" . $category['CategoryID'] . "'>" . $category['Name'] . "</a></li>";
          }
        }
        ?>
      </ul>

      <h3>Tác giả</h3>
      <ul>
        <?php
        // Lấy danh sách tác giả
        $authors_sql = "SELECT DISTINCT Author FROM Books ORDER BY Author ASC";
        $authors_result = $conn->query($authors_sql);

        if ($authors_result->num_rows > 0) {
          while ($author = $authors_result->fetch_assoc()) {
            echo "<li><a href='?author=" . urlencode($author['Author']) . "'>" . $author['Author'] . "</a></li>";
          }
        } else {
          echo "<li>Không có tác giả nào.</li>";
        }
        ?>
      </ul>
    </aside>

    <section class="book-list">
      <h3>Sách mới</h3>
      <div class="book-items">
        <?php
        // Lấy sách từ cơ sở dữ liệu
        $sql = "SELECT * FROM Books ORDER BY CreatedAt DESC LIMIT 10";
        if (isset($_GET['category'])) {
          $category_id = intval($_GET['category']);
          $sql = "SELECT * FROM Books WHERE CategoryID = $category_id ORDER BY CreatedAt DESC";
        } elseif (isset($_GET['search'])) {
          $search = $conn->real_escape_string($_GET['search']);
          $sql = "SELECT * FROM Books WHERE Title LIKE '%$search%' OR Author LIKE '%$search%'";
        } elseif (isset($_GET['author'])) {
          $author = $conn->real_escape_string($_GET['author']);
          $sql = "SELECT * FROM Books WHERE Author = '$author' ORDER BY CreatedAt DESC";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($book = $result->fetch_assoc()) {
              echo "
              <div class='book-item'>
                  <img src='" . $book['CoverImage'] . "' alt='" . $book['Title'] . "'>
                  <h4>" . $book['Title'] . "</h4>
                  <p>Giá: " . number_format($book['Price'], 0, ',', '.') . " VNĐ</p>
                  <a href='product_detail.php?id=" . $book['BookID'] . "'>Xem chi tiết</a>
                  <button onclick=\"addToCart(" . $book['BookID'] . ")\">Thêm vào giỏ</button>
              </div>";
          }
        } else {
          echo "<p>Không tìm thấy sách nào.</p>";
        }
        ?>
      </div>
    </section>

    
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
    </div>
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
