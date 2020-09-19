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
    -- Not in 3rd normalization, implement later
    
    -- Add AUTO_INCREMENT after PRIMARY KEY
    subId INT(4) NOT NULL PRIMARY KEY,
    companyName VARCHAR(50) NOT NULL,
    dueDate DATE NOT NULL DEFAULT GETUTCDATE(),
    amountDue DECIMAL(6) NOT NULL,
    userId INT(6),
    FOREIGN KEY (userId) REFERENCES users(userId)
);