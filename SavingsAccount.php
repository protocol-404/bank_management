<?php
require_once 'Account.php';

class SavingsAccount extends Account {
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    // polymorphism
    public function createAccount($accountName, $accountEmail, $balance): bool
    {
        if (parent::createAccount($accountName, $accountEmail, $balance)) {
            try {
                $sql = "INSERT INTO SavingsAccounts (accountId) VALUES (:accountId)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':accountId', $this->accountID, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        return false;
    }
    public function getAccount(int $id) : bool{
        return parent::getAccount($id);
    }

    public function deleteAccount() : bool {
        try{
            $sql = "DELETE FROM SavingsAccounts WHERE accountId =:accountID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':accountID', $this->accountID, PDO::PARAM_INT);
            $stmt->execute();
            parent::deleteAccount();
            return true;
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}