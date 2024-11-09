<?php
require_once "./controllers/user_controllers.php";

session_start();

// Initialize error message
$error = "";

if (isset($_POST['login'])) {
    $username = htmlentities(trim($_POST['username']));
    $password = htmlentities(trim($_POST['password']));

    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Username and Password are required.";
    } else {
        $user = new User();
        
        // Check if the user exists
        $existingUser = $user->getUserByUsername($username);
        if ($existingUser) {
            // Verify the password
            if (password_verify($password, $existingUser['password'])) {
                // Password is correct, log the user in
                $_SESSION['user_id'] = $existingUser['user_id'];
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "./includes/header.php"; ?>
<body>
    <div class="container-fluid background">
        <div class="container-signup rounded-3 d-flex flex-column">
            <h3>Sign in to Your Account</h3>
            <div class="input-container-login">
                <form action="" method="POST">
                    <div class="username">
                        <label for="Username">Username</label>
                        <input name="username" type="text" class="p-2 rounded-1 w-100" required>
                    </div>

                    <div class="password">
                        <label for="Password">Password</label>
                        <input name="password" type="password" class="p-2 rounded-1 w-100" required>
                    </div>

                    <!-- Display error message if any -->
                    <?php if (!empty($error)): ?>
                        <p style='color: red; font-size: 12px; margin-bottom: 8px;'><?php echo $error; ?></p>
                    <?php endif; ?>

                    <input name="login" class="mt-3 p-2 rounded-2 signup w-100" type="submit" value="Sign in">
                </form>
            </div>
            <p class="mt-2">Don't have an account yet? <a class="text-decoration-none" href="./signup.php">Sign up</a> here.</p>
        </div>
    </div>

    <?php include_once "./includes/footer.php"; ?>
</body>
</html>
