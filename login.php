<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dealer_code = mysqli_real_escape_string($conn, $_POST['dealerCode']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query to check if the credentials match
    $login_check_sql = "SELECT * FROM users WHERE name = '$name' AND dealer_code ='$dealer_code'";
    $result = mysqli_query($conn, $login_check_sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            // Set cookies for logged-in user
            $cookie_time = time() + (86400 * 30); // Cookie valid for 30 days
            setcookie("user_id", $user['id'], $cookie_time, "/");
            setcookie("user_name", $user['name'], $cookie_time, "/");
            setcookie("dealer_code", $user['dealer_code'], $cookie_time, "/");

            echo "
                <script>
                    alert('Login successful!');
                    window.location.href = './register.php?uniqueId={$user['uniqueId']}';
                </script>
            ";

        } else {
            echo "
            <script>
                alert('Incorrect login information. Please check your credentials.');
                window.location.href = 'login.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Incorrect login information. Please check your credentials.');
            window.location.href = 'login.php';
        </script>
        ";
    }
    // Close the connection
    mysqli_close($conn);
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
      border-radius: 50%; /* This makes the image circular */
      border: 2px solid #007bff; /* Optional: adds a border around the circle */
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
  <div class="m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center" style="width:100%;height:100vh;">
    <div
      class="z-1 position-absolute position-lg-relative start-0 m-2 p-2 rounded-5 d-flex flex-column justify-content-between align-items-center bg-dark"
      style="width:60px; height:80vh; height: auto !important;">
      <a href="#" id="menuButton"
        class="d-flex justify-content-center align-items-center link-body-emphasis text-decoration-none bg-light rounded-5"
        style="width:45px;height:45px;">
        <i class="fa-solid fa-chart-simple"></i>
      </a>
      <ul id="menusItems"
        class="d-none d-lg-flex overflow-hidden nav nav-pills nav-flush flex-column justify-content-center align-items-center text-center"
        style="width:100%; height:calc(80vh - (40px + 45px));">
        <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right"
          data-bs-custom-class="custom-tooltip" data-bs-title="Cart">
          <a href="./index.php" style="height:40px;width:40px"
            class="mb-2 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5"
            onmouseover="this.style.backgroundColor='white'; this.style.color='#FF204E';"
            onmouseout="this.style.backgroundColor=''; this.style.color='#FF204E';">
            <i class="fa-solid fa-house"></i>
          </a>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip"
          data-bs-title="Registration">
          <a href="register.php" style="height:40px;width:40px"
            class="mb-2 d-flex justify-content-center align-items-center nav-link active border-bottom rounded-5">
            <i class="fa-solid fa-address-card"></i>
          </a>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip"
          data-bs-title="Cart">
          <a href="addToCart.html" style="height:40px;width:40px"
            class="mb-2 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5"
            onmouseover="this.style.backgroundColor='white'; this.style.color='#FF204E';"
            onmouseout="this.style.backgroundColor=''; this.style.color='#FF204E';">
            <i class="fa-solid fa-cart-shopping"></i>
          </a>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip"
          data-bs-title="Payment Details">
          <a href="./paymentDetails.html" style="height:40px;width:40px"
            class="mb-2 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5"
            onmouseover="this.style.backgroundColor='white'; this.style.color='#FF204E';"
            onmouseout="this.style.backgroundColor=''; this.style.color='#FF204E';">
            <i class="fa-solid fa-file-invoice-dollar"></i>
          </a>
        </li>
      </ul>
      <ul id="adminMenu"
        class="d-none d-lg-flex overflow-hidden nav nav-pills nav-flush flex-column justify-content-center align-items-center text-center"
        style="width:100%">
        <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip"
          data-bs-title="Admin">
          <a href="./adminBooking.html" style="height:40px;width:40px"
            class="mb-2 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5"
            onmouseover="this.style.backgroundColor='white'; this.style.color='#FF204E';"
            onmouseout="this.style.backgroundColor=''; this.style.color='#FF204E';">
            <i class="fa-solid fa-user-tie"></i>
          </a>
        </li>
      </ul>
    </div>

    <div class="position-absolute overflow-auto col-12 main m-0 p-10 overflow-auto w-100" style="width:calc(100% - 100px); height:100%;">
      <div class="container mt-3 d-flex flex-column justify-content-center align-items-center" style="height:95%">
        <!-- Show success message if status is success -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
          <div class="alert alert-success">
            Registration successful!
          </div>
        <?php endif; ?>

        <form class="w-100 needs-validation d-flex flex-row flexr-wrap justify-content-center" novalidate method="POST" enctype="multipart/form-data" action="login.php">

          <div class="row g-3 w-50">

          <!-- Account Management -->
            <div class="col-12">
              <div class="card shadow-sm mb-3">
                <div class="card-body">
                  <!-- Name -->
                  <div class="form-group mb-3">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                      <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                  </div>

                  <!-- Dealer Code -->
                  <div class="form-group mb-3">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                        <input type="text" class="form-control" id="dealerCode" name="dealerCode" placeholder="Enter Dealer Code" required>
                      <div class="invalid-feedback">Please enter your dealer code.</div>
                    </div>
                  </div>
                  <!-- Password Field with Toggle Icon -->
                  <div class="form-group mb-3 position-relative">
                      <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                          <button type="button" class="btn btn-light position-absolute end-0 top-50 translate-middle-y pe-2"
                              onclick="togglePassword('password', 'passwordIcon')">
                              <i id="passwordIcon" class="fa-solid fa-eye"></i>
                          </button>
                      </div>
                      <div class="invalid-feedback">
                          Please enter a password.
                      </div>
                  </div>
                  <div class="row g-3">
 
                    <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                   
                      <div class="form-group mb-3 col-md-3 d-flex justify-content-center align-items-center">
                        <button id="loginBtn" type="submit" class="btn btn-primary w-100" disabled>Login</button>
                      </div>

                      <div class="form-group mb-3 col-md-3 d-flex justify-content-center align-items-center">
                        <button type="button" id="registerBtn" class="btn btn-primary w-100" onclick="window.location.href='register.php';">Register</button>
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9gybBogGzR1Zd9409j4zT0q3g5zzS2I4O/rQg1HfQ2E2K3pC4I+" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12yBVjHftF8bTxIMYcyJ1wPDrSeO0L9y1urbUhYIjlBlxE1r" crossorigin="anonymous">
  </script>
  <script>
    // Disable buttons until all fields are filled
    const nameInput = document.getElementById('name');
    const dealerCodeInput = document.getElementById('dealerCode');
    const passwordInput = document.getElementById('password');
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
  </script>
</body>
</html>
