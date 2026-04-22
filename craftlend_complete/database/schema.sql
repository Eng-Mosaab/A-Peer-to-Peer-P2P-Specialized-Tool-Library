DROP DATABASE IF EXISTS craftlend_complete;
CREATE DATABASE craftlend_complete CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE craftlend_complete;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  location VARCHAR(150) NULL,
  verification_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
  created_at DATETIME NULL,
  CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE tools (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lender_id INT NOT NULL,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  description TEXT NULL,
  tool_condition VARCHAR(100) NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Available',
  daily_rate DECIMAL(10,2) NOT NULL DEFAULT 0,
  deposit_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  location VARCHAR(150) NULL,
  availability_notes VARCHAR(255) NULL,
  image_path VARCHAR(255) NULL,
  document_path VARCHAR(255) NULL,
  created_at DATETIME NULL,
  CONSTRAINT fk_tools_lender FOREIGN KEY (lender_id) REFERENCES users(id),
  CONSTRAINT fk_tools_category FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  borrower_id INT NOT NULL,
  tool_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Pending',
  notes TEXT NULL,
  created_at DATETIME NULL,
  CONSTRAINT fk_res_borrower FOREIGN KEY (borrower_id) REFERENCES users(id),
  CONSTRAINT fk_res_tool FOREIGN KEY (tool_id) REFERENCES tools(id)
);

CREATE TABLE maintenance_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tool_id INT NOT NULL,
  created_by INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  description TEXT NULL,
  priority VARCHAR(30) NOT NULL DEFAULT 'Medium',
  status VARCHAR(50) NOT NULL DEFAULT 'Open',
  evidence_path VARCHAR(255) NULL,
  created_at DATETIME NULL,
  CONSTRAINT fk_main_tool FOREIGN KEY (tool_id) REFERENCES tools(id),
  CONSTRAINT fk_main_user FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NULL,
  CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE email_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  recipient_email VARCHAR(190) NOT NULL,
  subject VARCHAR(190) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NULL
);

INSERT INTO roles (name) VALUES
('Admin'), ('Librarian'), ('Borrower'), ('Lender'), ('Technician');

INSERT INTO categories (name) VALUES
('Power Tools'), ('Hand Tools'), ('Cutting Tools'), ('Sanding Tools'), ('Safety Equipment');
