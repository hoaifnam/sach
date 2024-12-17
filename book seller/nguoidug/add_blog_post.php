<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm Bài Viết Mới - Blog</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
    }

    textarea {
      resize: none; /* Không cho phép thay đổi kích thước */
    }

    button {
      display: block;
      width: 100%;
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #0056b3;
    }

    button:active {
      background-color: #003f7f;
    }

    @media (max-width: 600px) {
      .form-container {
        padding: 15px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Thêm Bài Viết Mới</h2>
    <form method="POST" action="">
      <label for="title">Tiêu đề:</label>
      <input type="text" id="title" name="title" required>

      <label for="author">Tác giả:</label>
      <input type="text" id="author" name="author" required>

      <label for="content">Nội dung:</label>
      <textarea id="content" name="content" rows="10" required></textarea>

      <button type="submit">Thêm bài viết</button>
    </form>
  </div>
</body>
</html>
