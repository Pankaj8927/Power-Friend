<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// include 'backend/db_connection.php';// Database connection
$sql = "SELECT id, title, description FROM products ORDER BY id DESC";
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] !== 'YES') {
    // Redirect to the login page if not logged in as admin
    header("Location: ./adminLogin.php");
    exit();
} // Include your database connection file

// Ensure the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve uniqueId from the URL
$uniqueId = isset($_GET['uniqueId']) ? $conn->real_escape_string($_GET['uniqueId']) : '';

// Set default values for timestamps
$createdAt = date('Y-m-d H:i:s');
$updatedAt = date('Y-m-d H:i:s');
$fileUploadPath = ''; // Initialize the file upload path

if (!empty($uniqueId) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the file upload
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Set the upload directory
        $uploadDir = './orderpdf/' . $uniqueId; // Create a directory with the uniqueId name

        // Check if the directory already exists
        if (file_exists($uploadDir)) {
            // Delete the directory and its contents
            array_map('unlink', glob("$uploadDir/*.*")); // Delete files inside the directory
            rmdir($uploadDir); // Remove the directory itself
        }

        // Create the directory
        mkdir($uploadDir, 0777, true);

        // Set the new file name and destination path
        $newFileName = $uniqueId . '_' . $fileName; // Concatenate uniqueId and original file name
        $destPath = $uploadDir . '/' . $newFileName; // Destination path with the new file name

        // Move the file to the upload directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $fileUploadPath = $destPath;
            // echo "File uploaded successfully to: $fileUploadPath<br>"; // Debugging
        } else {
            // echo "Error moving the uploaded file.";
            exit;
        }
    } else {
        // echo "File upload error: " . $_FILES['uploadedFile']['error'] . "<br>"; // Debugging
    }

    // Check if the record already exists
    $sql = "SELECT id FROM orders WHERE uniqueId = '$uniqueId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the existing record
        $sql = "UPDATE orders SET 
                updated_at = '$updatedAt', 
                file_path = '$fileUploadPath' 
                WHERE uniqueId = '$uniqueId'";
    } else {
        // Insert a new record
        $sql = "INSERT INTO orders 
                (uniqueId, status, statusMessage, order_confirmed, order_shipped, out_for_delivery, order_delivered, created_at, updated_at, file_path)
                VALUES 
                ('$uniqueId', '', '', '', '', '', '', '$createdAt', '$updatedAt', '$fileUploadPath')";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            if (confirm('Document updated successfully. Do you want to go back ?')) {
                window.history.back();
            } else {
                //window.location.href = 'adminParties.php'; 
            }
        </script>";
    } else {
        echo "Error processing record: " . $conn->error;
        echo "SQL: $sql<br>"; // Debugging
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetchStatus') {
  // Get uniqueId and orderid from URL
  $uniqueId = isset($_GET['uniqueId']) ? $conn->real_escape_string($_GET['uniqueId']) : '';
  $orderid = isset($_GET['orderid']) ? $conn->real_escape_string($_GET['orderid']) : '';

  // Fetch the order status from the database
  $orderStatusSql = "SELECT * FROM orders WHERE uniqueId = '$uniqueId' AND id = '$orderid'";
  $orderStatusResult = $conn->query($orderStatusSql);
  $orderStatus = $orderStatusResult->num_rows > 0 ? $orderStatusResult->fetch_assoc() : [];

  // Return the results as JSON
  echo json_encode([
      'orderid' => $orderid,
      'orderStatus' => $orderStatus
  ]);
  exit;
}

// Fetch the order status from the database
// $claimStatusSql = "SELECT * FROM claim_details WHERE uniqueId = '$uniqueId'";
// $claimStatusresult = $conn->query($claimStatusSql);
// $claimStatus = [];

