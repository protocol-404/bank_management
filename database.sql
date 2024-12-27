CREATE DATABASE IF NOT EXISTS bank_db;

USE bank_db;

CREATE TABLE IF NOT EXISTS Accounts (
    accountID INT AUTO_INCREMENT PRIMARY KEY,
    accountNAME VARCHAR(255),
    accountEMAIL VARCHAR(255),
    balance FLOAT
);

CREATE TABLE IF NOT EXISTS BusinessAccounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  accountId INT,
  transactionFee FLOAT,
  FOREIGN KEY (accountId) REFERENCES Accounts(accountID)
);
CREATE TABLE IF NOT EXISTS SavingsAccounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  accountId INT,
    interestRate FLOAT,
  FOREIGN KEY (accountId) REFERENCES Accounts(accountID)
);
CREATE TABLE IF NOT EXISTS CurrentAccounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  accountId INT,
    overdraftLimit FLOAT,
  FOREIGN KEY (accountId) REFERENCES Accounts(accountID)
);