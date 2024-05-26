-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('admin', 'customer', 'candidate') NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE
);


-- Enquiries table
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message TEXT
);

-- Candidates table
CREATE TABLE IF NOT EXISTS candidates (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) UNSIGNED,
    firstName VARCHAR(50) NOT NULL,
    middleName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL ,
    joinImmediately ENUM('yes', 'no') NOT NULL,
    fileName VARCHAR(255) NOT NULL,
    jobPosition VARCHAR(100) NOT NULL,
    resumeStatus ENUM('submitted', 'in_progress', 'accepted', 'rejected') NOT NULL DEFAULT 'submitted',
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (email) REFERENCES users(username)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) UNSIGNED,
    organizationName VARCHAR(255) NOT NULL,
    product VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    instructions TEXT,
    pdfFile VARCHAR(255),
    additionalFile VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    termsAccepted BOOLEAN NOT NULL,
    advancePay DECIMAL(10, 2),
    paymentStatus ENUM('Done', 'Not Done') NOT NULL,
    status ENUM('Pending', 'Accepted', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (email) REFERENCES users(username)
);



-- Employee table
CREATE TABLE IF NOT EXISTS employee (
    emp_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    address TEXT,
    salary DECIMAL(10, 2) NOT NULL,
    login_password VARCHAR(255) NOT NULL,
    jobPosition VARCHAR(100) NOT NULL,
   
);
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    message_content TEXT NOT NULL,
    sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (recipient_id) REFERENCES employee(emp_id)
);

CREATE TABLE IF NOT EXISTS empmessages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    firstname VARCHAR(255) UNSIGNED,
    lastname VARCHAR(255) UNSIGNED,
    message_con TEXT NOT NULL,
    Sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES employee(emp_id),
    FOREIGN KEY (firstname, lastname) REFERENCES employee(first_name, last_name)
);


CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) UNSIGNED,
    orderId INT,
    paymentMethod ENUM('Credit Card', 'Debit Card', 'Net Banking') NOT NULL,
    payStatus ENUM('Done', 'Not Done') NOT NULL DEFAULT 'Not Done',
    amount DECIMAL(10, 2) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (orderId) REFERENCES orders(id),
    FOREIGN KEY (payStatus) REFERENCES orders(paymentStatus)
);
CREATE TABLE IF NOT EXISTS delivery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderId INT UNIQUE,
    USER_ID INT(11) UNSIGNED,
    deliveryStatus ENUM('Pending', 'Started', 'In Process', 'Dispatched', 'Done', 'Delivered') NOT NULL DEFAULT 'Pending',
    deliveryDate DATE,
    deliveryTime TIME,
    deliveryAddress TEXT,
    deliveryAgent VARCHAR(255),
    deliveryNotes TEXT,
    FOREIGN KEY (orderId) REFERENCES orders(id),
    FOREIGN KEY (USER_ID) REFERENCES orders(userId)
);

CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderId INT ,
    userId INT UNSIGNED,
    message TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (orderId) REFERENCES orders(id),
    FOREIGN KEY (userId) REFERENCES users(id)
) 
CREATE TABLE IF NOT EXISTS replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inquiryId INT,
    userId INT(11) UNSIGNED,
    message TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (inquiryId) REFERENCES inquiries(id),
    FOREIGN KEY (userId) REFERENCES users(id)
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    empid INT (11) UNSIGNED,
    amount DECIMAL(10, 2) NOT NULL,
    bonus DECIMAL(10, 2) DEFAULT 0.00,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empid) REFERENCES employee(emp_id)
);
ALTER TABLE payments 
    ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE IF NOT EXISTS attendance (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    empid INT(11) UNSIGNED,
    attendance_date DATE,
    attendance_status ENUM('present', 'absent') NOT NULL DEFAULT 'absent', -- New column for attendance status
    FOREIGN KEY (empid) REFERENCES employee(emp_id)
);
