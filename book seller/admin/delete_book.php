<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID của sách cần xóa
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Xóa sách khỏi cơ sở dữ liệu
    $sql = "DELETE FROM Books WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "Sách đã được xóa thành công.";
        // Chuyển hướng lại trang quản lý sách sau khi xóa
        header("Location: admin_books.php");
    } else {
        echo "Lỗi khi xóa sách: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Không có sách để xóa.";
}

$conn->close();
?>
