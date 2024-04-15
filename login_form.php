<?php
require __DIR__ . '/vendor/autoload.php';
use Controllers\Authentication;

// Check if the login button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login-btn'])) {
    session_start();
    $loginErrors = [];

    $auth = new Authentication();
    $auth->username = $_POST['username'];
    $auth->setPassword($_POST['password']);

    // Displaying user info for debugging (comment out in production)
    $auth->displayUserInfo();

    // Validate credentials
    $loginErrors = $auth->validateCredentials();

    // Proceed to log in if no errors
    if (empty($loginErrors)) {
        if ($auth->authenticateUser()) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Login failed');</script>";
        }
    }

    // Handle errors
    if (!empty($loginErrors)) {
        $errorMessage = implode("\\n", $loginErrors);
        echo "<script>alert('$errorMessage');</script>";
        echo "<script>window.location = 'login_form.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <h3>PHP - PDO Authentication System</h3>
    <hr/>

    <form action="" method="POST">    
        <h4>Log In...</h4>
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
            <button type="submit" name="login-btn">Login</button>
        </div>
        <a href="register_form.php">Register</a>
    </form>
</body>
</html>
