CREATE TABLE users (
    -- Add AUTO_INCREMENT after PRIMARY KEY
    userId INT(6) PRIMARY KEY,
    firstName VARCHAR(40) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(15) NOT NULL,
    isAdmin BIT NOT NULL,
    address VARCHAR(70) NOT NULL,
    city VARCHAR(70) NOT NULL,
    state VARCHAR(30) NOT NULL,
    zip INT(5) NOT NULL
);

CREATE TABLE bills (
    -- Add AUTO_INCREMENT after PRIMARY KEY
    billId INT(4) PRIMARY KEY,
    billName VARCHAR(50) NOT NULL,
    BillDate DATE NOT NULL DEFAULT GETUTCDATE(),
    billPrice DECIMAL(5) NOT NULL,
    isLate BIT NOT NULL,
    userId INT(6),
    FOREIGN KEY (userId) REFERENCES users(userId)
);

CREATE TABLE subscriptions (
    -- Add AUTO_INCREMENT after PRIMARY KEY
    subId INT(4) NOT NULL PRIMARY KEY,
    dueDate DATE NOT NULL DEFAULT GETUTCDATE(),
    amountDue DECIMAL(6) NOT NULL,
    userId INT(6) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (userId) REFERENCES users(userId),
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId),
    subName VARCHAR(50) DEFAULT "Subscription",
);

CREATE TABLE storeUnion (
    -- Add AUTO_INCREMENT after PRIMARY KEY
    storeId INT(4) NOT NULL PRIMARY KEY,
    storeName VARCHAR(50)NOT NULL,
    address VARCHAR(60) NOT NULL,
    city VARCHAR(70) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip INT(5) NOT NULL
)

CREATE TABLE loan (
    -- Add AUTO_INCREMENT after PRIMARY KEY
    loanId INT(4) NOT NULL PRIMARY KEY,
    loanName VARCHAR(50) NOT NULL,
    dueDate DATE NOT NULL DEFAULT GETUTCDATE(),
    monthlyAmountDue DECIMAL(6) NOT NULL,
    deposit DECIMAL(6) NOT NULL,
    totalAmountDue DECIMAL(6) NOT NULL,
    userId INT(6) NOT NULL,
    storeId INT(4) NOT NULL,
    FOREIGN KEY (userId) REFERENCES users(userId),
    FOREIGN KEY (storeId) REFERENCES storeunion(storeId)
);