USE MilkyWay;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'editor', 'viewer') NOT NULL DEFAULT 'viewer',
  user_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL,
  category_slug VARCHAR(100) NOT NULL UNIQUE,
  sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE videos (
  video_id INT AUTO_INCREMENT PRIMARY KEY,
  video_title VARCHAR(150) NOT NULL,
  category_id INT NOT NULL,
  video_type ENUM('upload', 'youtube', 'drive') NOT NULL DEFAULT 'upload',
  video_url VARCHAR(500) NOT NULL,
  thumbnail_url VARCHAR(500) DEFAULT NULL,
  duration_seconds INT NOT NULL DEFAULT 0,
  views INT NOT NULL DEFAULT 0,
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  video_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_videos_category
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE INDEX idx_videos_category_published ON videos (category_id, is_published);