// if ($claimStatusresult->num_rows > 0) {
//     $claimStatus = $claimStatusresult->fetch_assoc();
// }
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
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Outfit:wght@100..900&family=Pacifico&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <style>
    /*{border:1px solid red;}
    /* Customize the scrollbar track */
    ::-webkit-scrollbar {height:6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
    .form-control:focus {
      box-shadow: none;
    }
/* From Uiverse.io by mrpumps31232 */ 
.checkbox {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  margin-right: 20px;
}

.checkbox input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}

.checkbox-circle {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  border: 2px solid #aaa;
  transition: all 0.3s;
}

.checkbox input[type="checkbox"]:checked ~ .checkbox-circle {
  background: #FF204E;
  border-color: #FF204E;
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  fill: none;
  stroke: #fff;
  stroke-width: 3;
  stroke-linecap: round;
  stroke-linejoin: round;
  opacity: 0;
  transition: all 0.3s;
}

.checkbox input[type="checkbox"]:checked ~ .checkbox-circle .checkmark {
  opacity: 1;
}

.checkmark-circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  transition: stroke-dashoffset 0.3s;
}

.checkbox input[type="checkbox"]:checked ~ .checkbox-circle .checkmark-circle {
  stroke-dashoffset: 0;
}

.checkmark-kick {
  stroke-dasharray: 50;
  stroke-dashoffset: 50;
  transition: stroke-dashoffset 0.3s;
}

.checkbox input[type="checkbox"]:checked ~ .checkbox-circle .checkmark-kick {
  stroke-dashoffset: 0;
}

   
  </style>
</head>

