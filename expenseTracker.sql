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
    BillDate DATE NOT NULL DEFAULT CURDATE(),
    billPrice DECIMAL(5, 2) NOT NULL,
    isLate BIT NOT NULL,
    userId INT(6) NOT NULL DEFAULT 1,
    storeId INT(4) NOT NULL DEFAULT 1,
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
    FOREIGN KEY (userId) REFERENCES budget(userId)
);

CREATE TABLE storeUnion
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    storeId INT(4) NOT NULL PRIMARY KEY,
    storeName VARCHAR(50)NOT NULL,
    address VARCHAR(60) NOT NULL,
    city VARCHAR(70) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip INT(5) NOT NULL,
    phoneNum INT(10) NOT NULL DEFAULT 1234567890,
    email VARCHAR(30) NOT NULL DEFAULT "store@gmil.com",
    website VARCHAR(50) NOT NULL DEFAULT "www.store.com"
);

CREATE TABLE loan
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    loanId INT(4) NOT NULL PRIMARY KEY,
    loanName VARCHAR(50) NOT NULL,
    dueDate DATE NOT NULL DEFAULT CURDATE(),
    monthlyAmountDue DECIMAL(6, 2) NOT NULL,
    deposit DECIMAL(10, 2) NOT NULL,
    totalAmountDue DECIMAL(6, 2) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    userId INT(6) NOT NULL DEFAULT 1,
    FOREIGN KEY (userId) REFERENCES budget(userId)
);

CREATE TABLE misc
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    miscId INT(4) NOT NULL PRIMARY KEY,
    price DECIMAL(5,2) NOT NULL,
    date DATE NOT NULL DEFAULT CURDATE(),
    storeId INT(4) NOT NULL,
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    userId INT(6) NOT NULL DEFAULT 1,
    FOREIGN KEY (userId) REFERENCES budget(userId)
);

CREATE TABLE budget
(
    -- Add AUTO_INCREMENT after PRIMARY KEY
    userId INT(5) NOT NULL PRIMARY KEY,
    totalBills DECIMAL(10,2) NOT NULL,
    moneyLeft DECIMAL(10, 2) NOT NULL,
    userId INT(6) NOT NULL,
    FOREIGN KEY (userId) REFERENCES users(userId)
);