<!DOCTYPE html>
<html lang="en">
<?php
include_once "./includes/header.php";
?>

<body>

    <!--  sidebar -->
    <div class="con p-0 m-0 d-flex">
        <div class="sidebar p-3">
            <div class="user-con d-flex p-2 align-items-center">
                <div class="user-img">
                    <img src="./user.jpg" alt="">
                </div>
                <div class="user-details d-flex flex-column ms-3">
                    <div class="name text fw-bold ">PATIENT</div>
                    <div class="identification text">STEPH CURRY</div>
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
                <a href="./logout.php" class="d-block text-decoration-none links p-2 rounded-2"> <i
                        class="ph ph-arrow-line-right fw-bold me-2"></i>Logout</a>
            </div>
        </div>




        <!--  account setting container -->

        <div class="main p-3">
            <h4 class="mt-5" >Account Settings</h4>
            <div class="account-container rounded-2">
                <div class="gradient-header"></div>
                <div class="user-details-edit-con d-flex justify-content-between">
                    <div class="user-cont d-flex">
                        <div class="user-image-edit ms-4"></div>
                        <div class="user-name d-flex flex-column justify-content-center ms-3">
                            <div class="name text fw-bold ">PATIENT</div>
                            <div class="identification text">STEPH CURRY</div>
                        </div>
                    </div>

                    <button type="submit" class="bg-purple text-white me-3 border-0 rounded-1 p-2" style="width: 70px;" >Edit</button>
                </div>
                
                <div class="account-cont d-flex ">
                    <!-- left section -->
                    <div class="left-section w-50">
                        <div class="account-details">
                            <div class="username-con d-flex flex-column">
                                <label for="Name">Username</label>
                                <input type="text" class="mt-1" >
                            </div>
                            
                            <div class="gender-con d-flex flex-column mt-2">
                                <label for="Gender">Gender</label>
                                <input type="text" class="mt-1">
                            </div>

                            <div class="age-con d-flex flex-column mt-2">
                                <label for="Age">Age</label>
                                <input type="text" class="mt-1">
                            </div>
                        </div>
                    </div>

                    <!-- right section -->
                    <div class="right-section w-50">
                        <div class="account-details">
                            <div class="password-con d-flex flex-column">
                                <label for="password">Password</label>
                                <input type="password" class="mt-1">
                            </div>
                            
                            <div class="confpass-con d-flex flex-column mt-2">
                                <label for="confim password">Confirm Password</label>
                                <input type="password" class="mt-1">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- save btn -->
                <div class="save-btn-con d-flex justify-content-end">
                        <input type="submit" value="Save" class="bg-purple text-white p-2 rounded-1 me-3" style="width: 100px;" >
                </div>
            </div>
        </div>


        <?php
        include_once "./includes/footer.php";
        ?>
</body>