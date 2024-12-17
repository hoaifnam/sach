<?php
session_start();
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$bookID = $_POST['book_id'];
$title = $_POST['title'];
$author = $_POST['author'];
$price = $_POST['price'];
$category = $_POST['category'];
$publishYear = $_POST['publish_year'];
$publisher = $_POST['publisher'];
$stock = $_POST['stock'];
$coverImage = null;

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $fileName = uniqid() . '-' . basename($_FILES['cover_image']['name']);
    $filePath = $uploadDir . $fileName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $filePath)) {
        $coverImage = $filePath;
    } else {
        die("Lỗi khi tải file lên.");
    }
}

$sql = "
    UPDATE Books 
    SET 
        Title = ?, 
        Author = ?, 
        Price = ?, 
        CategoryID = ?, 
        PublishYear = ?, 
        Publisher = ?, 
        Stock = ?, 
        CoverImage = IF(? IS NOT NULL, ?, CoverImage) 
    WHERE BookID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssdsissssi",
    $title,
    $author,
    $price,
    $category,
    $publishYear,
    $publisher,
    $stock,
    $coverImage,
    $coverImage,
    $bookID
);

if ($stmt->execute()) {
    header("Location: admin_books.php");
    exit;
} else {
    echo "Lỗi khi cập nhật sách: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
