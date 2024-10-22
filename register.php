<?php
// Set session cookie parameters with a lifetime of 1 minute
// Set session cookie lifetime to 30 days (30 days * 24 hours * 60 minutes * 60 seconds)
$lifetime = 30 * 24 * 60 * 60;
session_set_cookie_params($lifetime);

// Start the session
session_start();
// Database connection
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_name']) && $_POST['form_name'] === 'register') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone']);
    $dealer_code = mysqli_real_escape_string($conn, $_POST['dealerCode']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if email already exists
    $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $email_check_sql);

    if (mysqli_num_rows($result) > 0) {
        echo "

        <script>
          alert('Error: Email already exists');
        </script>
        ";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle file upload
        $imagePath = NULL;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $upload_dir = 'uploads/';
            $imagePath = $upload_dir . $file_name;

            // Create the upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($tmp_name, $imagePath)) {
                // File uploaded successfully
            } else {
                echo  "<script>alert('Failed to upload image.');</script>";
                exit;
            }
        }
        $uniqueId = "powerfriend-$name-$dealer_code";
        // SQL query to insert data into users table
        $sql = "INSERT INTO users (name, address, phone_number, dealer_code, email, password, image, uniqueId)
                VALUES ('$name', '$address', '$phone_number', '$dealer_code', '$email', '$hashed_password', '$imagePath','$uniqueId')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to login page after successful registration
            // header("Location: register.php?uniqueId=$uniqueId&status=sucessfull");
            echo '<script>if (confirm("Register Successful. Do you want to login?")) { window.location.href = "./register.php"; toggleForms(); } else { window.location.href = "./index.php"; }</script>';
            exit;
        } else {
            // echo "Error: " . mysqli_error($conn);
            echo  "<script>alert('Error: '.mysqli_error($conn)');</script>";
        }
    }

    // Close the connection
    }
?>
<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_name']) && $_POST['form_name'] === 'login') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dealer_code = mysqli_real_escape_string($conn, $_POST['dealerCode']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query to check if the credentials match
    $login_check_sql = "SELECT * FROM users WHERE name = '$name' AND dealer_code = '$dealer_code'";
    $result = mysqli_query($conn, $login_check_sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Set session variables with user data
            $_SESSION['login_id'] = $user['id'];
            $_SESSION['login_timestamp'] = time();
            $_SESSION['unique_id'] = $user['uniqueId']; // Set uniqueId in session

            // Save session ID in a cookie
            setcookie("powerfriend", session_id(), time() + $lifetime, "/");

            echo "
                <script>
                    alert('Login successful!');
                  window.location.href = './register.php';
                </script>
            ";

        } else {
            echo "
                <script>
                  alert('Incorrect login information. Please check your credentials.');
                  window.location.href = './register.php';
                </script>
            ";
        }
    } else {
        echo "
            <script>
              alert('Incorrect login information. Please check your credentials.');
              window.location.href = './register.php';
            </script>
        ";
    }
    // Close the connection
    // mysqli_close($conn);
}
?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Power Friend</title>
  <script src="https://kit.fontawesome.com/e7678863ec.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Outfit:wght@100..900&family=Pacifico&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <style>
    /* *{border:1px solid red;} */
    ::-webkit-scrollbar {
      height: 6px;
      width: 6px;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #FF204E;
      border-radius: 6px;
    }

    ::-webkit-scrollbar-track {
      background-color: #00224D;
      border-radius: 6px;
    }

    #imagePreview {
      display: none;
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      /* This makes the image circular */
      border: 2px solid #007bff;
      /* Optional: adds a border around the circle */
    }

    .circle {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background-color: #007bff;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
    }

  </style>
</head>

