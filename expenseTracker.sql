CREATE TABLE users
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    userId INT(6) PRIMARY KEY,
    firstName VARCHAR(40) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(15) NOT NULL,
    phoneNum INT(10) NOT NULL DEFAULT 123457890,
    salary DECIMAL(10, 2) NOT NULL DEFAULT 20000,
    date_joined DATETIME(6) DEFAULT CURDATE(),
    is_active TINYINT(1) DEFAULT 0,
    is_staff TINYINT(1) DEFAULT 0,
    is_superuser TINYINT(1) DEFAULT 0,
    last_login DATETIME(6) DEFAULT NULL
);

CREATE TABLE bills
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    billId INT(4) PRIMARY KEY,
    billName VARCHAR(50) NOT NULL,
    BillDate DATE NOT NULL,
    billPrice DECIMAL(10, 2) NOT NULL,
    isLate BIT NOT NULL,
    userId INT(6) NOT NULL DEFAULT 1,
    storeId INT(4) NOT NULL DEFAULT 1,
    isPaid TINYINT(1) NOT NULL,
    FOREIGN KEY (userId) REFERENCES budget(userId),
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId)
);

CREATE TABLE subscriptions
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    subId INT(4) NOT NULL PRIMARY KEY,
    dueDate DATE NOT NULL DEFAULT CURDATE(),
    amountDue DECIMAL(6, 2) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    subName VARCHAR(50) DEFAULT "Subscription",
    userId INT(6) NOT NULL DEFAULT 1,
    FOREIGN KEY (userId) REFERENCES budget(userId),
    isLate TINYINT(1) NOT NULL,
    isPaid TINYINT(1) NOT NULL
);

CREATE TABLE storeUnion
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    storeId INT(4) NOT NULL PRIMARY KEY,
    storeName VARCHAR(50)NOT NULL,
    address VARCHAR(60),
    city VARCHAR(70),
    state VARCHAR(50),
    zip INT(5),
    phoneNum INT(10) DEFAULT 1234567890,
    email VARCHAR(50) DEFAULT "store@gmil.com",
    website VARCHAR(100) NOT NULL DEFAULT "www.store.com",
    isCreditUnion TINYINT(1) NOT NULL DEFAULT FALSE,
    isCompleted TINYINT(1) NOT NULL DEFAULT TRUE
);

CREATE TABLE loan
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    loanId INT(4) NOT NULL PRIMARY KEY,
    loanName VARCHAR(50) NOT NULL,
    dueDate DATE NOT NULL,
    monthlyAmountDue DECIMAL(6, 2) NOT NULL,
    deposit DECIMAL(10, 2) NOT NULL,
    totalAmountDue DECIMAL(10, 2) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    userId INT(6) NOT NULL DEFAULT 1,
    FOREIGN KEY (userId) REFERENCES budget(userId),
    amountRemaining DECIMAL(10,2) NOT NULL,
    isLate TINYINT(1) NOT NULL,
    isPaid TINYINT(1) NOT NULL
);

CREATE TABLE misc
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    miscId INT(4) NOT NULL PRIMARY KEY,
    price DECIMAL(5,2) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    date DATE NOT NULL DEFAULT CURDATE(),
    userId INT(6) NOT NULL DEFAULT 1,
    FOREIGN KEY (userId) REFERENCES budget(userId),
    memo VARCHAR(100),
    msicName VARCHAR(100) NOT NULL
);

CREATE TABLE budget
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    userId INT(5) NOT NULL PRIMARY KEY,
    totalBills DECIMAL(10,2) NOT NULL,
    moneyLeft DECIMAL(10, 2) NOT NULL,
    savingsMoney DECIMAL(10, 2) NOT NULL DEFAULT 500.00,
    userId INT(6) NOT NULL,
    FOREIGN KEY (userId) REFERENCES users(userId)
);

CREATE TABLE auth_group
(
    id INT(11) NOT NULL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
)

CREATE TABLE django_content_type
(
    id INT(11) NOT NULL PRIMARY KEY,
    app_label VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL
)