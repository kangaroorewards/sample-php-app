<?php
// index.php
require_once __DIR__ . '/../app/api.php';

// Determine which action to perform from the query parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_customer'])) {
    // Collect form data
    $customerData = [
        'email'      => $_POST['email'],
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? ''
    ];
    
    // Call API to create customer
    $response = createCustomer($customerData);
}

switch ($action) {
    case 'account':
        $response = getAccount();
        break;
    case 'list_customers':
        $response = listCustomers();
        break;
    case 'create_customer':
        // $customerData = [
        //     'name'  => 'John Doe',
        //     'email' => 'john.doe@example.com',
        // ];
        // $response = createCustomer($customerData);
        break;
    case 'get_customer':
        // Pass an example customer ID, replace with a real ID as needed.
        $response = getCustomer('11ea97fb525c90b6b56542010a8001ad');
        break;
    case 'update_customer':
        $customerData = [
            'name'  => 'John Doe Updated',
            'email' => 'john.updated@example.com',
        ];
        $response = updateCustomer('11ea97fb525c90b6b56542010a8001ad', $customerData);
        break;
    case 'delete_customer':
        $response = deleteCustomer('11ea97fb525c90b6b56542010a8001ad');
        break;
    case 'list_transactions':
        $response = listTransactions();
        break;
    case 'create_transaction':
        $transactionData = [
            'amount' => 10,
            'intent' => 'reward',
            'customer' => [
                'id' => '11ea97fb525c90b6b56542010a8001ad'
            ]
            // ...other transaction details
        ];
        $response = createTransaction($transactionData);
        break;
    case 'cancel_transaction':
        $response = cancelTransaction(1);
        break;
    case 'list_rewards':
        $response = listRewards();
        break;
    case 'create_reward':
        $rewardData = [
            'type_id' => 15,
            'points' => 50,
            'never_expires_flag' => 1,
            'reward_languages' => [
                'language_id' => 1,
                'title' => 'Free Coffee',
            ]
        ];
        $response = createReward($rewardData);
        break;
    default:
        $action = 'home';
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kangaroo Rewards API Demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .nav a { margin-right: 10px; text-decoration: none; color: #007BFF; }
        .nav a:hover { text-decoration: underline; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ccc; overflow: auto; }
        form { max-width: 400px; margin-top: 20px; }
        input, button { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
    </style>
</head>
<body>
    <h1>Kangaroo Rewards API Demo</h1>
    <div class="nav">
        <a href="index.php?action=account">Account Info</a>
        <a href="index.php?action=list_customers">List Customers</a>
        <a href="index.php?action=create_customer">Create Customer</a>
        <a href="index.php?action=get_customer">Get Customer</a>
        <a href="index.php?action=update_customer">Update Customer</a>
        <a href="index.php?action=delete_customer">Delete Customer</a>
        <a href="index.php?action=list_transactions">List Transactions</a>
        <a href="index.php?action=create_transaction">Create Transaction</a>
        <a href="index.php?action=cancel_transaction">Cancel Transaction</a>
        <a href="index.php?action=list_rewards">List Rewards</a>
        <a href="index.php?action=create_reward">Create Reward</a>
        <!-- Add more navigation links for other endpoints -->
    </div>
    <hr>
    <?php if ($action === 'home'): ?>
        <p>Select an action from the menu above to test an API endpoint.</p>
    <?php elseif ($action === 'create_customer'): ?>
        <h2>Create Customer</h2>
        <form method="POST" action="index.php?action=create_customer">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>First Name:</label>
            <input type="text" name="first_name">

            <label>Last Name:</label>
            <input type="text" name="last_name">

            <button type="submit" name="create_customer">Create Customer</button>
        </form>

        <?php if (!empty($response)): ?>
            <h3>API Response:</h3>
            <pre><?= json_encode(json_decode($response, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?></pre>
        <?php endif; ?>
    <?php else: ?>
        <h2>Response from API (<?= htmlspecialchars($action) ?>)</h2>
        <!-- <pre><?php // echo htmlspecialchars($response) ?></pre> -->
        <pre><?= json_encode(json_decode($response, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?></pre>
    <?php endif; ?>
</body>
</html>
