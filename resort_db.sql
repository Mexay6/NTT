-- Database: resort_booking
CREATE DATABASE IF NOT EXISTS resort_booking DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE resort_booking;

-- users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- rooms table
CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  capacity INT NOT NULL DEFAULT 2,
  area VARCHAR(50),
  quantity INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- room_images
CREATE TABLE room_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_id INT NOT NULL,
  filename VARCHAR(255) NOT NULL,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- bookings table
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_code VARCHAR(50) NOT NULL UNIQUE,
  user_id INT NOT NULL,
  room_id INT NOT NULL,
  checkin DATE NOT NULL,
  checkout DATE NOT NULL,
  guests INT NOT NULL DEFAULT 1,
  status ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- payments (simple)
CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  method VARCHAR(50),
  paid_at TIMESTAMP NULL,
  FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- seed admin user
INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@resort.com', '$2y$10$QQqRkVwB6JpG1gY2bG8A9u2qQxqjv0GQw2b/5J2s1Zk3d5qK9x1G6', 'admin');
-- password is bcrypt of "admin123" (generated for PHP password_verify)

-- seed sample rooms
INSERT INTO rooms (title,description,price,capacity,area,quantity) VALUES
('สแตนดาร์ด','ห้องมาตรฐาน ขนาดกะทัดรัด เหมาะสำหรับคู่รัก',900.00,2,'25 ตร.ม.',5),
('เดลักซ์','ห้องเดลักซ์ พร้อมวิวสวน',1500.00,2,'35 ตร.ม.',3),
('สวีท','ห้องสวีท ขนาดใหญ่ วิวทะเล',3500.00,3,'60 ตร.ม.',2),
('แฟมิลี่','ห้องสำหรับครอบครัว ขนาดใหญ่',2200.00,4,'70 ตร.ม.',2);

