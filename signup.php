<?php
require_once "./controllers/user_controllers.php";

if (isset($_POST['signup'])) {
    $user = new User();
    $user->username = htmlentities(trim($_POST['username']));
    $user->password = htmlentities(trim($_POST['password']));
    $confirmPassword = htmlentities(trim($_POST['confirmPassword']));

    // Initialize error messages
    $usernameError = "";
    $passwordError = "";
    $confirmPasswordError = "";
    $generalError = "";

    // Check if username is provided
    if (empty($user->username)) {
        $usernameError = "Username is required.";
    }

    // Check if password is provided
    if (empty($user->password)) {
        $passwordError = "Password is required.";
    }

    // Check if passwords match
    if ($user->password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match.";
    }

    // Check if username already exists
    if ($user->getUserByUsername($user->username)) {
        $usernameError = "Username already exists.";
    }

    // If no errors, proceed to add user
    if (empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)) {
        if ($user->addUser()) {
            echo"<div class='alert alert-light alert-dismissible fade show alert-account d-flex align-items-center justify-content-center p-2' role='alert'>
            <p class='mt-2 me-4 d-flex justify-content-center align-items-center'>Account Created Successfully!</p>
  <button type='button' class='btn-close d-block' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
        }
        else{
            $generalError = "Failed to create account. Please try again.";
        }
    }

    // Display general error message if any
    if (!empty($generalError)) {
        echo "<p style='color: red;'>$generalError</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once "./includes/header.php"; ?>

<body>

</div>
    <div class="container-fluid background">
        <div class="container-signup rounded-3 d-flex flex-column">
            <h3>Create Account</h3>
            <div class="input-container">
                <form class="input-container" action="" method="POST">
                    <div class="username">
                        <label for="Username">Username</label>
                        <input name="username" type="text" class="p-2 rounded-1" required>
                        <?php if (!empty($usernameError)): ?>
                            <p style='color: red; font-size: 12px;'><?php echo $usernameError; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="password">
                        <label for="Password">Password</label>
                        <input name="password" type="password" class="p-2 rounded-1" required>
                        <?php if (!empty($passwordError)): ?>
                            <p style='color: red;  font-size: 12px;'><?php echo $passwordError; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="confirm-password">
                        <label for="Confirm Password">Confirm Password</label>
                        <input name="confirmPassword" type="password" class="p-2 rounded-1" required>
                        <?php if (!empty($confirmPasswordError)): ?>
                            <p style='color: red;  font-size: 12px;'><?php echo $confirmPasswordError; ?></p>
                        <?php endif; ?>
                    </div>

                    <input name="signup" class="mt-3 p-2 rounded-2 signup" type="submit" value="Create Account">
                </form>
            </div>
            <p class="mt-2">Already have an Account? <a class="text-decoration-none" href="./index.php">Sign in</a> here.</p>
        </div>
    </div>
    <?php include_once "./includes/footer.php"; ?>
</body>
</html>