<body>
  <!-- As a link -->
  <div class=" m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './adminNav.php';?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10  overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
        <div class="container mt-3 p-0 d-flex flex-column justify-content-start align-items-center" style="height:95%">
            <!-- section to code not outside  else, if better not to see-->
             <div id="cardDetails" class="m-0 p-0 d-flex flex-column justify-content-start align-items-center align-items-lg-start w-100">
                <?php
                  if ($uniqueId) {
                      // Escape the uniqueId to prevent SQL injection
                      $uniqueId = mysqli_real_escape_string($conn, $uniqueId);

                      // SQL query to fetch user details based on uniqueId
                      $sql = "SELECT * FROM users WHERE uniqueId = '$uniqueId'";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                          // Fetch the user details
                          $row = mysqli_fetch_assoc($result);
                          $userName = htmlspecialchars($row['name']);
                          $userImage = !empty($row['image']) && file_exists($row['image']) ? htmlspecialchars($row['image']) : './account.png';
                          $phoneNumber = htmlspecialchars($row['phone_number']);
                          $emailAddress = htmlspecialchars($row['email']);
                          $address = htmlspecialchars($row['address']);
                          // $hashedUserName = hash('sha256', $userName);
                          // Display the user details in the card
                          echo "
                          <div id='cardDetails' class='m-0 p-0 d-flex flex-column flex-lg-row align-items-center w-100'>
                              <div class='img bg-dark border border-2 border-primary rounded-5' style='width:50px;height:50px;'>
                                  <img src='$userImage' alt='User Image' style='height:100%;width:100%;border-radius:50px;object-fit:contain;'>
                              </div>
                              <h2 class='ms-4 text-uppercase text-truncate' style='width:calc(100% - 200px)'  data-bs-toggle='tooltip' data-bs-placement='left' data-bs-custom-class='custom-tooltip' data-bs-title='$userName'>$userName</h2>
                              <button class='btn btn-primary text-light ms-0 ms-lg-auto' data-bs-toggle='modal' data-bs-target='#uploadFile'>Upload PDF</button>
                          </div>
                          <p class='border-bottom border-primary w-100 text-center text-lg-start text-truncate' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-custom-class='custom-tooltip' data-bs-title='You can reach $userName at phone: $phoneNumber, email: $emailAddress, or visit: $address.'>
                              <i class='fa-solid fa-address-card' style='color: #ff204e;'></i>
                              You can reach <b>$userName</b> at phone: <b>$phoneNumber</b>, email: <b>$emailAddress</b>, or visit: <b>$address</b>.
                          </p>

                          ";
                      } else {
                          // If no user is found with the given uniqueId
                          echo "<p>No details available for the given ID.</p>";
                      }

                      // Free result set
                      mysqli_free_result($result);
                  } else {
                      // If uniqueId is not provided in the URL
                      echo "<p>No details available.</p>";
                  }
                ?>
             </div>
             <p class="fs-5 fw-semibold text-start w-100">Order Details</p>
             <div class="overflow-auto p-2 orderDetails border border-dark rounded-2 w-100 mb-4" style="height: 40%;">
             <?php
                // Get the uniqueId from the URL
                if (isset($_GET['uniqueId'])) {
                  $uniqueId = $_GET['uniqueId'];

                  // Query to fetch orders for the specific uniqueId
                  $Ordsql = "SELECT * FROM orders WHERE uniqueId = '$uniqueId' ORDER BY id DESC";
                  $Ordresult = mysqli_query($conn, $Ordsql);

                  if (mysqli_num_rows($Ordresult) > 0) {
                      // Output each order as a card
                      while($row = mysqli_fetch_assoc($Ordresult)) {
                          $orderDetails = $row['p_details'];
                          echo '
                          <div class="orders px-2 p-0 d-flex justify-content-between align-items-center alert alert-dismissible fade show bg-secondary " role="alert">
                              <div class="w-100 d-flex justify-content-between align-items-center p-0 m-0">
                                <h6 class="my-0 text-light text-truncate" data-bs-toggle="tooltip" data-bs-placement="right"data-bs-custom-class="custom-tooltip"data-bs-title="'.$orderDetails.'">'.$orderDetails.'</h6>
                                <div class="d-flex align-items-center p-0">
                                  <h6 class="my-0 text-light text-truncate me-4">'.$row['status'].'</h6>
                                  <button type="button" class="statusUpdateButton btn btn-outline-primary text-light" data-orderid="'.$row['id'].'" data-bs-toggle="modal" data-bs-target="#statusUpdate">Status</button>
                                </div>
                                </div>
                              <button type="button" class="btn border-0 text-light" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                          </div>';
                      }
                  } else {
                      echo '<h6 class="my-0 text-center">No Order Available!</h6>';
                  }
                } else {
                  echo '<h6 class="my-0 text-center">No uniqueId provided.</h6>';
                }
              ?>
                <!-- <div class="orders px-2 p-0 d-flex justify-content-between align-items-center alert alert-dismissible fade show bg-secondary " role="alert">
                  <h6 class="my-0 text-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, facilis.</h6>
                  <button type="button" class="btn border-0 text-light" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div> -->
             </div>
             <!-- <p class="fs-5 fw-semibold text-start w-100">Claim Details <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cstatusUpdate">Status</button></p> -->
             <p class="fs-5 fw-semibold text-start w-100 d-flex flex-row flex-wrap">Claim Details <button type="button" id="claimStatusSave" class="d-none ms-2 btn btn-outline-primary">Save</button></p>
             <div class="overflow-auto p-2 claimDetails border border-dark rounded-2 w-100" style="height: 40%;">
              <?php
                  // Get the uniqueId from the URL
                  if (isset($_GET['uniqueId'])) {
                    $uniqueId = $_GET['uniqueId'];

                    // Query to fetch orders for the specific uniqueId
                    $Ordsql = "SELECT * FROM claim_details WHERE uniqueId = '$uniqueId' ORDER BY id DESC";
                    $Ordresult = mysqli_query($conn, $Ordsql);

                    if (mysqli_num_rows($Ordresult) > 0) {
                        // Output each order as a card
                        while($row = mysqli_fetch_assoc($Ordresult)) {
                            $orderDetails = 'Battery Type: ' . $row['batteryType'] . ' - Serial Number ' . $row['serialNo'] . ' - Date of Sale ' . $row['dateOfSale'] . '';
                            
                            // Get current status values
                            $batteryStatus = $row['battery_status'];
                            $decisionStatus = $row['decision_status'];
                            $stockStatus = $row['stock_status'];
                            $color = $row['color'];  // Assuming you have a color column in your database

                            echo '
                            <div class="orders px-2 p-0 d-flex justify-content-between align-items-center alert alert-dismissible fade show bg-secondary" role="alert">
                                <h6 class="my-0 text-light text-truncate" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="'.$orderDetails.'">'.$orderDetails.'</h6>
                                <div class="d-flex flex-row">
                                    <select onchange="saveChanges('.$row["id"].');" data-claim-id="'.$row["id"].'" data-claim-color="'.$color.'" class="batteryStatusSelect form-select bg-transparent text-light border-0" aria-label="Default select example">
                                        <option class="bg-dark text-primary">Battery Status</option>
                                        <option class="bg-dark text-primary" value="GOOD" '.($batteryStatus == 'GOOD' ? 'selected' : '').'>GOOD</option>
                                        <option class="bg-dark text-primary" value="BAD" '.($batteryStatus == 'BAD' ? 'selected' : '').'>BAD</option>
                                        <option class="bg-dark text-primary" value="REJECT" '.($batteryStatus == 'REJECT' ? 'selected' : '').'>REJECT</option>
                                    </select>
                                    <select onchange="saveChanges('.$row["id"].');" data-claim-id="'.$row["id"].'" data-claim-color="'.$color.'" class="decisionSelect form-select bg-transparent text-light border-0" aria-label="Default select example">
                                        <option class="bg-dark text-primary" >Decision</option>
                                        <option class="bg-dark text-primary" value="Pending" '.($decisionStatus == 'Pending' ? 'selected' : '').'>Pending</option>
                                        <option class="bg-dark text-primary" value="Despatch" '.($decisionStatus == 'Despatch' ? 'selected' : '').'>Despatch</option>
                                    </select>

                                    <select onchange="saveChanges('.$row["id"].');" data-claim-id="'.$row["id"].'" data-claim-color="'.$color.'" style="background-color: '.($color ? $color : 'transparent').'; color:black;" class="stockSelect fw-semibold form-select border-0" aria-label="Default select example">
                                        <option class="bg-dark text-primary" >Stock</option>
                                        <option class="bg-dark text-primary" value="No Stock" '.($stockStatus == 'No Stock' ? 'selected' : '').'>No Stock</option>
                                        <option class="bg-dark text-primary" value="Ready To Stock" '.($stockStatus == 'Ready To Stock' ? 'selected' : '').'>Ready To Stock</option>
                                        <option class="bg-dark text-primary" value="Stock Done" '.($stockStatus == 'Stock Done' ? 'selected' : '').'>Stock Done</option>
                                        <option class="bg-dark text-primary" value="Complete" '.($stockStatus == 'Complete' ? 'selected' : '').'>Complete</option>
                                        <option class="bg-dark text-primary" value="Already Despatch" '.($stockStatus == 'Already Despatch' ? 'selected' : '').'>Already Despatch</option>
                                    </select>

                                    <button type="button" class="btn border-0 text-light" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<h6 class="my-0 text-center">No Claim Available!</h6>';
                    }
                  } else {
                    echo '<h6 class="my-0 text-center">No uniqueId provided.</h6>';
                  }
                ?>

              <!-- <div class="orders px-2 p-0 d-flex justify-content-between align-items-center alert alert-dismissible fade show bg-secondary " role="alert">
                <h6 class="my-0 text-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, facilis.</h6>
                <button type="button" class="btn border-0 text-light" data-bs-dismiss="alert" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
              </div> -->
             </div>
                      
        </div>
        <!-- Order Status update modal -->
        <div class="modal fade" id="statusUpdate" tabindex="-1" aria-labelledby="statusUpdate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 bg-dark text-light">
                    <div class="modal-header d-flex justify-content-between">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Order Status</h1>
                        <button type="button" class="btn text-light rounded-5" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                      <form action="./backend/statusUpdate.php?uniqueId=<?php echo htmlspecialchars($uniqueId); ?>" method="post">
                        <input type="hidden" name="orderid" id="orderid">
                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Order Confirmed">
                                <input type="checkbox" name="orderConfirmed">
                                <div class="checkbox-circle">
                                    <svg viewBox="0 0 52 52" class="checkmark">
                                        <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                        <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Order Shipped">
                                <input type="checkbox" name="orderShipped">
                                <div class="checkbox-circle">
                                    <svg viewBox="0 0 52 52" class="checkmark">
                                        <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                        <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Out For Delivery">
                                <input type="checkbox" name="outForDelivery">
                                <div class="checkbox-circle">
                                    <svg viewBox="0 0 52 52" class="checkmark">
                                        <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                        <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                    </svg>
                                </div>
                            </label>
                            <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Order Delivered">
                                <input type="checkbox" name="orderDelivered">
                                <div class="checkbox-circle">
                                    <svg viewBox="0 0 52 52" class="checkmark">
                                        <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                        <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                    </svg>
                                </div>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="statusMessage" class="form-label">Status Message</label>
                            <textarea class="form-control" id="statusMessage" name="statusMessage"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Claim Status update modal -->
        <!-- <div class="modal fade" id="cstatusUpdate" tabindex="-1" aria-labelledby="cstatusUpdate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 bg-dark text-light">
                    <div class="modal-header d-flex justify-content-between">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Claim Status</h1>
                        <button type="button" class="btn text-light rounded-5" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                    <form action="./backend/cstatusUpdate.php?uniqueId=<?php echo htmlspecialchars($uniqueId); ?>" method="post">
                      <div class="d-flex justify-content-around align-items-center mb-4">
                        <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Claim Pending">
                            <input type="checkbox" name="claimPending" id="claimPending" 
                                <?php echo isset($claimStatus['claimPending']) && $claimStatus['claimPending'] === 'yes' ? 'checked' : ''; ?> 
                                onclick="toggleCheckbox('claimPending')">
                            <div class="checkbox-circle">
                                <svg viewBox="0 0 52 52" class="checkmark">
                                    <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                    <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                </svg>
                            </div>
                        </label>
                        <label class="checkbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Claim Clear">
                            <input type="checkbox" name="claimClear" id="claimClear" 
                                <?php echo isset($claimStatus['claimClear']) && $claimStatus['claimClear'] === 'yes' ? 'checked' : ''; ?> 
                                onclick="toggleCheckbox('claimClear')">
                            <div class="checkbox-circle">
                                <svg viewBox="0 0 52 52" class="checkmark">
                                    <circle fill="none" r="25" cy="26" cx="26" class="checkmark-circle"></circle>
                                    <path d="M16 26l9.2 8.4 17.4-21.4" class="checkmark-kick"></path>
                                </svg>
                            </div>
                        </label>
                      </div>
                      <div class="mb-3">
                          <label for="cstatusMessage" class="form-label">Status Message</label>
                          <textarea class="form-control" id="cstatusMessage" name="cstatusMessage"></textarea>
                      </div>
                      <input type="hidden" name="cuniqueId" value="<?php echo htmlspecialchars($uniqueId); ?>">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                   
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Pdf upload modal -->
        <div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="uploadFile" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content rounded-4 bg-dark text-light">
                  <div class="modal-header d-flex justify-content-between">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Report</h1>
                      <button type="button" class="btn text-light rounded-5" data-bs-dismiss="modal" aria-label="Close">
                          <i class="fa-solid fa-xmark"></i>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p class="text-start">Carefully select and upload your payment ledger document. Ensure it contains accurate transaction details.</p>
                      <form id="uploadForm" method="post" enctype="multipart/form-data">
                          <div class="input-group">
                              <input type="file" class="form-control rounded-start-5" name="uploadedFile" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                              <button class="btn btn-outline-primary rounded-end-5" type="submit">Upload</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        </div>

        <!-- Developer Details -->
        <div class="modal fade" id="developerDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-primary text-light">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Developer Contact Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p class="text-start">Contact Number - +91 7319589678, +91 8927981923</p>
                <p class="text-start">Email Id - abhijitdey3322@gmail.com, p.pankaj8927@gmail.com</p>
              </div>
            </div>
          </div>
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

    // Select all buttons with the class 'statusUpdateButton'
    document.querySelectorAll('.statusUpdateButton').forEach(button => {
        button.addEventListener('click', function() {
            // Get the data-orderid attribute from the clicked button
            let orderId = this.getAttribute('data-orderid');
            
            // Get the uniqueId from the URL
            let urlParams = new URLSearchParams(window.location.search);
            let uniqueId = urlParams.get('uniqueId');

            // Make an AJAX request to fetch the order status
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `?action=fetchStatus&uniqueId=${encodeURIComponent(uniqueId)}&orderid=${encodeURIComponent(orderId)}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    // Populate the form with the fetched data
                    document.getElementById('orderid').value = response.orderid;
                    document.querySelector('input[name="orderConfirmed"]').checked = response.orderStatus.order_confirmed == 'yes';
                    document.querySelector('input[name="orderShipped"]').checked = response.orderStatus.order_shipped == 'yes';
                    document.querySelector('input[name="outForDelivery"]').checked = response.orderStatus.out_for_delivery == 'yes';
                    document.querySelector('input[name="orderDelivered"]').checked = response.orderStatus.order_delivered == 'yes';
                } else {
                    console.error('Failed to fetch status');
                }
            };
            xhr.send();
        });
    });

    // function toggleCheckbox(selectedCheckbox) {
    //     const claimPending = document.getElementById('claimPending');
    //     const claimClear = document.getElementById('claimClear');

    //     if (selectedCheckbox === 'claimPending' && claimPending.checked) {
    //         claimClear.checked = false;
    //     }

    //     if (selectedCheckbox === 'claimClear' && claimClear.checked) {
    //         claimPending.checked = false;
    //     }
    // }
    document.addEventListener('DOMContentLoaded', function() {
        // Get all decisionSelect elements and add event listeners
        const decisionSelects = document.querySelectorAll('.decisionSelect');
        
        decisionSelects.forEach(selectElement => {
            selectElement.addEventListener('change', function() {
                // Trigger customOption function when decision changes
                customOption(selectElement);
                // saveChanges(selectElement.dataset.rowId); // Assuming row ID is stored in data attribute
            });
        });

        // Get all stockSelect elements and add event listeners
        const stockSelects = document.querySelectorAll('.stockSelect');
        
        stockSelects.forEach(selectElement => {
            selectElement.addEventListener('change', function() {
                // Trigger updateBackgroundColor function when stock changes
                updateBackgroundColor(selectElement);
                // saveChanges(selectElement.dataset.rowId); // Assuming row ID is stored in data attribute
            });
        });
    });

    function customOption(selectElement) {
        // Find the nearest stockSelect sibling
        const stockSelect = selectElement.closest('.d-flex').querySelector('.stockSelect');
        
        // Clear existing options in the stockSelect
        stockSelect.innerHTML = '';

        // Create and add the default option
        const defaultOption = new Option('Stock', '', true, true);
        defaultOption.className = 'bg-dark text-primary';
        stockSelect.add(defaultOption);

        if (selectElement.value == 'Pending') {
            // Add options for Pending
            const option1 = new Option('No Stock','No Stock');
            const option2 = new Option('Ready To Stock','Ready To Stock');
            const option3 = new Option('Stock Done','Stock Done');
            const option4 = new Option('Complete','Complete');
            option1.className = 'bg-dark text-primary';
            option2.className = 'bg-dark text-primary';
            option3.className = 'bg-dark text-primary';
            option4.className = 'bg-dark text-primary';
            stockSelect.add(option1);
            stockSelect.add(option2);
            stockSelect.add(option3);
            stockSelect.add(option4);
        } else if (selectElement.value == 'Despatch') {
            // Add options for Despatch
            const option5 = new Option('Already Despatch','Already Despatch');
            const option6 = new Option('Complete','Complete');
            option5.className = 'bg-dark text-primary';
            option6.className = 'bg-dark text-primary';
            stockSelect.add(option5);
            stockSelect.add(option6);
        }
    }

    function updateBackgroundColor(selectElement) {
        let color = '';

        // Reset background color before applying the new one
        selectElement.style.backgroundColor = 'transparent';
        selectElement.style.color = 'black';

        // Update background color based on the selected value
        const value = selectElement.value;
        switch (value) {
            case 'No Stock':
                color = 'white';
                selectElement.style.color = 'black'; // Ensure text is readable
                break;
            case 'Ready To Stock':
                color = '#37ABE2';
                break;
            case 'Stock Done':
                color = 'yellow';
                selectElement.style.color = 'black'; // Ensure text is readable
                break;
            case 'Complete':
                color = '#3ECB80';
                break;
            case 'Already Despatch':
                color = 'red';
                selectElement.style.color = 'white'; // Ensure text is readable
                break;
            default:
                color = 'transparent';
                break;
        }

        // Apply the color
        selectElement.style.backgroundColor = color;

        // Update the data-claim-color attribute to the new color
        selectElement.setAttribute('data-claim-color', color);
    }

    var formDataStore = {}; // Global variable to store form data

    function saveChanges(idOfClaim) {
        var buttonSave = document.getElementById('claimStatusSave');
        
        // Show the save button
        buttonSave.classList.remove('d-none');
        buttonSave.classList.add('d-block');

        // Get all select elements with the class decisionSelect and stockSelect
        var batteryStatusSelect = document.querySelector(`.batteryStatusSelect[data-claim-id="${idOfClaim}"]`);
        var decisionSelect = document.querySelector(`.decisionSelect[data-claim-id="${idOfClaim}"]`);
        var stockSelect = document.querySelector(`.stockSelect[data-claim-id="${idOfClaim}"]`);

        // Get the selected values
        var batteryStatusValue = batteryStatusSelect.value;
        var decisionValue = decisionSelect.value;
        var stockValue = stockSelect.value;

        // Get the data-claim-color attribute from stockSelect
        var stockColor = stockSelect.getAttribute('data-claim-color');

        // Store the values in the global object with idOfClaim as the key
        formDataStore[idOfClaim] = {
            batteryStatusValue: batteryStatusValue,
            decisionValue: decisionValue,
            stockValue: stockValue,
            stockColor: stockColor // Add data-claim-color for stock only
        };
    }

    document.querySelectorAll('.decisionSelect, .stockSelect').forEach(select => {
        select.addEventListener('change', function() {
            updateBackgroundColor(this);
            saveChanges(this.getAttribute('data-claim-id'));
        });
    });

    document.getElementById('claimStatusSave').addEventListener('click', function() {
        // Prepare the data to send in the AJAX request
        var formData = new FormData();
        
        formData.append('formDataStore', JSON.stringify(formDataStore)); // Convert the object to JSON

        // AJAX request to update the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'backend/claimStatusUpdate.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('Claim status updated successfully.');
                location.reload();
            } else {
                alert('Error updating claim status.');
                location.reload();
            }
        };
        xhr.send(formData);

        // Optionally, clear the formDataStore after saving
        formDataStore = {};
    });



    // document.getElementById('searchInput').addEventListener('input', function() {
    //   const searchTerm = this.value.toLowerCase();
    //   const cards = document.querySelectorAll('.card');

    //   cards.forEach(card => {
    //     const title = card.querySelector('span').textContent.toLowerCase();
    //     if (title.includes(searchTerm)) {
    //       card.style.display = '';
    //     } else {
    //       card.style.display = 'none';
    //     }
    //   });
    // });
        
  </script>
</body>

</html>