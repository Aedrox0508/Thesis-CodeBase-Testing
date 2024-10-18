<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        :root {
            --lg-font: "New Amsterdam", sans-serif;
        }

        .bg-img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        .logosec {
            max-width: 100%;
            /* Ensure the logo doesn't overflow */
        }

        .login-btn {
            background-color: #340b46;
            /* Dark blue color */
            color: #fff;
            border: none;
            width: 260px;
            margin-top: 20px;

        }

        .container-fluid {
            padding-left: 0;
        }

        .login h1 {
            font-family: monospace;

        }

        .title {
            margin-left: 100px;
            font-family: var(--lg-font);
        }

        .move-nav {
            color: rgb(162, 61, 162);
            padding-left: 2px;
        }

        .wave-nav {
            color: rgb(67, 19, 91);

        }

        .move-nav,
        .wave-nav {
            font-family: var(--lg-font);
        }

        .move,
        .wave {
            font-weight: 700;
            margin-right: 47px;
            font-size: 2.3rem;
            /* Added unit for font size */
        }

        .nav-side {
            border: 0.5px solid rgba(0, 0, 0, 0.411);
        }

        .nav-item {
            margin-left: 30px;
            padding: 10px;
            font-size: 1.2rem;

        }

        .nav-link {
            color: #0b0b0bd0;
        }

        .dash-box {
            color: white;
            background-color: #832ca8;
            padding: 20px;
            margin: 10px;
            border-radius: 30px;
            width: 200px;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 nav-side">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">

                    <div class="col-12 text-start nav-title">
                        <h1 class="move-nav">Move <span class="wave-nav">Wave</span></h1>
                    </div>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-qrcode"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-user-gear"></i></i> <span class="ms-1 d-none d-sm-inline">Moderator</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-user"></i> <span class="ms-1 d-none d-sm-inline">Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-sliders"></i> <span class="ms-1 d-none d-sm-inline">Presets</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-gears"></i> <span class="ms-1 d-none d-sm-inline">Usage</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="pb-4">
                        <i class="fa-solid fa-right-from-bracket"></i> <span class="ms-1 d-none d-sm-inline">Logout</span>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <div class="container">
                    <div class="row">
                        <div class="col dash-box align-content-start">
                            <h3> 20 </h3>
                            <h6> Presets Combination </h6>
                        </div>
                        <div class="col dash-box">
                            <h3> 5 </h3>
                            <h6> Moderator </h6>
                        </div>
                        <div class="col dash-box">
                            <h3> 10 </h3>
                            <h6> Patients </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>