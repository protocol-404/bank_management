<?php

abstract class Account {
    protected int $accountID;
    protected string $accountName;
    protected string $accountEmail;
    protected float $balance;
    protected  PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAccountID() : int{
        return $this->accountID;
    }

    public function getBalance() :float
    {
        return $this->balance;
    }

    public function setAccountHolder(string $name) : void
    {
        $this->accountName = $name;
    }
    public function setAccountEmail(string $email) : void
    {
        $this->accountEmail = $email;
    }

    public function setBalance(float $balance) : void {
        $this->balance = $balance;
    }
    public function getAccountDetails() : string {
        return "ID: " . $this->accountID . ", Name: " . $this->accountName . ", Email: " . $this->accountEmail . ", Balance: " . $this->balance;
    }
    public function createAccount($accountName, $accountEmail, $balance): bool
    {
        try {
            $sql = "INSERT INTO Accounts (accountNAME, accountEMAIL, balance) VALUES (:accountName, :accountEmail, :balance)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':accountName', $accountName, PDO::PARAM_STR);
            $stmt->bindParam(':accountEmail', $accountEmail, PDO::PARAM_STR);
            $stmt->bindParam(':balance', $balance, PDO::PARAM_STR);
            $stmt->execute();
            $this->accountID = $this->pdo->lastInsertId();
            $this->accountName = $accountName;
            $this->accountEmail = $accountEmail;
            $this->balance = $balance;

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAccount(int $id) : bool
    {
        try {
            $sql = "SELECT * FROM Accounts WHERE accountID = :accountID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':accountID', $id, PDO::PARAM_INT);
            $stmt->execute();

            $account = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($account) {
                $this->accountID = $account['accountID'];
                $this->accountName = $account['accountNAME'];
                $this->accountEmail = $account['accountEMAIL'];
                $this->balance = $account['balance'];

                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateAccount(float $balance): bool
    {
        try {
            $sql = "UPDATE Accounts SET  balance=:balance WHERE accountID =:accountID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':balance', $balance, PDO::PARAM_STR);
            $stmt->bindParam(':accountID', $this->accountID, PDO::PARAM_INT);
            $stmt->execute();
            $this->balance= $balance;
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function deleteAccount() : bool{
        try {
            $sql = "DELETE FROM Accounts WHERE accountID =:accountID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':accountID', $this->accountID, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
