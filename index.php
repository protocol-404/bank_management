<?php
require_once 'config.php';
require_once 'BusinessAccount.php';
require_once 'SavingsAccount.php';
require_once 'CurrentAccount.php';
require_once 'function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Account Management</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #1a202c;
            color: #edf2f7;
        }
        .bg-glass{
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }
        .bg-glass-dark{
            background: rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }
        .error { color: #e53e3e; }
        .success {color: #48bb78;}
    </style>
</head>
<body class="p-8">
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-200">Bank Account Management</h1>
    <?php if ($message): ?>
        <p class="success text-center mb-4"><?= $message; ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p class="error text-center mb-4"><?= $error; ?></p>
    <?php endif; ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-glass rounded-lg p-6 shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-200">Add Account</h2>
            <form method="post">
                <input type="hidden" name="action" value="create">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountType">Account Type:</label>
                    <select name="accountType" id="accountType" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                        <option value="business">Business</option>
                        <option value="savings">Savings</option>
                        <option value="current">Current</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountName">Account Name:</label>
                    <input type="text" name="accountName" id="accountName" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountEmail">Account Email:</label>
                    <input type="email" name="accountEmail" id="accountEmail" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="balance">Initial Balance:</label>
                    <input type="number" name="balance" id="balance" step="0.01" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>
                <div id="extraFields">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Account</button>
            </form>
        </div>

        <div class="bg-glass rounded-lg p-6 shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-200">Update Account</h2>
            <form method="post">
                <input type="hidden" name="action" value="update">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountType">Account Type:</label>
                    <select name="accountType" id="accountTypeUpdate" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                        <option value="business">Business</option>
                        <option value="savings">Savings</option>
                        <option value="current">Current</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountID">Account ID:</label>
                    <input type="number" name="accountID" id="accountID" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="balance">New Balance:</label>
                    <input type="number" name="balance" id="balance" step="0.01" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Account</button>
            </form>
        </div>

        <div class="bg-glass rounded-lg p-6 shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-200">Delete Account</h2>
            <form method="post">
                <input type="hidden" name="action" value="delete">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountType">Account Type:</label>
                    <select name="accountType" id="accountTypeDelete" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                        <option value="business">Business</option>
                        <option value="savings">Savings</option>
                        <option value="current">Current</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="accountID">Account ID:</label>
                    <input type="number" name="accountID" id="accountID" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-3 text-gray-300 leading-tight focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete Account</button>
            </form>
        </div>
    </div>

    <div class="bg-glass-dark rounded-lg overflow-x-auto mt-8 shadow-md">
        <h2 class="text-2xl font-semibold mb-4 p-4 text-gray-200">All Accounts</h2>
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-700">
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-sm font-semibold text-gray-100 uppercase tracking-wider">ID</th>
                <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-sm font-semibold text-gray-100 uppercase tracking-wider">Name</th>
                <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-sm font-semibold text-gray-100 uppercase tracking-wider">Email</th>
                <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-sm font-semibold text-gray-100 uppercase tracking-wider">Balance</th>
                <th class="px-5 py-3 border-b-2 border-gray-600 text-left text-sm font-semibold text-gray-100 uppercase tracking-wider">Account Type</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allAccounts as $account): ?>
                <tr class="border-b border-gray-600">
                    <td class="px-5 py-5 text-sm text-gray-300"><?= $account['accountID']; ?></td>
                    <td class="px-5 py-5 text-sm text-gray-300"><?= $account['accountNAME']; ?></td>
                    <td class="px-5 py-5 text-sm text-gray-300"><?= $account['accountEMAIL']; ?></td>
                    <td class="px-5 py-5 text-sm text-gray-300"><?= $account['balance']; ?></td>
                    <td class="px-5 py-5 text-sm text-gray-300"><?= $account['accountType']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {

});
</script>
</body>
</html>
