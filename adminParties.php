<?php
session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] !== 'YES') {
    // Redirect to the login page if not logged in as admin
    header("Location: ./adminLogin.php");
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
    /*{border:1px solid red;}
    /* Customize the scrollbar track */
    ::-webkit-scrollbar {height:6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
    .form-control:focus {
      box-shadow: none;
    }
    /* From Uiverse.io by alexmaracinaru */ 
    .card {width: 150px;height: 150px;border-radius: 15px;cursor: pointer;}
    .card span {width:100%;font-weight: 600;color: white;display: block;padding-top: 10px;font-size: 16px;}
    .card p {width:100%;font-weight: 400;color: white;display: block;padding-top: 3px;font-size: 12px;}
    .card .img {width: 50px;height: 50px;border-radius: 50px;margin: auto;overflow: hidden;}
   
  </style>
</head>

<body>
  <!-- As a link -->
  <div class=" m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './adminNav.php';?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10  overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
        <div class="container mt-3 d-flex flex-column flex-wrap justify-content-center align-items-center">
            <!-- section to code not outside  else, if better not to see-->
            <p class="d-none d-lg-flex fw-bold fs-4 text-center">Welcome to Power Friends - Your Ultimate Destination for Batteries!</p>
            <p class="d-flex d-lg-none fw-bold fs-4 text-center">Welcome to<br>Power Friends</p>
            <div class="border border-2 p-1 border-dark rounded-5 input-group mb-3" style="width:90%;">
                <input type="text" id="searchInput" class="rounded-5 border border-0 me-1 form-control"
                    placeholder="Search Customer name here ....." aria-label="Search Customer name here ....."
                    aria-describedby="button-addon2">
                <button class="text-light rounded-5 btn btn-primary" type="button" id="button-addon2"
                    style="width:150px;">Search</button>
            </div>
            <button class="btn btn-primary rounded-5 text-light fw-bold mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              New Orders & Claims
            </button>
            <div class="overflow-auto container-fluid d-flex flex-column flex-wrap justify-content-center m-0 p-0" style="height:calc(100% - 10%);width:100%;">
                <div class="row gap-2 p-0 m-0 d-flex justify-content-center justify-content-lg-start">
                    <!-- <div class="card bg-secondary" data-user="Abhijit Dey" data-uniqueId="123123">
                        <div class="img d-flex justify-content-center border border-1 border-primary">
                            <img class="m-0 p-0" src="./account.png" alt="User Image" style="height:50px;width:50px;object-fit:contain;">
                        </div>
                        <span>Abhijit Dey</span>
                        <p class="contact">Contact Details</p>
                    </div> -->
                    <?php
                      // Query to fetch user details
                      $sql = "SELECT * FROM users";
                      $result = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($result) > 0) {
                          // Output each user as a card
                          while($row = mysqli_fetch_assoc($result)) {
                            $imagePath = htmlspecialchars($row['image']);
                            $defaultImage = './account.png'; // Path to your default demo image
                            $imageToDisplay = (!empty($imagePath) && file_exists($imagePath)) ? $imagePath : $defaultImage;
                              echo '<div class="card bg-secondary" data-user="'.htmlspecialchars($row['name']).'" data-uniqueId="'.htmlspecialchars($row['uniqueId']).'">
                                      <div class="img d-flex justify-content-center border border-2 border-light">
                                          <img class="m-0 p-0 bg-dark" src="'.$imageToDisplay.'" alt="User Image" style="height:50px;width:50px;object-fit:contain;">
                                      </div>
                                      <span class="text-uppercase text-start text-truncate">'.htmlspecialchars($row['name']).'</span>
                                      <p class="text-start text-truncate"><i class="fa-solid fa-phone"></i> - '.htmlspecialchars($row['phone_number']).'</p>
                                    </div>';
                          }
                      } else {
                          echo "No users found.";
                      }
                    ?>
                </div>                
            </div>
        </div>
        <!-- offcanvas side bar view of orders and claim -->
        <div class="offcanvas offcanvas-end bg-dark text-light" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header d-flex justify-content-between">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Orders & Claims</h5>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
            <button type="button" class="btn border-0 text-light fs-5" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
          </div>
          <div class="offcanvas-body w-100" style="height:100%;">
            <div id="orders" class="p-0 m-0 overflow-y-auto"  style="height: 48%; width:100%;">
              <ul>
              <?php
                // Query to fetch orders from the last 30 days
                $Ordsql = "SELECT * FROM orders WHERE orderdate >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ORDER BY id DESC";
                $Ordresult = mysqli_query($conn, $Ordsql);

                if (mysqli_num_rows($Ordresult) > 0) {
                    // Output each user as a card
                    while($row = mysqli_fetch_assoc($Ordresult)) {
                        $orderDetails = $row['name'].'-'.$row['dealer_code'].'  [ '.$row['p_details'].' ]';

                        $userName = $row['name'];
                        $uniqueId = $row['uniqueId'];

                        echo '<li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="'.htmlspecialchars($orderDetails).'">
                                <a href="adminUserDetails.php?user='.$userName.'&uniqueId='.$uniqueId.'" style="width:100px" class="text-decoration-none text-light fw-semibold text-truncate">'
                                .htmlspecialchars($orderDetails).'</a>
                              </li>';
                    }
                } else {
                    echo "No Current Orders in the past 30 days";
                }
              ?>
                <!-- <li><a href="#"  class="text-decoration-none text-light fw-semibold">orders1</a></li> -->
              </ul>
            </div>
            <hr class="p-0 m-2">
            <div id="claims" class="p-0 m-0 overflow-y-auto"  style="height: 48%;">
              <ul>
                <?php
                  // Query to fetch user details
                  $Ordsql = "SELECT * FROM claim_details WHERE claimDate >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ORDER BY id DESC";
                  $Ordresult = mysqli_query($conn, $Ordsql);
                  if (mysqli_num_rows($Ordresult) > 0) {
                      // Output each user as a card
                      while($row = mysqli_fetch_assoc($Ordresult)) {
                        $userName = $row['dealerName'];
                        $uniqueId = $row['uniqueId'];
                        // Extract the dealer code part from the unique ID
                        $dealerCodeParts = explode('-', $uniqueId);
                        $dealerCodeLastNumber = end($dealerCodeParts);

                        $orderDetails = $row['dealerName'] . ' - ' . $dealerCodeLastNumber . ' [ Battery Type: ' . $row['batteryType'] . ' - Serial Number ' . $row['serialNo'] . ' - Date of Sale ' . $row['dateOfSale'] . ' ]';

                        echo '<li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="'.htmlspecialchars($orderDetails).'">
                                <a href="adminUserDetails.php?user='.$userName.'&uniqueId='.$uniqueId.'" style="width:100px" class="text-decoration-none text-light fw-semibold text-truncate">'
                                .htmlspecialchars($orderDetails).'</a>
                              </li>';
                      }
                  } else {
                      echo "No Currect Order past 30 days";
                  }
                ?>
                <!-- <li><a href="#"  class="text-decoration-none text-light fw-semibold">claim1</a></li> -->
              </ul>
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
    
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const cards = document.querySelectorAll('.card');

      cards.forEach(card => {
        const title = card.querySelector('span').textContent.toLowerCase();
        if (title.includes(searchTerm)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var cards = document.querySelectorAll('.card');
    
        cards.forEach(function(card) {
            card.addEventListener('click', function() {
                var userName = card.getAttribute('data-user');
                var uniqueId = card.getAttribute('data-uniqueId');
    
                // Redirect to the details page with query parameters
                window.location.href = `adminUserDetails.php?user=${encodeURIComponent(userName)}&uniqueId=${encodeURIComponent(uniqueId)}`;
            });
        });
    });
    

    
  </script>
</body>

</html>