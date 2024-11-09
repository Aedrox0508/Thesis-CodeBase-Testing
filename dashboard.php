<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include_once "./includes/header.php";
?>

<body>
    <div class="con p-0 m-0 d-flex">
        <div class="sidebar p-3">
            <div class="user-con d-flex p-2 align-items-center">
                <div class="user-img">
                    <img src="./user.jpg" alt="">
                </div>
                <div class="user-details d-flex flex-column ms-3">
                    <div class="name text fw-bold ">PATIENT</div>
                    <div class="identification text"><?php echo htmlentities($_SESSION['username']); ?></div>
                </div>
            </div>

            <div class="menu d-flex flex-column">
                <p class="mt-2 text color-secondary fw-bold">MAIN</p>
                <a href="./dashboard.php" class="d-block text-decoration-none links p-2 active rounded-2"> <i
                        class="ph ph-house-simple fw-bold me-2"></i>Dashboard</a>
                <a href="./presets.php" class="d-block text-decoration-none links p-2 mt-2 rounded-2 mb-3"> <i
                        class="ph ph-faders-horizontal fw-bold me-2"></i>Presets</a>
                <div class="separator w-100"></div>
                <p class="mt-2 text color-secondary fw-bold">SETTINGS</p>
                <a href="./accountSettings.php" class="d-block text-decoration-none links p-2 rounded-2"> <i
                        class="ph ph-user fw-bold me-2"></i>Account</a>
                <a href="logout.php" class="d-block text-decoration-none links p-2 rounded-2"> <i
                        class="ph ph-arrow-line-right fw-bold me-2"></i>Logout</a>
            </div>
        </div>

        <!-- main container -->
        <div class="main p-3">
            <div class="menu-btn d-flex justify-content-center align-content-center rounded-3">
                <a href="" class="text-decoration-none  fw-bold text-dark p-2 fs-5"><i class="ph ph-list"></i></a>
            </div>

            <h4 class="mt-4 ms-2">Incoming Message</h4>
            <div class="message-box rounded-3"></div>
            <button class=" w-25 rounded-3 p-2 font-secondary border-0 mt-3 text-white bg-purple">Clear All</button>
        </div>
    </div>

   <?php
    include_once "./includes/footer.php";
   ?>
</body>
</html>
