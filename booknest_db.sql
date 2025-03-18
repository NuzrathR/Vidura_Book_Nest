DROP DATABASE IF EXISTS booknest_db;
CREATE DATABASE booknest_db;
USE booknest_db;

DROP TABLE IF EXISTS books;
CREATE TABLE books (
  acc_no INT(11) NOT NULL,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(500) NOT NULL,
  category VARCHAR(50) NOT NULL,
  author VARCHAR(255) NOT NULL,
  copies INT(11) NOT NULL,
  publisher VARCHAR(255) NOT NULL,
  isbn VARCHAR(50) NOT NULL,
  copyright_year YEAR(4) NOT NULL,
  class_no VARCHAR(50) NOT NULL,
  price DOUBLE NOT NULL,
  status VARCHAR(50) NOT NULL,
  comment VARCHAR(255) NOT NULL,
  file_path VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (acc_no),
  UNIQUE KEY isbn (isbn)
);

INSERT INTO books (acc_no, title, image, category, author, copies, publisher, isbn, copyright_year, class_no, price, status, comment, file_path) VALUES
(1, 'River sing me home', 'River Sing Me Home.jpeg', 'English Fiction', 'Elanor Shearer', 3, 'LBClassics', '14582-546584', '2015', 'CAR-F', 1450, 'Old', '', NULL),
(2, 'Princess Freedom', 'Princess Freedom.jpeg', 'English Fiction', 'Griggri Archembalo', 1, 'GAClassics', '785659-8569-4523', '2016', 'CAR-F', 1500, 'New', 'Donated by a student', NULL),
(3, 'A court for Ravens', 'A court for ravens.jpg', 'English Fiction', 'Layla Blue', 1, 'LBClassics', '7854-8569-965', '2019', 'CAR-F', 1500, 'New', '', NULL),
(4, 'City of Orange', 'City of Orange.jpeg', 'English Fiction', 'David Yoon', 2, 'New York Times', '74582-69853-6965', '2015', 'CAR-F', 750, 'New', '', NULL),
(5, 'The Harry Porter', 'The Harry Potter.jpg', 'English Fiction', 'J.K.Rowling', 1, 'Times Classics', '745-856', '2014', 'EF', 2000, 'New', 'Harry Porter and the Chamber of Secrets', NULL),
(6, 'A Short History of Everything', 'a short history of everything.jpeg', 'English Literature', 'Bill Bryson', 1, 'GClassics', '741-852', '2014', 'EF', 750, 'New', '', NULL),
(7, 'Sapiens', 'sapiens.jpeg', 'English Fiction', 'Null', 1, 'Classics', '785263-46522', '2014', 'CAR-F', 750, 'Old', '', NULL),
(8, 'To Name the Bigger Lie', 'To Name the Bigger Lie.jpeg', 'English Fiction', 'Sarah Viven', 1, 'mw', '456-789', '2015', 'CAR-F', 2100, 'New', '', 'https://drive.google.com/file/d/1dZqjZ_GGOb_gy9ehLgEefDitv21Rsjw5/view?usp=sharing');

DROP TABLE IF EXISTS members;
CREATE TABLE members (
  name TEXT NOT NULL,
  email VARCHAR(50) NOT NULL,
  contact_no CHAR(10) NOT NULL,
  grade_class VARCHAR(3) NOT NULL,
  user_id VARCHAR(10) NOT NULL,
  password VARCHAR(15) NOT NULL,
  PRIMARY KEY (user_id)
);

INSERT INTO members (name, email, contact_no, grade_class, user_id, password) VALUES
('Fazna Sheriffdeen', 'gfsheriffdeen@gmail.com', '0758528524', '11B', '4526', 'Qwerty@123'),
('Fathima', 'fathima@gmail.com', '0728569426', '11B', '4741', 'qazwsx123'),
('Chamaylee', 'chamaylee@gmail.com', '0758528524', '11B', '4785', 'qazwsx123'),
('rithosha', 'rithosha@gmail.com', '2178523698', '11D', '7850', 'qwerty123'),
('Sampath Perera', 'sampath@gmail.com', '0756985236', '', 'AAAA', 'admin@123');

