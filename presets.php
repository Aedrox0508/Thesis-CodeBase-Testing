<?php
require_once "./classes/gestureController.php";

$gestureController = new Gesture();
$thumb_gestures = $gestureController->get_thumb_gestures(); // Retrieve thumb gestures
$index_gestures = $gestureController->get_index_gestures(); // Retrieve thumb gestures
$middle_gestures = $gestureController->get_middle_gestures(); // Retrieve thumb gestures
$ring_gestures = $gestureController->get_ring_gestures(); // Retrieve thumb gestures
$pinky_gestures = $gestureController->get_pinky_gestures(); // Retrieve thumb gestures

$gesture = new Gesture();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $gestureId = $_POST['gesture_id'];
    $customValue = $_POST['custom_value'];

    // Call the function to update the gesture value
    $message = $gesture->updateGestureValue($gestureId, $customValue);

    // Optional: Redirect to avoid form resubmission
    header("Location: presets.php?message=" . urlencode($message));
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  maximum-scale=1, user-scalable=no">
    <title>Presets </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/presets.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 nav-side">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100 menu-nav">
                    <div class="col-12 text-start nav-title">
                        <img src="./assets/img/icon.svg" alt="Icon" class="nav-icon">
                        <h1 class="move-nav">
                            Move <span class="wave-nav">Wave</span>
                        </h1>

                    </div>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link align-middle px-0 nav-c">
                                <i class="fa-solid fa-qrcode"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 nav-c">
                                <i class="fa-solid fa-user-gear"></i></i> <span class="ms-1 d-none d-sm-inline">Moderator</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 nav-c">
                                <i class="fa-solid fa-user"></i> <span class="ms-1 d-none d-sm-inline">Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 nav-c">
                                <i class="fa-solid fa-sliders"></i> <span class="ms-1 d-none d-sm-inline">Presets</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 nav-c">
                                <i class="fa-solid fa-gears"></i> <span class="ms-1 d-none d-sm-inline">Usage</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="pb-4">
                        <a href="/logout" class="btn  btn-log nav-c">
                            <div class="pb-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class=" d-none d-sm-inline">Logout</span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
            <div class="px-1">
                <div class="section">
                    <h3 class=" presets "> Presets </h3>
                    <div class="col row">
                        <!-- THUMB -->
                        <div class="col-6 col-md-2 align-content-start finger">
                            <div class="card finger-card mr-5">
                                <div class="card-body">
                                    <div class="form-group d-flex align-items-center">
                                        <h5 class="finger">Thumb</h5>
                                        <label class="switch">
                                            <input type="checkbox" id="thumbToggle">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <!-- Thumb & other Gestures -->
                                    <?php
                                    $defaultImageIndex = 1; // Start index for other gestures
                                    foreach ($thumb_gestures as $gesture):
                                        $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                        if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                            $imageIndex = $thumbImageIndex; // Use thumb image index for thumb gestures
                                            $thumbImageIndex++; // Increment thumb image index
                                        } else {
                                            $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                        }
                                    ?>
                                        <div class="form-group d-flex align-items-center <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                            <h6 class="finger"><?= htmlspecialchars($gesture['gesture_name']) ?></h6>
                                            <label class="switch">
                                                <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                                aria-hidden="true"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="<?= './assets/img/' . $imageIndex . '.png' ?>"
                                                data-id="<?= $gesture['gesture_id'] ?>"
                                                data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                            </i>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pointer -->
                        <div class="col-6 col-md-2 align-content-start finger">
                            <div class="card finger-card mr-5">
                                <div class="card-body">
                                    <div class="form-group d-flex align-items-center">
                                        <h5 class="finger">Pointer</h5>
                                        <label class="switch">
                                            <input type="checkbox" id="thumbToggle">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <?php
                                    $defaultImageIndex = 7; // Start index for other gestures
                                    foreach ($index_gestures as $gesture):
                                        $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                        if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                            $imageIndex = $indexImageIndex; // Use thumb image index for thumb gestures
                                            $indexImageIndex++; // Increment thumb image index
                                        } else {
                                            $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                        }
                                    ?>
                                        <div class="form-group d-flex align-items-center <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                            <h6 class="finger"><?= htmlspecialchars($gesture['gesture_name']) ?></h6>
                                            <label class="switch">
                                                <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                                aria-hidden="true"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="<?= './assets/img/' . $imageIndex . '.png' ?>"
                                                data-id="<?= $gesture['gesture_id'] ?>"
                                                data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                            </i>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                        <!-- Middle -->
                        <div class="col-6 col-md-2 align-content-start finger">
                            <div class="card finger-card mr-5">
                                <div class="card-body">
                                    <div class="form-group d-flex align-items-center">
                                        <h5 class="finger">Middle</h5>
                                        <label class="switch">
                                            <input type="checkbox" id="thumbToggle">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <?php
                                    $middleImageIndex = 14; // Start image index for Thumb gestures at 6
                                    $defaultImageIndex = 11; // Start index for other gestures
                                    foreach ($middle_gestures as $gesture):
                                        $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                        if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                            $imageIndex = $middleImageIndex; // Use thumb image index for thumb gestures
                                            $middleImageIndex++; // Increment thumb image index
                                        } else {
                                            $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                        }
                                    ?>
                                        <div class="form-group d-flex align-items-center <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                            <h6 class="finger"><?= htmlspecialchars($gesture['gesture_name']) ?></h6>
                                            <label class="switch">
                                                <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                                aria-hidden="true"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="<?= './assets/img/' . $imageIndex . '.png' ?>"
                                                data-id="<?= $gesture['gesture_id'] ?>"
                                                data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                            </i>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <!-- Ring -->
                        <div class="col-6 col-md-2 align-content-start finger">
                            <div class="card finger-card mr-5">
                                <div class="card-body">
                                    <div class="form-group d-flex align-items-center">
                                        <h5 class="finger">Ring</h5>
                                        <label class="switch">
                                            <input type="checkbox" id="thumbToggle">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <?php
                                    $ringImageIndex = 17; // Start image index for Thumb gestures at 6
                                    $defaultImageIndex = 14; // Start index for other gestures
                                    foreach ($ring_gestures as $gesture):
                                        $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                        if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                            $imageIndex = $ringImageIndex; // Use thumb image index for thumb gestures
                                            $ringImageIndex++; // Increment thumb image index
                                        } else {
                                            $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                        }
                                    ?>
                                        <div class="form-group d-flex align-items-center <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                            <h6 class="finger"><?= htmlspecialchars($gesture['gesture_name']) ?></h6>
                                            <label class="switch">
                                                <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                                aria-hidden="true"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="<?= './assets/img/' . $imageIndex . '.png' ?>"
                                                data-id="<?= $gesture['gesture_id'] ?>"
                                                data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                            </i>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <!-- Pinky -->
                        <div class="col-6 col-md-2 align-content-start finger">
                            <div class="card finger-card mr-5">
                                <div class="card-body">
                                    <div class="form-group d-flex align-items-center">
                                        <h5 class="finger">Pinky</h5>
                                        <label class="switch">
                                            <input type="checkbox" id="thumbToggle">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <?php
                                    // Start image index for Thumb gestures at 6
                                    $defaultImageIndex = 16; // Start index for other gestures
                                    foreach ($pinky_gestures as $gesture):
                                        $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                        if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                            $imageIndex = $pinkyImageIndex; // Use thumb image index for thumb gestures
                                            $pinkyImageIndex++; // Increment thumb image index
                                        } else {
                                            $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                        }
                                    ?>
                                        <div class="form-group d-flex align-items-center <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                            <h6 class="finger"><?= htmlspecialchars($gesture['gesture_name']) ?></h6>
                                            <label class="switch">
                                                <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                                <span class="slider"></span>
                                            </label>
                                            <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                                aria-hidden="true"
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="<?= './assets/img/' . $imageIndex . '.png' ?>"
                                                data-id="<?= $gesture['gesture_id'] ?>"
                                                data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                            </i>
                                        </div>
                                    <?php endforeach; ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal HTML structure -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <img class="d-block" id="modalImage" src="" alt="Preview Image" class="img-fluid">
                        <form action="presets.php" method="POST" class="mt-4">
                            <input type="hidden" id="gestureId" name="gesture_id" value="">
                            <input class="rounded-2 p-2 input_com" type="text" id="modalInput" name="custom_value" value="">
                            <input class="saveBtn p-2 rounded-2" type="submit" value="Save" name="save">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script>
            document.querySelectorAll('.fingers').forEach(column => {
                const thumbSwitch = column.querySelector('.form-group:first-child input[type="checkbox"]');
                const comSwitches = column.querySelectorAll('.form-group:not(:first-child) input[type="checkbox"]');

                // Toggle all COM switches based on the thumb switch
                thumbSwitch.addEventListener('change', function() {
                    const isChecked = this.checked;
                    comSwitches.forEach(comSwitch => {
                        comSwitch.checked = isChecked;
                    });
                });
            });

            // Event listener for the modal to set the image and values
            document.addEventListener('DOMContentLoaded', function() {
                var imageModal = document.getElementById('imageModal');
                imageModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget; // Button that triggered the modal

                    // Get data attributes from the button
                    var imageUrl = button.getAttribute('data-img'); // Extract image URL from data-* attribute
                    var gestureId = button.getAttribute('data-id'); // Extract gesture ID
                    var gestureValue = button.getAttribute('data-value'); // Extract gesture value

                    // Set the image source and the input value in the modal
                    document.getElementById('modalImage').src = imageUrl; // Set the image source
                    document.getElementById('gestureId').value = gestureId; // Set the gesture ID input value
                    document.getElementById('modalInput').value = gestureValue; // Set the current gesture value
                });

                // Clear image and input value when the modal is closed
                imageModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modalImage').src = ''; // Clear the image src
                    document.getElementById('modalInput').value = ''; // Clear the input value
                    document.getElementById('gestureId').value = ''; // Clear the gesture ID input value
                });
            });
        </script>

</body>

</html>