-- Update schema cho bảng news
-- Chạy file này để thêm các cột mới vào bảng news

-- Thêm cột summary
ALTER TABLE `news` ADD COLUMN `summary` TEXT NULL AFTER `title`;

-- Thêm cột category
ALTER TABLE `news` ADD COLUMN `category` VARCHAR(50) NULL AFTER `content`;

-- Thêm cột views
ALTER TABLE `news` ADD COLUMN `views` INT(11) DEFAULT 0 AFTER `category`;

-- Thêm cột published_date
ALTER TABLE `news` ADD COLUMN `published_date` DATE NULL AFTER `image_url`;

-- Cập nhật lại structure để phù hợp
-- Bảng news sau khi update sẽ có cấu trúc:
/*
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `author_id` int(11) NOT NULL COMMENT 'ID của admin viết bài',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

-- Insert dữ liệu mẫu
INSERT INTO `news` (`title`, `summary`, `content`, `category`, `views`, `image_url`, `published_date`, `author_id`) VALUES
('Lợi ích của việc đọc sách mỗi ngày đối với trí não',
 'Đọc sách không chỉ giúp mở rộng kiến thức mà còn cải thiện trí nhớ, tăng khả năng tập trung và giảm căng thẳng hiệu quả...',
 'Đọc sách là một trong những hoạt động trí tuệ tốt nhất mà con người có thể thực hiện. Nhiều nghiên cứu khoa học đã chứng minh rằng việc đọc sách thường xuyên mang lại nhiều lợi ích đáng kể cho não bộ và sức khỏe tinh thần.',
 'kien-thuc',
 1250,
 'images/news-page/loi-ich-doc-sach-doi-voi-tri-nao.jpg',
 '2024-10-15',
 106),

('Top 10 cuốn sách nên đọc trong đời',
 'Dưới đây là danh sách 10 cuốn sách kinh điển mà mỗi người nên đọc ít nhất một lần trong đời để mở mang tri thức và hiểu biết...',
 'Mỗi cuốn sách là một thế giới, mỗi trang sách là một trải nghiệm mới. Dưới đây là danh sách 10 cuốn sách kinh điển mà bạn nên đọc ít nhất một lần trong đời.',
 'sach-hay',
 2100,
 'images/news-page/top-10-cuon-sach-nen-doc-trong-doi.jpg',
 '2024-10-10',
 106);
