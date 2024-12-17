-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 04, 2024 lúc 12:31 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bookstore`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authors`
--

CREATE TABLE `authors` (
  `AuthorID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Biography` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `authors`
--

INSERT INTO `authors` (`AuthorID`, `Name`, `Biography`, `CreatedAt`) VALUES
(1, 'Nguyễn Nhật Ánh', 'Tác giả nổi tiếng với các tác phẩm cho tuổi mới lớn.', '2024-12-02 10:07:43'),
(2, 'J.K. Rowling', 'Tác giả của bộ truyện Harry Potter nổi tiếng.', '2024-12-02 10:07:43'),
(3, 'George R.R. Martin', 'Tác giả của loạt truyện A Song of Ice and Fire.', '2024-12-02 10:07:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogposts`
--

CREATE TABLE `blogposts` (
  `PostID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Author` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blogposts`
--

INSERT INTO `blogposts` (`PostID`, `Title`, `Content`, `Author`, `CreatedAt`, `UpdatedAt`) VALUES
(6, 't', 'tttt', 't', '2024-12-02 19:22:31', '2024-12-02 19:22:31'),
(7, 'r', 'r', 'r', '2024-12-02 23:11:24', '2024-12-02 23:11:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `CoverImage` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `PublishYear` int(11) DEFAULT NULL,
  `Publisher` varchar(255) DEFAULT NULL,
  `Stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `CategoryID`, `Price`, `Description`, `CoverImage`, `CreatedAt`, `PublishYear`, `Publisher`, `Stock`) VALUES
(1, 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'Nguyễn Nhật Ánh', 1, 120000.00, 'Một tác phẩm văn học nổi tiếng.', 'uploads/67500ce837b2f-th.jpg', '2024-12-01 20:36:07', 1522, '1', 49),
(2, 'Đắc Nhân Tâm', 'Dale Carnegie', 2, 150000.00, 'Sách về nghệ thuật giao tiếp và lãnh đạo.', 'uploads/67500d20ddc81-th (1).jpg', '2024-12-01 20:36:07', 1555, '4', 50),
(3, 'Hoàng Tử Bé', 'Antoine de Saint-Exupéry', 1, 150000.00, 'là tiểu thuyết nổi tiếng nhất của nhà văn và phi công Pháp Antoine de Saint-Exupéry', 'https://bookbuy.vn/Res/Images/Product/hoang-tu-be-nxb-kim-dong-ban-2016-_55406_1.jpg', '2024-12-02 11:12:35', NULL, NULL, 46),
(4, 'Chiến binh cầu vồng', 'Andrea Hirata', 2, 200000.00, 'Chiến binh cầu vồng (tiếng Indonesia: Laskar Pelangi) là tác phẩm văn học thiếu nhi nổi tiếng của nhà văn Indonesia Andrea Hirata.', 'https://tusachtiasang.org/wp-content/uploads/2022/05/3-review-chien-binh-cau-vong-min.jpg', '2024-12-02 11:12:35', NULL, NULL, 44),
(5, 'Giết con chim nhại', 'Harper Lee', 1, 120000.00, 'là cuốn tiểu thuyết của Harper Lee; đây là cuốn tiểu thuyết rất được yêu chuộng, thuộc loại bán chạy nhất thế giới với hơn 10 triệu bản. Cuốn tiểu thuyết được xuất bản vào năm 1960 và đã giành được giải Pulitzer cho tác phẩm hư cấu năm 1961. Nội dung tiểu thuyết dựa vào cuộc đời của nhiều bạn bè và họ hàng tác giả, nhưng tên nhân vật đã được thay đổi. Tác giả cho biết hình mẫu nhân vật Jean Louise \"Scout\" Finch, người dẫn truyện, được xây dựng dựa vào chính bản thân mình.', 'https://static.ybox.vn/2021/11/2/1637057238185-GI%E1%BA%BET%20CON%20CHIM%20NH%E1%BA%A0I.png', '2024-12-02 11:12:35', NULL, NULL, 48),
(6, 'Không gia đình', 'Hector Malot', 3, 180000.00, 'có thể được xem là tiểu thuyết nổi tiếng nhất của nhà văn Pháp Hector Malot, được xuất bản năm 1878. Tác phẩm đã nhận được giải thưởng của Viện Hàn lâm Văn học Pháp. Nhiều nước trên thế giới đã dịch lại tác phẩm và xuất bản nhiều lần. Từ một trăm năm nay, Không gia đình đã trở nên quen thuộc đối với thiếu nhi Pháp và thế giới. Kiệt tác này đã được xuất hiện nhiều lần trên phim ảnh và truyền hình.', 'https://www.elle.vn/app/uploads/2018/11/27/elle-viet-nam-khong-gia-dinh-tung-poster-9.jpg', '2024-12-02 11:12:35', NULL, NULL, 48),
(7, 'Rừng Na Uy', 'Murakami Haruki', 2, 250000.00, 'là tiểu thuyết của nhà văn Nhật Bản Murakami Haruki, được xuất bản lần đầu năm 1987. Với thủ pháp dòng ý thức, cốt truyện diễn tiến trong dòng hồi tưởng của nhân vật chính là chàng sinh viên bình thường Watanabe Tōru. Cậu ta đã trải qua nhiều cuộc tình chớp nhoáng với nhiều cô gái trẻ ưa tự do. Nhưng cậu ta cũng có những mối tình sâu nặng, điển hình là với Naoko, người yêu của người bạn thân nhất của cậu, một cô gái không ổn định về cảm xúc, và với Midori, một cô gái thẳng thắn và hoạt bát. Các nhân vật trong truyện hầu hết là những con người cô đơn móc nối với nhau. Có những nhân vật đã phải tìm đến cái chết để mãi mãi giải thoát khỏi nỗi đau đớn ấy.\n\nCâu chuyện xảy ra với bối cảnh là nước Nhật những năm 1960, khi mà thanh niên Nhật Bản, như thanh niên nhiều nước khác đương thời, đấu tranh chống lại những định kiến tồn tại trong xã hội. Murakami miêu tả những sinh viên cải cách này như những tên đạo đức giả và thiếu sự kiên định.', 'https://www.wowweekend.vn/document_root/upload/articles/image/BrowseContent/LifeStyle/202104/R%E1%BB%ABng%20Na%20Uy/4.jpg', '2024-12-02 11:12:35', NULL, NULL, 49),
(15, 'Bí Quyết Học Nhanh Nhớ Lâu', 'Jonathan Hancock', 4, 50000.00, 'Quyển sách Bí quyết học nhanh nhớ lâu là những bí quyết đơn thuần giúp bạn ghi nhớ lâu hơn, khai thác nhiều hơn tiềm năng não bộ của mình.\r\n\r\nNói một cách đơn giản, não trái đảm nhiệm việc tư duy, phân tích và não phải nhận thức về không gian, sáng tạo. Bạn sẽ không thể nhớ lâu hay học nhanh nếu không biết kết hợp cả hai bán cầu não này. Đó chính là một trong những bí quyết để bạn có thể ghi nhớ tốt hơn.', 'uploads/th (2).jpg', '2024-12-04 08:10:04', 2021, 'NXB Tổng Hợp TPHCM', 50),
(16, 'Bí Quyết Học Đâu Nhớ Đó', 'Peter C. Brown', 4, 10000.00, 'Quyển sách này sẽ thay đổi cuộc đời bạn. Nó sẽ giúp bạn học hành tấn tới, học đâu nhớ đó hay xuất sắc vượt qua các kỳ thi, nhưng lợi ích thật sự từ quyển sách vượt xa hơn thế nhiều - một khi vận dụng tốt các phương pháp trong sách này, bạn sẽ khai thác triệt để tiềm năng của bộ não mình. Rèn luyện trí nhớ đồng nghĩa với việc tổ chức lại cách thức tư duy, phát triển sự sáng tạo, mài dũa các kỹ năng học tập - đồng thời nâng cao dần những chuẩn mực cuộc sống và những đỉnh cao bạn có thể chinh phục. Bởi thế, luyện trí não không chỉ đơn thuần là cách để học tốt hơn mà còn là bước khởi đầu cho một cuộc đời mới.', 'uploads/th (3).jpg', '2024-12-04 08:26:47', 2019, 'NXB Lao Động', 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT 1,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`CartID`, `UserID`, `BookID`, `Quantity`, `CreatedAt`) VALUES
(6, 1, 2, 2, '2024-12-01 21:06:22'),
(7, 1, 1, 1, '2024-12-01 21:09:54'),
(38, 3, 16, 1, '2024-12-04 09:11:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`CategoryID`, `Name`, `Description`) VALUES
(1, 'Văn học', 'Sách văn học trong nước và quốc tế'),
(2, 'Kinh doanh', 'Sách về kinh doanh và khởi nghiệp'),
(3, 'Thiếu nhi', 'Sách dành cho trẻ em'),
(4, 'Học tập', 'Sách giáo dục và học thuật');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `ContactID` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`ContactID`, `FullName`, `Email`, `Message`, `CreatedAt`) VALUES
(1, 'n', 'atm15092003@gmail.com', 'eeee', '2024-12-02 19:47:12'),
(2, 'n', 'atm15092003@gmail.com', 'eeee', '2024-12-02 19:48:43'),
(3, 'n', 'atm15092003@gmail.com', 'eeee', '2024-12-02 19:48:45'),
(4, 'n', 'atm15092003@gmail.com', 'eeee', '2024-12-02 19:49:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `message`, `created_at`) VALUES
(1, 'Đơn Hàng Mới', 'Có đơn hàng mới đã được tạo', '2024-12-02 23:34:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailID`, `OrderID`, `BookID`, `Quantity`, `Price`) VALUES
(13, 17, 4, 2, 200000.00),
(14, 18, 6, 1, 180000.00),
(15, 19, 5, 1, 120000.00),
(16, 20, 5, 1, 120000.00),
(17, 21, 7, 1, 250000.00),
(18, 22, 1, 1, 120000.00),
(19, 23, 4, 1, 200000.00),
(20, 24, 4, 1, 200000.00),
(21, 25, 3, 1, 150000.00),
(22, 26, 6, 1, 180000.00),
(23, 27, 4, 1, 200000.00),
(24, 28, 3, 3, 150000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalPrice` decimal(10,2) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'Chưa thanh toán',
  `DeliveryStatus` enum('Chưa giao','Đang giao','Đã giao') NOT NULL DEFAULT 'Chưa giao'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `Address`, `PaymentMethod`, `CreatedAt`, `TotalPrice`, `Phone`, `OrderDate`, `Status`, `DeliveryStatus`) VALUES
(9, 2, 'cầu diễn', 'COD', '2024-12-02 09:38:46', 120000.00, '0393650486', '2024-12-02 16:38:46', 'Hoàn tất', 'Đã giao'),
(13, 2, 'cầu diễn', 'COD', '2024-12-02 16:25:39', 150000.00, '0393650486', '2024-12-02 23:25:39', 'Hoàn tất', 'Đã giao'),
(14, 2, 'cầu diễn', 'CreditCard', '2024-12-02 16:26:33', 600000.00, '0393650486', '2024-12-02 23:26:33', 'Hoàn tất', 'Đã giao'),
(15, 3, 'cầu diễn', 'COD', '2024-12-02 22:03:27', 150000.00, '0393650486', '2024-12-03 05:03:27', 'Hoàn tất', 'Đã giao'),
(16, 3, 'cầu diễn', 'CreditCard', '2024-12-02 22:05:48', 200000.00, '0393650486', '2024-12-03 05:05:48', 'Hoàn tất', 'Đã giao'),
(17, 3, 'cầu diễn', 'CreditCard', '2024-12-02 22:09:29', 400000.00, '0393650486', '2024-12-03 05:09:29', 'Hoàn tất', 'Đã giao'),
(18, 3, 'cầu diễn', 'CreditCard', '2024-12-02 22:40:15', 180000.00, '0393650486', '2024-12-03 05:40:15', 'Hoàn tất', 'Đã giao'),
(19, 3, 'cầu diễn', 'COD', '2024-12-02 22:43:16', 120000.00, '0393650486', '2024-12-03 05:43:16', 'Hoàn tất', 'Đã giao'),
(20, 3, 'cầu diễn', 'COD', '2024-12-02 22:45:36', 120000.00, '0393650486', '2024-12-03 05:45:36', 'Hoàn tất', 'Đã giao'),
(21, 3, 'cầu diễn', 'COD', '2024-12-02 23:11:46', 250000.00, '0393650486', '2024-12-03 06:11:46', 'Hoàn tất', 'Đã giao'),
(22, 3, 'cầu diễn', 'COD', '2024-12-02 23:27:01', 120000.00, '0393650486', '2024-12-03 06:27:01', 'Hoàn tất', 'Đã giao'),
(23, 3, 'cầu diễn', 'COD', '2024-12-02 23:56:31', 200000.00, '0393650486', '2024-12-03 06:56:31', 'Hoàn tất', 'Đã giao'),
(24, 3, 'cầu diễn', 'EWallet', '2024-12-02 23:57:21', 200000.00, '0393650486', '2024-12-03 06:57:21', 'Hoàn tất', 'Đã giao'),
(25, 3, 'cầu diễn', 'COD', '2024-12-03 00:21:48', 150000.00, '0393650486', '2024-12-03 07:21:48', 'Hoàn tất', 'Đã giao'),
(26, 3, 'cầu diễn', 'COD', '2024-12-03 08:16:59', 180000.00, '0393650486', '2024-12-03 15:16:59', 'Hoàn tất', 'Đã giao'),
(27, 2, 'cầu diễn', 'CreditCard', '2024-12-04 07:20:46', 200000.00, '0393650486', '2024-12-04 14:20:46', 'Hoàn tất', 'Đã giao'),
(28, 3, 'cầu diễn', 'COD', '2024-12-04 07:26:53', 450000.00, '0393650486', '2024-12-04 14:26:53', 'Hoàn tất', 'Chưa giao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Comment` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `Role` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `FullName`, `Email`, `CreatedAt`, `Role`) VALUES
(2, 'admin', 'c81e728d9d4c2f636f067f89cc14862c', 'nam', 'atm15092003@gmail.com', '2024-12-01 21:20:39', 0),
(3, 'admin1', '1', '1', 'atm1509203@gmail.com', '2024-12-02 18:39:12', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Chỉ mục cho bảng `blogposts`
--
ALTER TABLE `blogposts`
  ADD PRIMARY KEY (`PostID`);

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `BookID` (`BookID`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`ContactID`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `BookID` (`BookID`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BookID` (`BookID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `authors`
--
ALTER TABLE `authors`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `blogposts`
--
ALTER TABLE `blogposts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `ContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`);

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
