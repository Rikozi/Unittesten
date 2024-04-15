<?php
require __DIR__ . '/vendor/autoload.php';

use Controllers\AccountManager;

// Check if the register button was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register-btn'])) {
    session_start();
    $errors = [];

    $account = new AccountManager();
    $account->username = $_POST['username'];
    $account->setPassword($_POST['password']);

    // Display user info (This can be commented out in production)
    $account->displayUserInfo();

    // Validate user details
    $errors = $account->validateAccountDetails();

    if (empty($errors)) {
        // Attempt to register the user
        $errors = $account->createAccount();
    }

    if (!empty($errors)) {
        $alertMessage = implode("\\n", $errors);
        echo "<script>alert('$alertMessage');</script>";
        echo "<script>window.location = 'register_form.php'</script>";
    } else {
        echo "<script>alert('User registered successfully');</script>";
        echo "<script>window.location = 'login_form.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <h3>PHP - PDO User Management</h3>
    <hr/>

    <form action="" method="POST">
        <h4>Sign Up Here...</h4>
        <hr>
        
        <div>
            <label>Username</label>
            <input type="text" name="username" />
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" />
        </div>
        <br />
        <div>
            <button type="submit" name="register-btn">Register</button>
        </div>
        <a href="index.php">Home</a>
    </form>
</body>
</html>
