<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có tham số post_id trong URL hay không
if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
    // Lấy thông tin bài viết từ cơ sở dữ liệu
    $sql = "SELECT * FROM BlogPosts WHERE PostID = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "<p>Bài viết không tồn tại.</p>";
        exit;
    }
} else {
    echo "<p>Không có bài viết nào được chọn.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $post['Title']; ?> - BookStore</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="container">
      <h1>Blog - BookStore</h1>
      <nav>
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="cart.php">Giỏ hàng</a></li>
          <li><a href="blog.php">Blog</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    <section class="blog-detail">
      <h2><?php echo $post['Title']; ?></h2>
      <p><strong>Tác giả:</strong> <?php echo $post['Author']; ?></p>
      <p><em>Ngày đăng:</em> <?php echo $post['CreatedAt']; ?></p>
      <div class="content">
        <p><?php echo nl2br($post['Content']); ?></p>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
  </footer>
</body>
</html>
