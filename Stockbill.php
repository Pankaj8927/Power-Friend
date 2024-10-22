<?php
  session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Include resetOrderStatus.php and capture the return value
// include 'backend/resetOrderStatus.php';
//reset order status after order delivered


// Ensure the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get uniqueId from URL or request
// $uniqueId = isset($_GET['uniqueId']) ? $conn->real_escape_string($_GET['uniqueId']) : '';
// $uniqueId = 'powerfriend-ABHIJIT DEY-12312312';
// Check if 'unique_id' is set in the session
if (!isset($_SESSION['unique_id'])) {
  echo '<script type="text/javascript">if (confirm("Error: You\'re not logged in. Do you want to go to the registration page?")) {window.location.href = "./register.php";}else{window.location.href = "./index.php";}</script>';
  exit();
} else {
  $uniqueId = $_SESSION['unique_id'];
}

$status = 'Status'; // Default status
$progressWidth = '0%'; // Default progress bar width
$statusMessage = "Status Message from Power Friend";
if (!empty($uniqueId)) {
  // Fetch the status from the database
  $sql = "SELECT statusMessage, order_confirmed, order_shipped, out_for_delivery, order_delivered, file_path  FROM orders WHERE uniqueId = '$uniqueId' ORDER BY id DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $orderConfirmed = $row['order_confirmed'];
      $orderShipped = $row['order_shipped'];
      $outForDelivery = $row['out_for_delivery'];
      $orderDelivered = $row['order_delivered'];
      //status Message
      $statusMessage = $row['statusMessage'];
      $file_path = $row['file_path'];

      // Calculate the count of 'yes' values
      $yesCount = 0;
      if ($orderConfirmed === 'yes') $yesCount++;
      if ($orderShipped === 'yes') $yesCount++;
      if ($outForDelivery === 'yes') $yesCount++;
      if ($orderDelivered === 'yes') $yesCount++;

      // Determine the status, progress, and highlighted classes based on the count of 'yes' values
      switch ($yesCount) {
          case 4:
              $status = 'Order Delivered';
              $progressWidth = '100%';
              $highlighted = [
                  'order_confirmed' => 'text-primary',
                  'order_shipped' => 'text-primary',
                  'out_for_delivery' => 'text-primary',
                  'order_delivered' => 'text-primary'
              ];
              break;
          case 3:
              $status = 'Out for Delivery';
              $progressWidth = '83%';
              $highlighted = [
                  'order_confirmed' => 'text-primary',
                  'order_shipped' => 'text-primary',
                  'out_for_delivery' => 'text-primary',
                  'order_delivered' => 'text-body-tertiary'
              ];
              break;
          case 2:
              $status = 'Order Shipped';
              $progressWidth = '66%';
              $highlighted = [
                  'order_confirmed' => 'text-primary',
                  'order_shipped' => 'text-primary',
                  'out_for_delivery' => 'text-body-tertiary',
                  'order_delivered' => 'text-body-tertiary'
              ];
              break;
          case 1:
              $status = 'Order Confirmed';
              $progressWidth = '33%';
              $highlighted = [
                  'order_confirmed' => 'text-primary',
                  'order_shipped' => 'text-body-tertiary',
                  'out_for_delivery' => 'text-body-tertiary',
                  'order_delivered' => 'text-body-tertiary'
              ];
              break;
          default:
              $status = 'Pending';
              $progressWidth = '0%';
              $highlighted = [
                  'order_confirmed' => 'text-body-tertiary',
                  'order_shipped' => 'text-body-tertiary',
                  'out_for_delivery' => 'text-body-tertiary',
                  'order_delivered' => 'text-body-tertiary'
              ];
              break;
      }
  }
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
    ::-webkit-scrollbar {height: 6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
    .progress-container {width: 100%;height: 10px;background-color: #e9ecef;border-radius: 5px;overflow: hidden;position: relative;z-index: 1;}
    .progress-bar {height: 100%;background-color: #FF204E;width: 0%;border-radius: 5px;transition: width 0.4s ease;}
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
          <p class="m-0 p-0 fw-bold fs-3 text-start">Order Details</p><br>
          <p class="m-0 p-0 fs-5">Provide payments details at the showroom. Any due payments will be settle there just
            give your name as entered during regestration to proceed.
          <button class="btn btn-primary" type="button"><a class="text-light text-decoration-none" href="<?php echo $file_path;?>" download>Download PDF</a></button>
          </p>
        </div>
        <!-- alart -->
        <br>
        <br>
        <div id="closeableDiv" class="p-2 position-relative text-center text-mutedbg-body border border-dark rounded-4 w-100 mb-4">
            <?php echo '<h3 class="w-100 text-dark ">' . $status . ' Releted Message</h3>';?><?php echo '<p class="w-100 mb-4 text-secondary fw-semibold ">' . $statusMessage . '</p>';?>
        </div>

        <!-- user all orders -->
        <button id="allorders"class="btn btn-primary m-2 fw-semibold text-light text-center"style="">All Orders <i class="fa-solid fa-arrow-down-short-wide"></i></button>
        <div id="ordersTable"class="overflow-auto container-fluid d-none flex-column flex-wrap justify-content-center m-0 p-0" style="width:100%;height:auto;">
          <table class="table">
            <thead class="table-dark position-static top-0">
                <tr>
                    <th scope="col" style="border-top-left-radius: 10px;">Order No.</th>
                    <th scope="col">Order Date</th>
                    <th colspan="3" scope="col">Products Details</th>
                    <th scope="col" style="border-top-right-radius: 10px;">Products Details</th>
                </tr>
            </thead>
            <tbody>
              <?php
                  // Get the uniqueId from the URL
                  if ($uniqueId) {
                    // Query to fetch orders for the specific uniqueId
                    $Ordsql = "SELECT * FROM orders WHERE uniqueId = '$uniqueId' ORDER BY id DESC";
                    $Ordresult = mysqli_query($conn, $Ordsql);
                    if (mysqli_num_rows($Ordresult) > 0) {
                        // Output each order as a card
                        $slNo = 1;
                        while($row = mysqli_fetch_assoc($Ordresult)) {
                            $orderDetails = $row['p_details'];
                            $orderdate = $row['orderdate'];
                            echo '
                              <tr>
                                  <th scope="row" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$slNo .'</th>
                                  <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$orderdate.'</td>
                                  <td colspan="3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$orderDetails.'</td>
                                  <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color:white; text-align:center;font-weight:700;background:#FF204E;border-radius">'.$row['status'].'</td>
                              </tr>';
                              $slNo ++;
                        }
                    } else {
                        echo '<h6 class="my-0 text-center">No Order Available!</h6>';
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
      document.getElementById('allorders').addEventListener('click', function () {
          let element = document.getElementById('ordersTable');
          if (element.classList.contains('d-none')) {
              element.classList.remove('d-none');
              element.classList.add('d-flex');
          } else {
              element.classList.remove('d-flex');
              element.classList.add('d-none');
          }
      });


    </script>
</body>

</html>