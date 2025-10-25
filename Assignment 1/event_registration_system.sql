CREATE DATABASE event_system;

USE event_system;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  date DATE,
  location VARCHAR(150),
  capacity INT DEFAULT 0
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  srn VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  fullname VARCHAR(150),
  email VARCHAR(150)
);

CREATE TABLE participants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT,
  fullname VARCHAR(150),
  email VARCHAR(150),
  phone VARCHAR(50),
  FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  email VARCHAR(150),
  phone VARCHAR(50),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
