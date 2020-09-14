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