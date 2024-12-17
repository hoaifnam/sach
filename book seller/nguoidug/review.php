<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập để đánh giá sách.";
    exit;
}

if (isset($_POST['rating'], $_POST['comment'], $_GET['book_id'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $userID = $_SESSION['user_id'];
    $bookID = $_GET['book_id'];

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "BookStore");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Thêm đánh giá vào bảng Reviews
    $sql = "INSERT INTO Reviews (UserID, BookID, Rating, Comment) VALUES ($userID, $bookID, $rating, '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "Cảm ơn bạn đã gửi đánh giá!";
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Lỗi: Dữ liệu không hợp lệ.";
}
?>
