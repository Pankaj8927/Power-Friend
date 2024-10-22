<?php
  session_start();
  // Database connection
    $conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
  // include 'sessionClose.php';
  if (!isset($_SESSION['unique_id'])) {
    echo '<script type="text/javascript">if (confirm("Error: You\'re not logged in. Do you want to go to the registration page?")) {window.location.href = "./register.php";}else{window.location.href = "./index.php";}</script>';
    exit();
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
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Outfit:wght@100..900&family=Pacifico&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <style>
    /**{border:1px solid red;}*/
    /* Customize the scrollbar track */
    ::-webkit-scrollbar {height:6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
  </style>
</head>

<body>
  <!-- As a link -->
  <div class=" m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './userNav.php'; ?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10  overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
      <div class="container mt-3 d-flex flex-column flex-wrap justify-content-center align-items-center">
        <!-- section to code not outside  else, if better not to see-->

        <div class="m-0 p-0 d-flex flex-column align-items-center align-items-lg-start mb-4">
          <p class="m-0 p-0 fw-bold fs-3 text-start">Claim Form</p><br>
          <p class="m-0 p-0 fs-5">Complete the Claim Form by entering the required details. Review your information carefully before submission. Click 'Claims Details' for additional instructions or to view your previous claims.
            <a type="button" class="btn btn-primary text-light  fw-semibold" data-bs-toggle="modal" data-bs-target="#claimDetails">Claims Details</a>
          </p>
        </div>
        <div class="row gx-3 gy-2 align-items-center" id="claimForm">
          <div class="col-sm-3">
              <?php
                $newClaimNo = '';
                $sql = "SELECT claimNo FROM claim_details ORDER BY claimNo DESC LIMIT 1";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $latestClaimNo = (int)$row['claimNo'];
                    $newClaimNo = $latestClaimNo + 1;
                } else {
                    $newClaimNo = 1;
                }
              ?>
              <div class="input-group">
                  <span class="input-group-text shadow" id="basic-addon1">Claim No.</span>
                  <input type="number" class="form-control shadow" value="<?php echo $newClaimNo; ?>" id="claimNo" placeholder="0" required>
              </div>
          </div>
          <div class="col-sm-3">
              <input type="datetime-local" class="form-control shadow" id="dateTime" placeholder="Date and Time" required>
          </div>
          <?php
            // Initialize variables
            $dealerName = '';
            $address = '';

            if (isset($_SESSION['unique_id'])) {
                $uniqueId = $_SESSION['unique_id'];
                $claimsql = "SELECT * FROM users WHERE uniqueId = '$uniqueId'";
                $result = $conn->query($claimsql);

                if ($result === false) {
                    // Output the SQL error
                    echo 'Error: ' . $conn->error;
                } else {
                    // Check if there are any rows
                    if ($result->num_rows > 0) {
                        // Fetch user data
                        $user = $result->fetch_assoc();
                        $dealerName = htmlspecialchars($user['name']);
                        $address = htmlspecialchars($user['address']);
                    }
                }
            }
            else {
              echo "<script>
                  if (confirm(\"Error: You're not logged in. Do you want to go to the registration page?\")) {
                      window.location.href = './register.php';
                  }
              </script>";
            }
          ?>
          <div class="col-sm-3">
              <input type="text" class="form-control shadow" id="dealerName" value="<?php echo $dealerName;?>"placeholder="Dealer Name" required> 
          </div>
          <div class="col-sm-3">
              <input type="text" class="form-control shadow" id="address" value="<?php echo $address;?>"placeholder="Address" required>
          </div>
          <div id="addedProductsContainer" class="col container-fluid d-flex flex-column flex-wrap justify-content-center align-items-center mt-4 m-0 p-0" style="width:100%;height:auto;">
              <!-- Default Product Item Form -->
              <div class="productItem d-flex flex-column justify-content-center align-items-center">
                  <form class="row g-2 mb-2 border-bottom border-primary productForm">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
                        <input type="text" class="m-2 form-control shadow customerName" placeholder="Customer Name" style="height: 30px;" required>
                        <input type="text" class="m-2 form-control shadow pinCode" placeholder="Pin Code" style="height: 30px;" required>
                        <input type="text" class="m-2 form-control shadow contactNo" placeholder="Contact No." style="height: 30px;" required>
                        <input type="text" class="m-2 form-control shadow batteryType" placeholder="Battery Type" style="height: 30px;" required>
                        <input type="text" class="m-2 form-control shadow serialNo" placeholder="Serial No." style="height: 30px;" required>
                        <input type="date" class="m-2 form-control shadow dateOfSale" placeholder="Date of Sale" style="height: 30px;" required>
                        <input type="text" class="m-2 form-control shadow ticketsNo" placeholder="Tickets No." style="height: 30px;">
                        <input type="text" class="m-2 form-control shadow remarks" placeholder="Remarks" style="height: 30px;">
                        <input type="text" class="m-2 form-control shadow replacement" placeholder="Replacement" style="height: 30px;">
                        <input type="text" class="m-2 form-control shadow slno" placeholder="Sl No" style="height: 30px;">
                        <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button>
                    </div>
                  </form>
              </div>
          </div>
          <div class="col-12 d-flex justify-content-center mb-4" style="width:100%;">
              <button type="button" class="mt-4 col-12 col-lg-5 rounded-5 text-light fw-bold btn btn-primary submitProduct">Upload</button>
          </div>
        </div>

      </div>
      <!-- Modal -->
      <div class="modal fade" id="claimDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Claim Details</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="overflow-auto container-fluid d-flex flex-column flex-wrap justify-content-center m-0 p-0" style="width:100%;height:auto;">
              <table class="table">
                <thead class="table-dark position-static top-0">
                    <tr>
                        <th scope="col" style="border-top-left-radius: 10px;">Claim No.</th>
                        <th scope="col">Claim Date</th>
                        <th scope="col">Customer Details</th>
                        <th scope="col">Product Details</th>
                        <th scope="col">Battery Status</th>
                        <th scope="col">Decision</th>
                        <th colspan="3" scope="col" style="border-top-right-radius: 10px;">Stock Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    // Get the uniqueId from the URL or some other source
                    if ($uniqueId) {
                        // Query to fetch claims for the specific uniqueId
                        $claimSql = "SELECT * FROM claim_details WHERE uniqueId = '$uniqueId' ORDER BY id DESC";
                        $claimResult = mysqli_query($conn, $claimSql);
                        if (mysqli_num_rows($claimResult) > 0) {
                            // Output each claim as a row in the table
                            $slNo = 1;
                            while($row = mysqli_fetch_assoc($claimResult)) {
                                $claimDate = $row['claimDate']; // Replace with the appropriate column name
                                $customerDetails = $row['customerName'] . ' / ' . $row['cPinCode'] . ' / ' . $row['cContactNumber'];
                                $productDetails = $row['batteryType'] . ' / ' . $row['serialNo'] . ' / ' . $row['dateOfSale'];
                                $decision = $row['decision_status'];
                                $stock = $row['stock_status'];
                                $batteryStatus = $row['battery_status'];

                                echo '
                                  <tr>
                                      <th scope="row" class="text-truncate">'.$slNo.'</th>
                                      <td class="text-truncate">'.$claimDate.'</td>
                                      <td class="text-truncate">'.$customerDetails.'</td>
                                      <td class="text-truncate">'.$productDetails.'</td>
                                      <td class="text-truncate">'.$batteryStatus.'</td>
                                      <td class="text-truncate fw-semibold" style="background-color:'.$row['color'].';">'.$decision.'</td>
                                      <td class="text-truncate fw-semibold" style="background-color:'.$row['color'].';">' . htmlspecialchars($stock) . '</td>
                                  </tr>';
                                $slNo++;
                            }
                        } else {
                            echo '<h6 class="my-0 text-center">No Claims Available!</h6>';
                        }
                    } else {
                        echo '<h6 class="my-0 text-center">No uniqueId provided.</h6>';
                    }
                  ?>
                </tbody>
              </table>    
            </div>
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
    function AddProductItems() {
        var addedProductsContainer = document.getElementById('addedProductsContainer');
        //var buttonContainer = document.getElementById('ADDBUTTON');
    
        // Create a new product item element
        var addedProducts = document.createElement('div');
        addedProducts.className = "productItem d-flex flex-column justify-content-center align-items-center";
        addedProducts.innerHTML = `
            <form class="row g-2 mb-2 border-bottom border-primary productForm">
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
                  <input type="text" class="m-2 form-control shadow customerName" placeholder="Customer Name" style="height: 30px;" required>
                  <input type="text" class="m-2 form-control shadow pinCode" placeholder="Pin Code" style="height: 30px;" required>
                  <input type="text" class="m-2 form-control shadow contactNo" placeholder="Contact No." style="height: 30px;" required>
                  <input type="text" class="m-2 form-control shadow batteryType" placeholder="Battery Type" style="height: 30px;" required>
                  <input type="text" class="m-2 form-control shadow serialNo" placeholder="Serial No." style="height: 30px;" required>
                  <input type="date" class="m-2 form-control shadow dateOfSale" placeholder="Date of Sale" style="height: 30px;" required>
                  <input type="text" class="m-2 form-control shadow ticketsNo" placeholder="Tickets No." style="height: 30px;">
                  <input type="text" class="m-2 form-control shadow remarks" placeholder="Remarks" style="height: 30px;">
                  <input type="text" class="m-2 form-control shadow replacement" placeholder="Replacement" style="height: 30px;">
                  <input type="text" class="m-2 form-control shadow slno" placeholder="Sl No" style="height: 30px;">
                  <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button>
              </div>
            </form>
        `;
    
        // Append the new product item to the container without removing existing ones
        addedProductsContainer.appendChild(addedProducts);
        // Ensure the main "ADD" button stays at the end
        //buttonContainer.innerHTML = `<button type="button" class="mt-4 w-100 rounded-5 text-light fw-bold btn btn-primary submitProduct">Upload</button>`;
        //addedProducts.appendChild(buttonContainer);
    }
    document.querySelector('.submitProduct').addEventListener('click', function(event) {
        // Prevent form submission if there are validation errors
        event.preventDefault();

        // Collect main form data
        var claimNo = document.getElementById('claimNo').value;
        var dateTime = document.getElementById('dateTime').value;
        var dealerName = document.getElementById('dealerName').value;
        var address = document.getElementById('address').value;

        // Check if main form fields are empty and display an error
        if (!claimNo || !dateTime || !dealerName || !address) {
            alert("Please fill all required main form fields.");
            return; // Stop the function if any required field is missing
        }

        var productData = [];
        var productForms = document.querySelectorAll('.productForm');
        var formIsValid = true; // A flag to track if all required fields are valid

        productForms.forEach(function(form) {
            var customerName = form.querySelector('.customerName').value;
            var pinCode = form.querySelector('.pinCode').value;
            var contactNo = form.querySelector('.contactNo').value;
            var batteryType = form.querySelector('.batteryType').value;
            var serialNo = form.querySelector('.serialNo').value;
            var dateOfSale = form.querySelector('.dateOfSale').value;

            // Validate required fields
            if (!customerName || !pinCode || !contactNo || !batteryType || !serialNo || !dateOfSale) {
                formIsValid = false;
                form.classList.add('border-danger'); // Optional: Highlight the invalid form
            } else {
                form.classList.remove('border-danger');
            }

            var formData = {
                customerName: customerName,
                pinCode: pinCode,
                contactNo: contactNo,
                batteryType: batteryType,
                serialNo: serialNo,
                dateOfSale: dateOfSale,
                // Optional fields
                ticketsNo: form.querySelector('.ticketsNo').value,
                remarks: form.querySelector('.remarks').value,
                replacement: form.querySelector('.replacement').value,
                slno: form.querySelector('.slno').value
            };
            productData.push(formData);
        });

        // Stop if validation fails
        if (!formIsValid) {
            alert("Please fill all required product fields.");
            return;
        }

        var dataToSend = {
            claimNo: claimNo,
            dateTime: dateTime,
            dealerName: dealerName,
            address: address,
            productData: productData
        };

        // Send data via AJAX
        fetch('backend/addClaim.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            // Handle response (e.g., show a success message)
            if (data.messages && data.messages.length > 0) {
                alert('Success: ' + data.messages.join('\n')); // Join messages with newline
                location.reload();
            }
            if (data.errors && data.errors.length > 0) {
                alert('Errors: ' + data.errors.join('\n')); // Join errors with newline
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });




  </script>
</body>

</html>