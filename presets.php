<?php
session_start();  // Start session at the very top

require_once "./controllers/gesture_controllers.php";

// Check if `user_id` exists in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Get the user_id from session

    // Instantiate Gesture controller
    $gestureController = new Gesture();

    // Retrieve gestures by user ID
    $thumb_gestures = $gestureController->get_thumb_gestures($user_id);
    $index_gestures = $gestureController->get_index_gestures($user_id);
    $middle_gestures = $gestureController->get_middle_gestures($user_id);
    $ring_gestures = $gestureController->get_ring_gestures($user_id);
    $pinky_gestures = $gestureController->get_pinky_gestures($user_id);
    $special_gestures = $gestureController->get_special_gestures($user_id);

    // Initialize gesture data
    $gestureData = null;
    $currentValue = null;
    $user_gesture_id = null;

    // Check if a specific gesture_name is requested (e.g., from query parameter)
    if (isset($_GET['gesture_name'])) {
        $gesture_name = $_GET['gesture_name'];

        // Fetch gesture information for the user and gesture_name
        $gestureData = $gestureController->getGestureDataByUserAndName($user_id, $gesture_name);

        // Check if data exists for the given gesture
        if ($gestureData) {
            $user_gesture_id = $gestureData['user_gesture_id'];
            $currentValue = $gestureData['gesture_value'];
        } else {
            echo "Gesture data not found.";
            exit;
        }
    }
} else {
    // Handle case where user_id is not available
    echo "User not logged in or user ID not available.";
    exit;
}

