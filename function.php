<?php
function getPostData($key, $default = null) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
}

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create'){
    $accountType = getPostData('accountType');
    $accountName = getPostData('accountName');
    $accountEmail = getPostData('accountEmail');
    $balance = getPostData('balance');
    try{
        switch ($accountType) {
            case 'business':
                $account = new BusinessAccount($pdo);
                if($account->createAccount($accountName, $accountEmail, $balance)){
                    $message = "Business Account created successfully";
                }else{
                    $error = "Business account creation failed.";
                }
                break;
            case 'savings':
                $account = new SavingsAccount($pdo);
                if($account->createAccount($accountName, $accountEmail, $balance)){
                    $message = "Savings Account created successfully";
                }else{
                    $error = "Savings account creation failed.";
                }
                break;
            case 'current':
                $account = new CurrentAccount($pdo);
                if($account->createAccount($accountName, $accountEmail, $balance)){
                    $message = "Current Account created successfully";
                }else{
                    $error = "Current account creation failed.";
                }
                break;
            default:
                $error = "Invalid account type.";
                break;
        }
    }catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update'){
    $accountID = getPostData('accountID');
    $balance = getPostData('balance');
    $accountType = getPostData('accountType');
    try{
        switch ($accountType) {
            case 'business':
                $account = new BusinessAccount($pdo);
                if($account->getAccount($accountID)){
                    if($account->updateAccount($balance)){
                        $message = "Business Account updated successfully";
                    }else{
                        $error = "Business Account update failed";
                    }
                }else{
                    $error = "Business account not found";
                }
                break;
            case 'savings':
                $account = new SavingsAccount($pdo);
                if($account->getAccount($accountID)){
                    if($account->updateAccount($balance)){
                        $message = "Savings Account updated successfully";
                    }else{
                        $error = "Savings account update failed";
                    }
                }else{
                    $error = "Saving account not found";
                }
                break;
            case 'current':
                $account = new CurrentAccount($pdo);
                if($account->getAccount($accountID)){
                    if($account->updateAccount($balance)){
                        $message = "Current Account updated successfully";
                    }else{
                        $error = "Current account update failed";
                    }
                }else{
                    $error = "Current account not found";
                }
                break;
            default:
                $error ="invalid account type";
                break;
        }
    }catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete'){
    $accountID = getPostData('accountID');
    $accountType = getPostData('accountType');
    try{
        switch ($accountType) {
            case 'business':
                $account = new BusinessAccount($pdo);
                if($account->getAccount($accountID)){
                    $account->deleteAccount();
                    $message = "Business Account deleted successfully";
                }else{
                    $error = "Business account not found";
                }
                break;
            case 'savings':
                $account = new SavingsAccount($pdo);
                if($account->getAccount($accountID)){
                    $account->deleteAccount();
                    $message = "Savings Account deleted successfully";
                }else{
                    $error = "Saving account not found";
                }
                break;
            case 'current':
                $account = new CurrentAccount($pdo);
                if($account->getAccount($accountID)){
                    $account->deleteAccount();
                    $message = "Current Account deleted successfully";
                }else{
                    $error = "Current account not found";
                }
                break;
            default:
                $error = "Invalid Account type";
                break;
        }
    }catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

$allAccounts = [];

try {
    $sql = "SELECT a.accountID, a.accountNAME, a.accountEMAIL, a.balance,
                    CASE
                       WHEN ba.accountId IS NOT NULL THEN 'business'
                       WHEN sa.accountId IS NOT NULL THEN 'savings'
                       WHEN ca.accountId IS NOT NULL THEN 'current'
                       ELSE 'unknown'
                     END AS accountType
                  FROM Accounts a
                  LEFT JOIN BusinessAccounts ba ON a.accountID = ba.accountId
                  LEFT JOIN SavingsAccounts sa ON a.accountID = sa.accountId
                 LEFT JOIN CurrentAccounts ca ON a.accountID = ca.accountId";

    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $allAccounts[] = $row;
    }
} catch (PDOException $e) {
    $error = "Error: Could not fetch accounts. " . $e->getMessage();
}
?>