DROP TABLE IF EXISTS borrowed_book_details;
CREATE TABLE borrowed_book_details (
  borrow_id INT AUTO_INCREMENT NOT NULL,
  book_id INT(11) NOT NULL,
  user_id VARCHAR(10) NOT NULL,
  borrowed_date DATE NOT NULL,
  return_date DATE NOT NULL,
  status VARCHAR(20) NOT NULL,
  KEY (borrow_id,user_id),
  CONSTRAINT user_id_fk FOREIGN KEY(user_id) REFERENCES members(user_id),
  CONSTRAINT book_id_fk FOREIGN KEY(book_id) REFERENCES books(acc_no),
  CONSTRAINT book_user_unique UNIQUE(book_id, user_id)
);

INSERT INTO borrowed_book_details (borrow_id, book_id, user_id, borrowed_date, return_date, status) VALUES
(1, 1, '4526', '2024-12-18', '2024-12-25', 'Pending'),
(2, 3, '4526', '2024-12-18', '2024-12-25', 'Pending'),
(3, 4, '4526', '2024-12-18', '2024-12-25', 'Pending'),
(4, 5, '4526', '2024-12-18', '2024-12-25', 'Pending'),
(5, 3, '4785', '2024-12-24', '2024-12-31', 'Pending'),
(6, 6, '4526', '2024-12-19', '2024-12-26', 'Pending'),
(7, 2, '7850', '2025-02-23', '2025-03-02', 'Returned'),
(8, 3, '7850', '2025-02-23', '2025-03-02', 'Returned'),
(9, 5, '7850', '2025-02-23', '2025-03-02', 'Returned');

DROP TABLE IF EXISTS lost_books_details;
CREATE TABLE IF NOT EXISTS lost_book_details (
  lost_id INT AUTO_INCREMENT NOT NULL,
  book_id INT(11) NOT NULL,
  user_id VARCHAR(10) NOT NULL,
  lost_date DATE NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  KEY (lost_id,book_id,user_id),
  CONSTRAINT user_id_lost_fk FOREIGN KEY(user_id) REFERENCES members(user_id),
  CONSTRAINT book_id_lost_fk FOREIGN KEY(book_id) REFERENCES books(acc_no),
  CONSTRAINT lost_book_user_unique UNIQUE(lost_id,book_id)
);

INSERT INTO lost_book_details (lost_id, book_id, user_id, lost_date, status) VALUES
(1, 3, '4526', '2024-12-25', 'Paid For Book'),
(2, 5, '4526', '2024-12-26', 'Replaced'),
(3, 6, '4526', '2025-02-11', 'Replaced'),
(4, 3, '4526', '2025-02-20', 'Pending'),
(5, 4, '4526', '2025-02-24', 'Pending'),
(6, 2, '7850', '2025-02-23', 'Replaced'),
(7, 7, '7850', '2025-02-23', 'Paid For Book'),
(8, 7, '7850', '2025-02-23', 'Pending');

DROP VIEW IF EXISTS lost_books_view;
CREATE VIEW lost_books_view AS
SELECT 
    l.lost_id,
    l.lost_date,
    l.book_id,
    b.title,
    b.price,
    l.user_id,
    l.status
FROM 
    lost_book_details l
JOIN 
    books b ON l.book_id = b.acc_no;


DROP TABLE IF EXISTS payment_details;
CREATE TABLE IF NOT EXISTS payment_details (
  payment_id INT AUTO_INCREMENT NOT NULL,
  user_id VARCHAR(10) NOT NULL,
  payment_type VARCHAR(20) NOT NULL,
  payment_slip VARCHAR(255) NOT NULL,
  price DECIMAL NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  KEY (payment_id,user_id),
  PRIMARY KEY(payment_id),
  CONSTRAINT user_id_payment_fk FOREIGN KEY(user_id) REFERENCES members(user_id)
);
