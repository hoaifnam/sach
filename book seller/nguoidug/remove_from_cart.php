<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $cartID = intval($_GET['id']);
    $sql = "DELETE FROM Cart WHERE CartID = $cartID";
    if ($conn->query($sql) === TRUE) {
        header("Location: cart.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
