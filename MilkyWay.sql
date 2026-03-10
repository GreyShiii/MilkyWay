USE milkyway;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  google_id VARCHAR(255) NULL UNIQUE,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  is_verified TINYINT(1) NOT NULL DEFAULT 0,
  verification_token VARCHAR(255) NULL,
  verification_token_expires_at DATETIME NULL,
  verification_sent_at DATETIME NULL,
  reset_token_hash VARCHAR(255) NULL,
  reset_token_expires_at DATETIME NULL,
  reset_sent_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME NULL,
  last_active_at DATETIME NULL,
  login_count INT NOT NULL DEFAULT 0,
  visit_count INT NOT NULL DEFAULT 0,
  UNIQUE KEY uniq_username (username)
);

CREATE TABLE breastfeeding_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  started_at DATETIME NOT NULL,
  ended_at DATETIME NOT NULL,
  duration_seconds INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_breastfeeding_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE user_activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  activity_type ENUM('login','visit','logout','view_page') NOT NULL DEFAULT 'visit',
  activity_label VARCHAR(255) NOT NULL,
  page_url VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_activity_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE feedback (
  feedback_id INT AUTO_INCREMENT PRIMARY KEY,
  rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  liked_design BOOLEAN DEFAULT 0,
  liked_content BOOLEAN DEFAULT 0,
  liked_easy BOOLEAN DEFAULT 0,
  liked_tips BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE daily_tips (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tip_text TEXT NOT NULL,
  is_active TINYINT(1) DEFAULT 1
);