<body>
  <div class="m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './userNav.php'; ?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10 overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
      <div class="container mt-3 d-flex flex-column justify-content-center align-items-center position-relitive " style="height:auto;">
        <!-- register form -->
         <!-- <img src="./loginBg1.jpg" class="float-center position-absolute z-n1 opacity-75 " style="filter:drop-shadow(5px 5px 5px gray);height:95%;width:auto;top:50%;left:50%; transform:translate(-50%, -50%) scaleX(-1);"> -->
        <div class="row g-3 w-100 p-0 flex-column flex-lg-row">
          <?php
            
            // Check for connection errors
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $imagePath = './demo.jpg';
            $name = '';
            $address = '';
            $email = '';
            $dealer_code = '';
            $phone_number = '';
            // Check if uniqueId is set in the session
            if (isset($_SESSION['unique_id'])) {
                // Sanitize uniqueId to prevent SQL injection
                $uniqueId = $_SESSION['unique_id'];

                // Query to get user details based on uniqueId
                $user_details_sql = "SELECT * FROM users WHERE uniqueId = '$uniqueId'";
                $result = mysqli_query($conn, $user_details_sql);

                // Check if the query was successful and if any user was found
                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                    // Set image path or fallback to a default image if none is set
                    $imagePath = !empty($user['image']) ? $user['image'] : './demo.jpg';
                    $name = !empty($user['name']) ? $user['name'] : '';
                    $address = !empty($user['address']) ? $user['address'] : '';
                    $email = !empty($user['email']) ? $user['email'] : '';
                    $dealer_code = !empty($user['dealer_code']) ? $user['dealer_code'] : '';
                    $phone_number = !empty($user['phone_number']) ? $user['phone_number'] : '';
                    
                    // Output the image or other user data as needed
                    // echo "<img src='$imagePath' alt='User Image'>";

                } else {
                    // echo "<p>No user found with the provided uniqueId.</p>";
                    echo '<div class=" z-1 position-sticky alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
                              <strong>Failed!</strong> No user found with the provided uniqueId.
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                }

            } else {
              echo '<div class=" z-1 position-sticky alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                        <strong>Success!</strong> You are no longer logged in. Please log in to use more features.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
      
            }

            // Close the database connection
            // mysqli_close($conn);
          ?>

          <div class="col col-lg-5 d-flex justify-content-center align-items-center">
            <div class="text-center"
              style="overflow:hidden; width: 150px; height: 150px; border-radius: 50%;background: linear-gradient(145deg, #cacaca, #f0f0f0);box-shadow:  14px 14px 28px #b5b5b5,-14px -14px 28px #ffffff;">
              <img class="shadow" src="<?php echo htmlspecialchars($imagePath); ?>" alt="Uploaded Image"
                style="object-fit :contain; width: 150px; height: 150px; ">
            </div>
          </div>

          <div class="col col-lg-5">
            <div id="formDataDisplay" class="form-data-display">
              <p><strong>Name:</strong>
                <?php echo $name; ?>
              </p>
              <p><strong>Address:</strong>
                <?php echo $address; ?>
              </p>
              <p><strong>Phone Number:</strong>
                <?php echo $phone_number; ?>
              </p>
              <p><strong>Dealer Code:</strong>
                <?php echo $dealer_code; ?>
              </p>
              <p><strong>Email:</strong>
                <?php echo $email; ?>
              </p>
            </div>
          </div>
        </div>
        <form id="register_form" class="d-block w-100 needs-validation" novalidate method="POST" name="register"
          enctype="multipart/form-data" action="register.php">
          <input type="hidden" name="form_name" value="register">
          <div class="row g-3">
            <!-- Inside your form layout, right column -->

            <!-- Right Side: Display Submitted Data -->
            <div class="p-0 row g-3 d-flex flex-column flex-lg-row justify-content-center align-items-center">
              <!-- Account Management -->
              <div class="d-flex justify-content-center flex-column flex-lg-row">
                <div class="col-lg-6 p-0">
                  <div class="card shadow-sm mb-3">
                    <div class="card-body">
                      <!-- Name -->
                      <div class="form-group mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                          <div class="invalid-feedback">
                            Please enter your name.
                          </div>
                        </div>
                      </div>

                      <!-- Address -->
                      <div class="form-group mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-map-marker-alt"></i></span>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                            required>
                          <div class="invalid-feedback">
                            Please enter your address.
                          </div>
                        </div>
                      </div>

                      <!-- Phone Number -->
                      <div class="form-group mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                          <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number"
                            required>
                          <div class="invalid-feedback">
                            Please enter your phone number.
                          </div>
                        </div>
                      </div>

                      <!-- Dealer Code -->
                      <div class="form-group mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                          <input type="text" class="form-control" id="dealerCode" name="dealerCode"
                            placeholder="Dealer Code" required>
                          <div class="invalid-feedback">
                            Please enter your dealer code.
                          </div>
                        </div>
                      </div>

                      <!-- Email -->
                      <div class="form-group mb-3">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                          <div class="invalid-feedback">
                            Please enter a valid email address.
                          </div>
                        </div>
                      </div>

                      <!-- Password Field with Toggle Icon -->
                      <div class="form-group mb-3 position-relative">
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                          <input type="password" class="form-control" id="Rpassword" name="password"
                            placeholder="Password" required>
                          <button type="button"
                            class="btn btn-light position-absolute end-0 top-50 translate-middle-y pe-2"
                            onclick="togglePassword('Rpassword', 'RpasswordIcon')">
                            <i id="RpasswordIcon" class="fa-solid fa-eye"></i>
                          </button>
                        </div>
                        <div class="invalid-feedback">
                          Please enter a password.
                        </div>
                      </div>

                      <!-- Confirm Password -->
                      <!-- Uncomment and use this section if you want to validate password confirmation -->
                      <!-- 
                    <div class="form-group mb-3">
                      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                      <div class="invalid-feedback">
                        Passwords do not match.
                      </div>
                    </div>
                    -->

                      <!-- Submit Button -->
                      <div class="d-flex">
                        <button type="submit" class="btn btn-primary me-2 flex-grow-1" id="registerButton"
                          disabled>Register</button>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- Image Upload Section -->
                <div class="col-lg-6 p-0">
                  <div class="card shadow-sm mb-3">
                    <div class="card-header text-center bg-primary text-white">
                      <!-- <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-2" style="width: 40px; height: 40px;">
                            
                          </svg> -->
                      <h5 class="mb-0">Browse File to Upload!</h5>
                    </div>
                    <div class="card-body text-center">
                      <label id="fileLabel" for="file"
                        class="btn btn-outline-primary d-flex flex-column align-items-center py-3 w-100"
                        style="height: auto;position: relative;">
                        <!-- SVG Icon - Initially visible
                            <p class="mb-2" style="width: 22vh; height: 22vh;"></p> -->

                        <!-- File name text -->
                        <p id="fileName" class="mb-0">No file selected</p>

                        <!-- Image Preview - Initially hidden -->
                        <div class="d-flex justify-content-center" style="height:23vh;width:100%;">
                          <img id="imagePreview" class="img-thumbnail mt-2"
                            style="display: none; width: 22vh; height: 22vh;" alt="Preview Image">
                        </div>
                      </label>

                      <input id="file" name="image" type="file" style="display: none;"
                        onchange="updateFileNameAndPreview(event)">
                    </div>
                    <div class="col-lg-12 d-flex flex-column justify-content-center">
                      <div class="form-group">
                        <button type="button" class="btn btn-danger w-100 mb-2" onclick="deleteAccount()">Delete
                          Account</button>
                        <?php
                        if(!empty($name) && !empty($address) && !empty($email) && !empty($dealer_code) && !empty($phone_number)){
                          echo '<button onclick="logout()" class="btn btn-danger flex-grow-1 w-100" type="button">Logout</button>';
                        }
                        else {
                         echo '<button onclick="toggleForms()" class="btn btn-danger flex-grow-1 w-100" type="button">Login</button>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Side: Account Management Buttons -->

            </div>
          </div>
      </div>
      </form>
      <!-- logiun form -->
      <form id="login_form" class="d-none needs-validation d-flex flex-row justify-content-center" style="width:100%"
        novalidate method="POST" name="login" enctype="multipart/form-data" action="register.php" >
        <input type="hidden" name="form_name" value="login">
        <div class="row w-100 d-flex justify-content-center align-items-center">

          <!-- Account Management -->
          <div class="col-12 col-lg-5 d-flex flex-column justify-content-center">
            <div class="card shadow-sm mb-3">
              <div class="card-body">
                <!-- Name -->
                <div class="form-group mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                    <input type="text" class="form-control" id="Lname" name="name" placeholder="Enter Name" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                  </div>
                </div>

                <!-- Dealer Code -->
                <div class="form-group mb-3">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                    <input type="text" class="form-control" id="LdealerCode" name="dealerCode"
                      placeholder="Enter Dealer Code" required>
                    <div class="invalid-feedback">Please enter your dealer code.</div>
                  </div>
                </div>
                <!-- Password Field with Toggle Icon -->
                <div class="form-group mb-3 position-relative">
                  <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control" id="Lpassword" name="password" placeholder="Password"
                      required>
                    <button type="button" class="btn btn-light position-absolute end-0 top-50 translate-middle-y pe-2"
                      onclick="togglePassword('Lpassword', 'LpasswordIcon')">
                      <i id="LpasswordIcon" class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">
                    Please enter a password.
                  </div>
                </div>
                <div class="row g-3">

                  <div class="form-group mb-3 d-flex justify-content-between align-items-center">

                    <div class="form-group mb-3 col-lg-3 d-flex justify-content-center align-items-center">
                      <button id="loginBtn" type="submit" class="btn btn-primary w-100" disabled>Login</button>
                    </div>

                    <div class="form-group mb-3 col-lg-3 d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-primary w-100" onclick="toggleForms()">Register</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <script>
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    document.getElementById('menuButton').addEventListener('click', function (event) {
        var menuItems = document.getElementById('menusItems');
        var adminMenu = document.getElementById('adminMenu');
    
        if (menuItems.classList.contains('d-flex')) {
            menuItems.classList.remove('d-flex');
            menuItems.classList.add('d-none');
            adminMenu.classList.remove('d-flex');
            adminMenu.classList.add('d-none');
        } else {
            menuItems.classList.remove('d-none');
            menuItems.classList.add('d-flex');
            adminMenu.classList.remove('d-none');
            adminMenu.classList.add('d-flex');
        }
    
        // Prevent the click from bubbling up to the document event listener
        event.stopPropagation();
    });
    
    document.addEventListener('click', function () {
        var menuItems = document.getElementById('menusItems');
        var adminMenu = document.getElementById('adminMenu');
    
        if (menuItems.classList.contains('d-flex')) {
            menuItems.classList.remove('d-flex');
            menuItems.classList.add('d-none');
            adminMenu.classList.remove('d-flex');
            adminMenu.classList.add('d-none');
        }
    });
    </script>
  <script>
    function updateFileNameAndPreview(event) {
      const input = event.target;
      const file = input.files[0];
      const fileName = file ? file.name : "No file selected";
      const fileNameElement = document.getElementById('fileName');
      const imagePreview = document.getElementById('imagePreview');
      const fileIcon = document.getElementById('fileIcon');

      fileNameElement.textContent = fileName;

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.src = e.target.result;
          imagePreview.style.display = 'block';
          fileIcon.style.display = 'none';
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.style.display = 'none';
        fileIcon.style.display = 'block';
      }
    }
    function toggleForms() {
      const registerForm = document.getElementById('register_form');
      const loginForm = document.getElementById('login_form');

      if (registerForm.classList.contains('d-none')) {
        // Show the register form and hide the login form
        registerForm.classList.remove('d-none');
        registerForm.classList.add('d-block');

        loginForm.classList.remove('d-block');
        loginForm.classList.add('d-none');
      } else {
        // Show the login form and hide the register form
        registerForm.classList.remove('d-block');
        registerForm.classList.add('d-none');

        loginForm.classList.remove('d-none');
        loginForm.classList.add('d-block');
      }
    }
    // Disable buttons until all fields are filled
    const nameInput = document.getElementById('Lname');
    const dealerCodeInput = document.getElementById('LdealerCode');
    const passwordInput = document.getElementById('Lpassword');
    const loginBtn = document.getElementById('loginBtn');

    // Update the validateForm function to only affect the login button
    function validateForm() {
      const isValid = nameInput.value && dealerCodeInput.value && passwordInput.value;
      loginBtn.disabled = !isValid;
    }

    // Keep this part the same, as it handles the login button functionality
    nameInput.addEventListener('input', validateForm);
    dealerCodeInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);


    nameInput.addEventListener('input', validateForm);
    dealerCodeInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);
    // show password
    function togglePassword(passwordFieldId, iconId) {
      const passwordField = document.getElementById(passwordFieldId);
      const icon = document.getElementById(iconId);

      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }


    function deleteAccount() {
      if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        // Assuming you have a form specifically for deleting the account
        window.location.href = "delete_account.php"; // Adjust the URL according to your setup
      }
    }

    function logout() {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "logout.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Optionally handle the response if needed
          window.location.reload();
        }
      };
      xhr.send();
    }
    // Function to show the login form and hide the registration form
    function showLoginForm() {
      document.getElementById("registerForm").style.display = "none";
      document.getElementById("loginForm").style.display = "block";
    }
    // Function to check if all required fields are filled
    function checkFormCompletion() {
      const name = document.getElementById('name').value.trim();
      const address = document.getElementById('address').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const dealerCode = document.getElementById('dealerCode').value.trim();
      // const email = document.getElementById('email').value.trim();
      const password = document.getElementById('Rpassword').value.trim();
      // Uncomment this line if confirmPassword is used
      // const confirmPassword = document.getElementById('confirmPassword').value.trim();

      const isFormComplete = name && address && phone && dealerCode && password;

      document.getElementById('registerButton').disabled = !isFormComplete;
    }

    // Add event listeners to input fields
    const inputFields = document.querySelectorAll('#name, #address, #phone, #dealerCode, #password');
    inputFields.forEach(input => {
      input.addEventListener('input', checkFormCompletion);
    });
    setTimeout(function () {
      var alert = document.getElementById("myAlert");
      if (alert) {
        alert.classList.remove("show");
        alert.classList.add("d-none");
      }
    }, 3000);

  </script>
</body>

</html>