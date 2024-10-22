<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <style>
    /*{border:1px solid red;}
    /* Customize the scrollbar track */
    ::-webkit-scrollbar {height:6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
    /* Input container */
    .input-container {position: relative;margin: 20px;}
    /* Input field */
    .input-field {display: block;width: 100%;padding: 10px;font-size: 16px;border: none;border-bottom: 2px solid #ccc;outline: none;background-color: transparent;}
    /* Input label */
    .input-label {position: absolute;top: 0;left: 0;font-size: 16px;color: rgba(204, 204, 204, 0);pointer-events: none;transition: all 0.3s ease;}
    /* Input highlight */
    .input-highlight {position: absolute;bottom: 0;left: 0;height: 2px;width: 0;background-color: white;transition: all 0.3s ease;}
    /* Input field:focus styles */
    .input-field:focus + .input-label {top: -20px;font-size: 12px;color: white;}
    input::placeholder , input {color:white;}
    @media (max-width: 768px) {
            .loginObject {
                height: 60vh;
                width: 90vw;
            }
        }
    </style>
  </head>
  <body class="d-flex justify-content-center align-items-center" style="height:100vh;width:100vw;">
    <div class="loginObject m-0 p-0 container row rounded-3 overflow-hidden"style="filter: drop-shadow(0 10px 10px gray);height:auto;width:70vw">
        <div class="col-5 bg-dark d-none d-lg-flex align-items-center justify-content-center flex-column "style="height:80vh;">
            <img src="./admin.png" class="mb-4  rounded-circle"style="width:30%;">   
            <h1 class="mb-4 text-light fs-3 text-center">Power Friend</h1>  
            <p class="mb-4 text-light fw-semibold text-center mx-4">Power Friend provides reliable, long-lasting batteries for all your needs, ensuring consistent performance and dependable energy solutions.</p>
           </div>
        <div class="col-12 col-lg-7 bg-primary d-flex flex-column justify-content-center align-items-center py-5 py-lg-0">              
            <h1 class="text-light mb-5">Admin Login</h1>
            <form action="" method="POST" style="width:75%" autocomplete="off">
                <div class="input-container">
                  <input placeholder="Enter User Name" class="input-field" type="text" name="UserName">
                  <label for="input-field" class="input-label">User Name</label>
                  <span class="input-highlight"></span>
                </div>
                <br>
                <div class="input-container mb-5">
                  <input placeholder="Enter Password" class="input-field" type="password"name="UserPassword">
                  <label for="input-field" class="input-label">Password</label>
                  <span class="input-highlight"></span>
                </div>
                <button type="submit" class="btn btn-dark w-100 " name="Login">Login</button>
            </form>
        </div>
        <?php
            if (isset($_POST['Login'])) {
                // Get form inputs
                $username = $_POST['UserName'];
                $password = $_POST['UserPassword'];

                // Escape the input to prevent SQL injection
                $username = mysqli_real_escape_string($conn, $username);
                $password = mysqli_real_escape_string($conn, $password);

                // Prepare and execute the query to check login credentials
                $query = "SELECT * FROM adlogin WHERE admin_name = '$username' AND admin_password = '$password'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Successful login, redirect to the addtocart.php page
                    $_SESSION['adminloggedin'] = 'YES';
                    header("Location: ./adminParties.php");
                    exit();
                } else {
                    $_SESSION['adminloggedin'] = 'NO';
                    echo "<script>alert('Invalid Username or Password!');</script>";
                }

                mysqli_close($conn);
            }
        ?>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>