<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die(json_encode(["message" => "Lỗi kết nối cơ sở dữ liệu."]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['user_id'] ?? 1; // Giả sử người dùng có ID = 1
    $bookID = intval($_POST['book_id']);

    $sql = "SELECT * FROM Cart WHERE UserID = $userID AND BookID = $bookID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Cập nhật số lượng nếu sách đã có trong giỏ
        $update_sql = "UPDATE Cart SET Quantity = Quantity + 1 WHERE UserID = $userID AND BookID = $bookID";
        $conn->query($update_sql);
        echo json_encode(["message" => "Đã tăng số lượng sách trong giỏ hàng."]);
    } else {
        // Thêm sách mới vào giỏ
        $insert_sql = "INSERT INTO Cart (UserID, BookID, Quantity) VALUES ($userID, $bookID, 1)";
        $conn->query($insert_sql);
        echo json_encode(["message" => "Đã thêm sách vào giỏ hàng."]);
    }
}

$conn->close();
?>
