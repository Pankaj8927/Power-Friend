<?php
  session_start();
 // Database connection
  $conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  // include 'sessionClose.php';
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
    .input-group .form-control::-webkit-inner-spin-button,
    .input-group .form-control::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
  </style>
</head>

<body>
  <!-- As a link -->
  <div class=" m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './userNav.php'; ?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10  overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
      <div class="container mt-3 d-flex flex-column flex-column justify-content-center align-items-center"
        style="height:95%">
        <!-- section to code not outside  else, if better not to see-->
        <div class="m-0 p-0 d-flex flex-column align-items-center align-items-lg-start mb-4">
          <p class="m-0 p-0 fw-bold fs-3 text-start">Add To Cart.</p><br>
          <p class="m-0 p-0 fs-5">To get the products, visits our showroom. you don't need mention the products you
            add.Smiply provide our name as enter during registration and we'll have your selection ready for you.</p>
        </div>
        <!-- Add this new div inside the main container -->
        <div id="emptyCartMessage"
          class="alert alert-info text-center justify-content-center align-items-center text-center d-none h-40"
          role="alert">
          <strong><i class="fa-solid fa-cart-plus"></i>&nbsp;&nbsp;&nbsp;No products in your cart.</strong> Add items to
          see them here.
        </div>
        <div class="overflow-auto productContener mb-4 w-100" style="height:60%;">
          <?php
            // Check if session 'unique_id' is set
            if (isset($_SESSION['unique_id'])) {
              $uniqueId = $_SESSION['unique_id']; // Get the uniqueId from session

              // Escape the uniqueId to prevent SQL injection
              $uniqueId = $conn->real_escape_string($uniqueId);

              // Query to select all items from the orders table where uniqueId matches the session unique_id
              $query = "SELECT * FROM addtocart WHERE uniqueId = '$uniqueId'";
              $result = $conn->query($query);

              // Check if there are any results
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      $id = htmlspecialchars($row['id']);
                      $category = htmlspecialchars($row['category']);
                      $productCode = htmlspecialchars($row['productCode']);
                      $warranty = htmlspecialchars($row['warranty']);
                      $quantity = htmlspecialchars($row['quantity']);
                      ?>
                      <div class="alert alert-dismissible fade show rounded-5 bg-dark-subtle p-2 d-flex align-items-center justify-content-between" role="alert">
                          <button type="button" class="btn text-primary p-0 d-flex align-items-center justify-content-center rounded-5 bg-primary text-light" style="width:40px; height: 40px;">
                              <i class="fa-solid fa-cart-plus"></i>
                          </button>
                          <div class="m-0 p-0 d-flex flex-row align-items-center" style="width: calc(100% - 90px);">
                              <p class="productItems muted mx-2 my-0 text-start text-primary text-truncate"
                                  data-id="<?php echo $id; ?>" data-cat="<?php echo $category; ?>" data-code="<?php echo $productCode; ?>" data-war="<?php echo $warranty; ?>" 
                                  style=" height: calc(100% - 45px);width:calc(100% - 45px - 45px -  50px);" 
                                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" 
                                  data-bs-title="Product: <?php echo $category; ?> - Code: <?php echo $productCode; ?> - Warranty: <?php echo $warranty; ?>">

                                  Product: <?php echo $category; ?> - Code: <?php echo $productCode; ?> - Warranty: <?php echo $warranty; ?>
                              </p>
                              <div class="col-md-3 col-lg-3 col-xl-2 d-flex align-items-center">
                                  <div class="input-group">
                                      <!-- Decrement Button -->
                                      <button class="btn border-0" type="button" id="decrement"><i class="fas fa-minus"></i></button>
                                      <!-- Input Field -->
                                      <input class="form-control orderQuantity rounded-5 text-center" 
                                            min="1" 
                                            max="<?php echo $quantity; ?>" 
                                            type="number" 
                                            placeholder="0" 
                                            data-max="<?php echo $quantity; ?>">
                                      <!-- Increment Button -->
                                      <button class="btn border-0" type="button" id="increment"><i class="fas fa-plus"></i></button>
                                  </div>
                              </div>

                          </div>
                          <button type="button" class="fs-4 btn text-primary p-0 d-flex align-items-center justify-content-center rounded-5 bg-primary text-light" style="width:40px; height: 40px;" data-bs-dismiss="alert" aria-label="Close">
                              <i class="m-0 text-light fa-solid fa-xmark"></i>
                          </button>
                      </div>
                      <?php
                  }
              } else {
                  echo "<script>
                    document.getElementById('emptyCartMessage').classList.remove('d-none');
                    document.getElementById('emptyCartMessage').classList.add('d-block');
                  </script>";
              }
          
              // Close the connection
              $conn->close();
            } else {
              echo "<script>
                  if (confirm(\"Error: You're not logged in. Do you want to go to the registration page?\")) {
                      window.location.href = 'register.php';
                  }
              </script>";
            }
          ?>
          <!-- <div
            class="alert alert-dismissible fade show rounded-5 bg-dark-subtle p-2 d-flex align-items-center justify-content-between"
            role="alert">
            <div class="m-0 p-0 d-flex flex-row align-items-center" style="width: calc(100% - 40px);">
              <button type="button"
                class="fs-4 btn text-primary p-0 d-flex align-items-center justify-content-center rounded-5 bg-primary text-light"
                style="width:40px; height: 40px;">
                <i class="fa-solid fa-cart-plus"></i>
              </button>
              <p class="muted mx-2 my-0 text-start text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolorum, suscipit. Quaerat cumque ad aperiam incidunt, animi quam debitis maxime repudiandae est similique velit natus sapiente harum consequuntur ducimus saepe porro."
                style="width:calc((100% - 40px) - 90px);white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                Thank you for adding this product.</p>

              <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-4"
                  onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                  <i class="fas fa-minus"></i>
                </button>

                <input min="0" value="1" type="number" class="orderQuantity form-control"placeholder="0" >

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-4"
                  onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <button type="button"
              class="fs-4 btn text-primary p-0 d-flex align-items-center justify-content-center rounded-5 bg-primary text-light"
              style="width:40px; height: 40px;" data-bs-dismiss="alert" aria-label="Close">
              <i class="m-0 text-light fa-solid fa-xmark"></i>
            </button>
          </div> -->
        </div>
        <div class=" m-0 p-0 d-flex justify-content-between w-100">
          <p class="text-start fw-bold fs-4">Total Quantity- <span id="quantity"></span></p>
          <button type="button" onclick="booknow()" class="btn btn-primary btn-lg text-light fw-bold"><i
              class="fa-solid fa-calendar-check"></i> Book Now</button>
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
    document.addEventListener('DOMContentLoaded', () => {
        function updateTotalQuantity() {
            let totalQuantity = 0;
            document.querySelectorAll('.orderQuantity').forEach(input => {
                const value = parseInt(input.value) || 0;
                totalQuantity += value;
            });
            document.getElementById('quantity').textContent = totalQuantity;
        }

        // Add event listeners to all quantity inputs
        document.querySelectorAll('.orderQuantity').forEach(input => {
            // Update input value to ensure it's within min and max limits
            input.addEventListener('input', () => {
                const min = parseInt(input.getAttribute('min'));
                const max = parseInt(input.getAttribute('data-max'));
                let value = parseInt(input.value) || 0;

                if (value < min) value = min;
                if (value > max) value = max;

                input.value = value;
                updateTotalQuantity();
            });

            // Initialize max attribute
            const max = parseInt(input.getAttribute('data-max'));
            input.setAttribute('max', max);
        });

        // Increment and decrement buttons functionality
        document.querySelectorAll('.input-group').forEach(group => {
            const input = group.querySelector('.orderQuantity');
            const incrementButton = group.querySelector('#increment');
            const decrementButton = group.querySelector('#decrement');

            if (incrementButton) {
                incrementButton.addEventListener('click', () => {
                    let currentValue = parseInt(input.value) || 0;
                    const maxValue = parseInt(input.getAttribute('data-max'));

                    if (currentValue < maxValue) {
                        input.value = currentValue + 1;
                        updateTotalQuantity();
                    }
                });
            }

            if (decrementButton) {
                decrementButton.addEventListener('click', () => {
                    let currentValue = parseInt(input.value) || 0;
                    const minValue = parseInt(input.getAttribute('min'));

                    if (currentValue > minValue) {
                        input.value = currentValue - 1;
                        updateTotalQuantity();
                    }
                });
            }
        });

        // Initial total quantity calculation
        updateTotalQuantity();
    });
    function booknow() {
    // Get all elements with the class 'productItems'
    var elements = document.querySelectorAll('.productItems');
    var inputs = document.querySelectorAll('.orderQuantity');

    // Check if both elements and inputs are found
    if (elements.length === 0 || inputs.length === 0) {
        alert('No element with class \'productItems\' or input fields found.');
        return;
    }

    // Check if the number of elements matches the number of inputs
    if (elements.length !== inputs.length) {
        alert('Mismatch between the number of product items and input fields.');
        return;
    }

    // Create an array of objects with text content and input values
    var data = Array.from(elements).map((element, index) => ({
        id: element.getAttribute('data-id'), // Get the data-id attribute
        category: element.getAttribute('data-cat'), // Get the data-cat attribute
        code: element.getAttribute('data-code'), // Get the data-code attribute
        warranty: element.getAttribute('data-war'), // Get the data-war attribute
        textContent: element.textContent.trim(),
        quantity: parseInt(inputs[index].value) || 0
    }));

    // Send the data via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/addOrders.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle the response from the server
                alert('Order successfully submitted.');
                location.reload();
            } else {
                alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
                console.error('Response Text:', xhr.responseText);
            }
        }
    };

    // Send the JSON string
    xhr.send(JSON.stringify(data));
}



  </script>
</body>

</html>