// Handle POST request to update gesture value
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $user_gesture_id = $_POST['user_gesture_id'];
    $customValue = $_POST['custom_value'];

    // Update gesture value using the controller method
    $gestureController->updateGestureValue($user_id, $gesture_name, $customValue);

    // Redirect to avoid form resubmission
    header("Location: presets.php?message=" . urlencode("Gesture updated successfully"));
    exit;
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
                    <img src="./user.jpg" alt="" />
                </div>
                <div class="user-details d-flex flex-column ms-3">
                    <div class="name text fw-bold">PATIENT</div>
                    <div class="identification text">STEPH CURRY</div>
                </div>
            </div>

            <div class="menu d-flex flex-column">
                <p class="mt-2 text color-secondary fw-bold">MAIN</p>
                <a href="./dashboard.php" class="d-block text-decoration-none links p-2 rounded-2">
                    <i class="ph ph-house-simple fw-bold me-2"></i>Dashboard</a>
                <a href="./presets.php" class="d-block text-decoration-none links p-2 mt-2 rounded-2 mb-3 active">
                    <i class="ph ph-faders-horizontal fw-bold me-2"></i>Presets</a>
                <div class="separator w-100"></div>
                <p class="mt-2 text color-secondary fw-bold">SETTINGS</p>
                <a href="./accountSettings.php" class="d-block text-decoration-none links p-2 rounded-2">
                    <i class="ph ph-user fw-bold me-2"></i>Account</a>
                <a href="./logout.php" class="d-block text-decoration-none links p-2 rounded-2">
                    <i class="ph ph-arrow-line-right fw-bold me-2"></i>Logout</a>
            </div>
        </div>

        <!-- main container -->
        <div class="sections ">
            <h3 class=" presets "> Presets </h3>
            <div class="d-flex flex-wrap justify-content-between">
                <!-- THUMB -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Thumb</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            $defaultImageIndex = 1;
                            foreach ($thumb_gestures as $gesture):
                                $imageIndex = $defaultImageIndex;
                                if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                    $imageIndex = $thumbImageIndex;
                                    $thumbImageIndex++;
                                } else {
                                    $defaultImageIndex++;
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
                                        <label class="switch">
                                            <input type="checkbox" class="<?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture-checkbox' : '' ?>">
                                            <span class="slider"></span>
                                        </label>
                                        <i class="fa fa-ellipsis-h ellipsis-icon modal-pic px-2"
                                            aria-hidden="true"
                                            style="cursor: pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal"
                                            data-img="<?= 'assets/img/' . $imageIndex . '.png' ?>"
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Pointer -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Pointer</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            $defaultImageIndex = 6;
                            foreach ($index_gestures as $gesture):
                                $imageIndex = $defaultImageIndex;
                                if (strpos($gesture['gesture_name'], 'Thumb') === 0) {
                                    $imageIndex = $indexImageIndex;
                                    $indexImageIndex++;
                                } else {
                                    $defaultImageIndex++;
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
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
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Middle -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Middle</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            $middleImageIndex = 13; // Start image index for Thumb gestures at 6
                            $defaultImageIndex = 10; // Start index for other gestures
                            foreach ($middle_gestures as $gesture):
                                $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                if (strpos($gesture['gesture_name'], 'Middle') === 0) {
                                    $imageIndex = $middleImageIndex; // Use thumb image index for thumb gestures
                                    $middleImageIndex++; // Increment thumb image index
                                } else {
                                    $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
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
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Ring -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Ring</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            $ringImageIndex = 17; // Start image index for Thumb gestures at 6
                            $defaultImageIndex = 13; // Start index for other gestures
                            foreach ($ring_gestures as $gesture):
                                $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                if (strpos($gesture['gesture_name'], 'Ring') === 0) {
                                    $imageIndex = $ringImageIndex; // Use thumb image index for thumb gestures
                                    $ringImageIndex++; // Increment thumb image index
                                } else {
                                    $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
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
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Pinky -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Pinky</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            // Start image index for Thumb gestures at 6
                            $defaultImageIndex = 15; // Start index for other gestures
                            foreach ($pinky_gestures as $gesture):
                                $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                if (strpos($gesture['gesture_name'], 'Pinky') === 0) {
                                    $imageIndex = $pinkyImageIndex; // Use thumb image index for thumb gestures
                                    $pinkyImageIndex++; // Increment thumb image index
                                } else {
                                    $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
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
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <!-- Special  -->
                <div class="col-6 col-md-4 finger d-flex justify-content-center">
                    <div class="card finger-card d-flex justify-content-start p-4">
                        <div class="card-body">
                            <div class="form-group d-flex align-items-center">
                                <h3 class="finger">Special</h3>
                                <label class="switch ms-3">
                                    <input type="checkbox" id="thumbToggle">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <!-- Display Thumb & Other Gestures -->
                            <?php
                            // Start image index for Thumb gestures at 6
                            $defaultImageIndex = 16; // Start index for other gestures
                            foreach ($special_gestures as $gesture):
                                $imageIndex = $defaultImageIndex; // Default image index for non-thumb gestures

                                if (strpos($gesture['gesture_name'], 'Special') === 0) {
                                    $imageIndex = $specailImageIndex; // Use thumb image index for thumb gestures
                                    $pinkyImageIndex++; // Increment thumb image index
                                } else {
                                    $defaultImageIndex++; // Increment default image index for non-thumb gestures
                                }
                            ?>
                                <div class="form-group d-flex w-100 align-items-center justify-content-between p-2 <?= strpos($gesture['gesture_name'], 'Thumb') === 0 ? 'thumb-gesture' : '' ?>">
                                    <h5 class="finger d-block mb-0"><?= htmlspecialchars($gesture['gesture_name']) ?></h5>
                                    <div class="right-sect d-flex w-50 align-items-center">
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
                                            data-id="<?= $gesture['user_id'] ?>"
                                            data-value="<?= htmlspecialchars($gesture['gesture_value']) ?>">
                                        </i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                <h3 class="modal-title" id="imageModalLabel">Edit Gesture Value</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <!-- Gesture Preview Image -->
                <img id="modalImage" src="" alt="Preview Image" class="d-block img-fluid mb-3">

                <!-- Gesture Edit Form -->
                <form action="presets.php" method="POST" class="mt-4">
                    <!-- Hidden field for user_gesture_id -->
                    <input type="hidden" name="user_gesture_id" id="userGestureId" value="">

                    <!-- Input field pre-filled with current gesture_value -->
                    <label for="modalInput" class="form-label">Gesture Value:</label>
                    <input type="text" id="modalInput" name="custom_value" class="d-block rounded-2 p-2 input_com" value="">

                    <hr>
                    <div class="d-flex justify-content-end">
                        <input class="saveBtn p-2 rounded-2 bg-purple" type="submit" value="Save" name="save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






    <!-- Bootstrap JS CDN -->
    <?php
    include_once "./includes/footer.php";
    ?>
   <script>
    // Event listener to handle modal actions
    document.addEventListener('DOMContentLoaded', function() {
        const imageModal = document.getElementById('imageModal');

        // Event listener when the modal is about to show
        imageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button that triggered the modal

            // Get data attributes from the button
            const imageUrl = button.getAttribute('data-img') || ''; // Fallback to empty if null
            const gestureId = button.getAttribute('data-id') || '';
            const gestureValue = button.getAttribute('data-value') || '';

            // Debugging output (optional)
            console.log("Image URL:", imageUrl);
            console.log("Gesture ID:", gestureId);
            console.log("Gesture Value:", gestureValue);

            // Set modal content based on button data
            const modalImage = document.getElementById('modalImage');
            const userGestureId = document.getElementById('userGestureId');
            const modalInput = document.getElementById('modalInput');

            // If image URL is empty, hide the image element
            if (imageUrl) {
                modalImage.src = imageUrl;
                modalImage.style.display = 'block'; // Show the image if a valid URL is provided
            } else {
                modalImage.style.display = 'none'; // Hide the image if no URL is provided
            }

            // Set values for gesture ID and gesture value
            userGestureId.value = gestureId;
            modalInput.value = gestureValue;
        });

        // Event listener when the modal is hidden
        imageModal.addEventListener('hidden.bs.modal', function() {
            const modalImage = document.getElementById('modalImage');
            const modalInput = document.getElementById('modalInput');
            const userGestureId = document.getElementById('userGestureId');

            // Clear content when modal is closed
            modalImage.src = ''; // Clear the image src
            modalImage.style.display = 'none'; // Hide the image
            modalInput.value = ''; // Clear the input field
            userGestureId.value = ''; // Clear the gesture ID
        });
    });
</script>


</body>

</html>