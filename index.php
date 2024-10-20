<?php
require_once "./classes/userController.php";
require_once "./Tools/functions.php";
session_start();

$signupError = false; // Initialize flag for signup error
$errors = []; // Initialize an empty errors array

// Function to handle signup validation
function validate_signup($user, $confirmPassword) {
    $errors = [];

    // Validate username
    if (!validate_field($user->username)) {
        $errors['username'] = "Please input a valid username";
    } elseif (username_exists($user->username)) {
        $errors['username'] = "Username already exists";
    }

    // Validate password
    $passwordValidationResult = validate_password($user->password);
    if (!validate_field($user->password) || $passwordValidationResult !== true) {
        $errors['password'] = is_string($passwordValidationResult) ? $passwordValidationResult : "Please input a valid password";
    }

    // Validate confirm password
    if (!isset($errors['password']) && !validate_conPass($user->password, $confirmPassword)) {
        $errors['confirmPassword'] = "Passwords do not match";
    }

    return $errors; // Return the errors array
}

// Process signup form submission
if (isset($_POST['signup'])) {
    $user = new User();
    $user->username = htmlentities($_POST['username']);
    $user->password = htmlentities($_POST['password']);
    $confirmPassword = htmlentities($_POST['confirmPassword']);

    // Validate the form input
    $errors = validate_signup($user, $confirmPassword);

    // If no validation errors, proceed to create the account
    if (empty($errors)) {
        if ($user->addUser()) {
            echo "Account Created";
            if (isset($_POST['return'])) {
                header("Location: index.php");
                exit; // Stop further execution after redirect
            }
        } else {
            $errors['general'] = 'Unable to create an account';
        }
    } else {
        $signupError = true; // Set signup error flag to true if validation fails
        $_SESSION['errors'] = $errors; // Store errors in session for display
    }
}

// Process sign-in form submission
if (isset($_POST['signin'])) {
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $errors = []; // Initialize sign-in errors

    // Validate username and password input
    if (!validate_field($username)) {
        $errors['username'] = "Please enter a valid username.";
    }

    if (!validate_field($password)) {
        $errors['password'] = "Please enter a valid password.";
    }

    // If no errors, attempt to authenticate the user
    if (empty($errors)) {
        $user = new User();
        $userData = $user->getUserByUsername($username);

        if ($userData && password_verify($password, $userData['password'])) {
            // Set session variables and redirect to dashboard
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $userData['id'];
            header("Location: dashboard.php");
            exit; // Stop further execution after redirect
        } else {
            $errors['general'] = "Invalid username or password.";
        }
    }
}

// Clear session-stored errors if the page is refreshed without form submission
if (!isset($_POST['signup']) && isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoveWave</title>
     <!-- font awesome icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css stylesheet -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="container <?php if (isset($_SESSION['errors'])) echo 'right-panel-active'; ?>" id="container">

<div class="form-container sign-up-container">
            <form action="index.php" method="POST">
                <h1>Create Account</h1>
                <div class="infield">
                <input type="text" placeholder="Name" name="username" value="<?php echo htmlentities($_POST['username'] ?? ''); ?>" required />
                <label></label>
                    <?php if (!empty($errors['username'])): ?>
                        <span class='text-danger'><?php echo $errors['username']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" name="password" required />
                    <label></label>
                </div>
                <?php if (!empty($errors['password'])): ?>
                <span class='text-danger'><?php echo $errors['password']; ?></span>
                  <?php endif; ?>
                <div class="infield">
                    <input type="password" placeholder="Confirm Password" name="confirmPassword" required />
                    <label></label>
                </div>
                <?php if (!empty($errors['confirmPassword'])): ?>
                <span class='text-danger'><?php echo $errors['confirmPassword']; ?></span>
                 <?php endif; ?>
                <button type="submit" name="signup">Sign Up</button>
                <?php unset($_SESSION['errors']); ?>
            </form>
        </div>
    <div class="form-container sign-in-container">
        <form action="dashboard.php" method="POST">
            <h1>Sign in</h1>
            <span>or use your account</span>
            <div class="infield">
                <input type="text" placeholder="Username" name="username" required />
                <label></label>
            </div>
            <div class="infield">
                <input type="password" placeholder="Password" name="password" required />
                <label></label>
            </div>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container" id="overlayCon">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p class="text-white" >To keep connected with us please login with your personal info</p>
                <button>Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hi, there!</h1>
                <p class="text-white" >Enter your personal details and start journey with us</p>
                <button class="mt-5" >Sign Up</button>
            </div>
        </div>
        <button id="overlayBtn"></button>
    </div>
</div>


    
    <!-- js code -->
    <script>
        const container = document.getElementById('container');
        const overlayCon = document.getElementById('overlayCon');
        const overlayBtn = document.getElementById('overlayBtn');


        overlayBtn.addEventListener('click', ()=> {
            container.classList.toggle('right-panel-active');

            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame( ()=> {
                overlayBtn.classList.add('btnScaled');
            })
        });
        const signupError = <?php echo json_encode($signupError); ?>;
        if (signupError) {
            container.classList.add('right-panel-active');  // Keep the sign-up form visible if there were errors
        }
    </script>

</body>
</html>