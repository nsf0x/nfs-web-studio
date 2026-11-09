-- ============================================================
-- NFS Web Studio — Database Schema
-- Database: web_agency (utf8mb4_unicode_ci)
-- ============================================================

CREATE DATABASE IF NOT EXISTS web_agency CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web_agency;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  last_login_at DATETIME NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  short_description VARCHAR(255),
  description TEXT,
  icon VARCHAR(100),
  sort_order INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  service_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  price DECIMAL(12,2) NOT NULL,
  price_note VARCHAR(100),
  delivery_days INT,
  revision_count INT,
  is_featured BOOLEAN DEFAULT FALSE,
  is_active BOOLEAN DEFAULT TRUE,
  sort_order INT DEFAULT 0,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

CREATE TABLE package_features (
  id INT AUTO_INCREMENT PRIMARY KEY,
  package_id INT NOT NULL,
  feature VARCHAR(255) NOT NULL,
  sort_order INT DEFAULT 0,
  FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);

CREATE TABLE clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  logo_url VARCHAR(255),
  website_url VARCHAR(255),
  industry VARCHAR(100),
  is_active BOOLEAN DEFAULT TRUE,
  sort_order INT DEFAULT 0
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  service_id INT NULL,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  description TEXT,
  thumbnail_url VARCHAR(255),
  project_url VARCHAR(255),
  tech_stack VARCHAR(255),
  completed_at DATE,
  is_featured BOOLEAN DEFAULT FALSE,
  is_published BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

CREATE TABLE testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NULL,
  person_name VARCHAR(100) NOT NULL,
  person_position VARCHAR(100),
  content TEXT NOT NULL,
  rating TINYINT DEFAULT 5,
  is_published BOOLEAN DEFAULT FALSE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
);

CREATE TABLE inquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(30),
  company VARCHAR(150),
  service_id INT NULL,
  package_id INT NULL,
  budget_range VARCHAR(50),
  message TEXT NOT NULL,
  status ENUM('new','contacted','negotiation','won','lost') DEFAULT 'new',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL,
  FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
);

CREATE TABLE faqs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  sort_order INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE
);

CREATE TABLE site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT
);

-- Initial data
INSERT INTO clients (name, slug, sort_order) VALUES
('Kaizen Kreasi Indonesia', 'kaizen-kreasi-indonesia', 1),
('Kaizen Mitra Indonesia', 'kaizen-mitra-indonesia', 2),
('PT Berlian Bangun Cipta', 'pt-berlian-bangun-cipta', 3),
('PT Cendikia Trust Integrity', 'pt-cendikia-trust-integrity', 4);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('brand_name', 'NFS Web Studio'),
('tagline', 'Website Profesional untuk Bisnis Anda'),
('phone', '0882-1274-3260'),
('whatsapp', '6288212743260'),
('email', 'naufalshaflyfawwaz@gmail.com');

INSERT INTO services (name, slug, short_description, sort_order) VALUES
('Website Company Profile', 'website-company-profile', 'Website profesional untuk membangun kredibilitas bisnis Anda.', 1),
('Website Toko Online', 'website-toko-online', 'Toko online lengkap dengan katalog dan checkout.', 2),
('Sistem Informasi Custom', 'sistem-informasi-custom', 'Aplikasi web sesuai kebutuhan proses bisnis Anda.', 3),
('Redesign & Maintenance', 'redesign-maintenance', 'Perbarui tampilan dan rawat website yang sudah ada.', 4);
