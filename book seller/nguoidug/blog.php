<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy tất cả bài viết từ cơ sở dữ liệu
$sql = "SELECT * FROM BlogPosts ORDER BY CreatedAt DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - BookStore</title>
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
          <li><a href="add_blog_post.php">Thêm Blog mới</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    <section class="blog-list">
      <h2>Các bài viết mới nhất</h2>
      <?php
      if ($result->num_rows > 0) {
          while ($post = $result->fetch_assoc()) {
              echo "
              <div class='blog-item'>
                  <h3><a href='blog_detail.php?post_id=" . $post['PostID'] . "'>" . $post['Title'] . "</a></h3>
                  <p><strong>Tác giả:</strong> " . $post['Author'] . "</p>
                  <p><em>Ngày đăng:</em> " . $post['CreatedAt'] . "</p>
                  <p>" . substr($post['Content'], 0, 200) . "...</p>
              </div>";
          }
      } else {
          echo "<p>Chưa có bài viết nào.</p>";
      }
      ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
  </footer>
</body>
</html>
