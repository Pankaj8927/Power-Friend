<?php
  session_start();
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

  // include 'sessionClose.php';
  // Fetch all details from the products table
  // $sql = "SELECT id, title, description FROM products ORDER BY id DESC";
  $sql = "SELECT id, category, productCode, warranty, quantity FROM products ORDER BY id DESC";
  $result = $conn->query($sql);
?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if session 'unique_id' is set
  if (isset($_SESSION['unique_id'])) {
      // Get the POST data
      $productCode = $_POST['productCode'];
      $category = $_POST['category'];
      $warranty = $_POST['warranty'];
      $quantity = $_POST['quantity'];
      $uniqueId = $_SESSION['unique_id']; // Get the uniqueId from session

      // Insert into orders table without using a prepared statement
      $AddToCartsql = "INSERT INTO addtocart (uniqueId, category, productCode, warranty, quantity, orderDate) 
              VALUES ('$uniqueId', '$category', '$productCode', '$warranty', '$quantity', NOW())";

      if ($conn->query($AddToCartsql) === TRUE) {
          echo "Success";
      } else {
          echo "Error: " . $conn->error;
      }

      // Close the connection
      $conn->close();
      exit(); // Stop further processing as the request was handled via AJAX
  } else {
      // If session 'unique_id' is not set, return an error message
      echo "Error: Unauthorized access or You'r not logged in.";
      exit(); // Stop further processing
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
    ::-webkit-scrollbar {height:6px;width: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #FF204E;border-radius: 6px;}
    ::-webkit-scrollbar-track {background-color: #00224D;border-radius: 6px;}
    /* From Uiverse.io by Satwinder04 */ 
    /* Input container */
    .input-container {position: relative;margin: 20px;}
    /* Input field */
    .input-field {display: block;width: 100%;padding: 10px;font-size: 16px;border: none;border-bottom: 2px solid #ccc;outline: none;background-color: transparent;}
    /* Input label */
    .input-label {position: absolute;top: 0;left: 0;font-size: 16px;color: rgba(204, 204, 204, 0);pointer-events: none;transition: all 0.3s ease;}
    /* Input highlight */
    .input-highlight {position: absolute;bottom: 0;left: 0;height: 2px;width: 0;background-color: #FF204E;transition: all 0.3s ease;}
    /* Input field:focus styles */
    .input-field:focus + .input-label {top: -20px;font-size: 12px;color: #FF204E;}
    .input-field:focus + .input-label + .input-highlight {width: 100%;}
    .loader-container{opacity: 1;transition: opacity 0.5s ease;position:fixed;top:0;left:0;height:100%;width:100%;z-index:100;background-color:#e8e8e8}.loader{--duration:3s;--primary:#FF204E;--primary-light:##FF204E;--primary-rgba:rgba(39, 94, 254, 0);width:200px;height:320px;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);transform-style:preserve-3d}@media (max-width:480px){.loader{zoom:.44}}.loader:before,.loader:after{--r:20.5deg;content:"";width:320px;height:140px;position:absolute;right:32%;bottom:-11px;background:#e8e8e8;transform:translateZ(200px) rotate(var(--r));-webkit-animation:mask var(--duration) linear forwards infinite;animation:mask var(--duration) linear forwards infinite}.loader:after{--r:-20.5deg;right:auto;left:32%}.loader .ground{position:absolute;left:-50px;bottom:-120px;transform-style:preserve-3d;transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}.loader .ground div{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(0);width:200px;height:200px;background:var(--primary);background:linear-gradient(45deg,var(--primary) 0%,var(--primary) 50%,var(--primary-light) 50%,var(--primary-light) 100%);transform-style:preserve-3d;-webkit-animation:ground var(--duration) linear forwards infinite;animation:ground var(--duration) linear forwards infinite}.loader .ground div:before,.loader .ground div:after{--rx:90deg;--ry:0deg;--x:44px;--y:162px;--z:-50px;content:"";width:156px;height:300px;opacity:0;background:linear-gradient(var(--primary),var(--primary-rgba));position:absolute;transform:rotateX(var(--rx)) rotateY(var(--ry)) translate(var(--x),var(--y)) translateZ(var(--z));-webkit-animation:ground-shine var(--duration) linear forwards infinite;animation:ground-shine var(--duration) linear forwards infinite}.loader .ground div:after{--rx:90deg;--ry:90deg;--x:0;--y:177px;--z:150px}.loader .box{--x:0;--y:0;position:absolute;-webkit-animation:var(--duration) linear forwards infinite;animation:var(--duration) linear forwards infinite;transform:translate(var(--x),var(--y))}.loader .box div{background-color:var(--primary);width:48px;height:48px;position:relative;transform-style:preserve-3d;-webkit-animation:var(--duration) ease forwards infinite;animation:var(--duration) ease forwards infinite;transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}.loader .box div:before,.loader .box div:after{--rx:90deg;--ry:0deg;--z:24px;--y:-24px;--x:0;content:"";position:absolute;background-color:inherit;width:inherit;height:inherit;transform:rotateX(var(--rx)) rotateY(var(--ry)) translate(var(--x),var(--y)) translateZ(var(--z));filter:brightness(var(--b,1.2))}.loader .box div:after{--rx:0deg;--ry:90deg;--x:24px;--y:0;--b:1.4}.loader .box.box0{--x:-220px;--y:-120px;left:58px;top:108px}.loader .box.box1{--x:-260px;--y:120px;left:25px;top:120px}.loader .box.box2{--x:120px;--y:-190px;left:58px;top:64px}.loader .box.box3{--x:280px;--y:-40px;left:91px;top:120px}.loader .box.box4{--x:60px;--y:200px;left:58px;top:132px}.loader .box.box5{--x:-220px;--y:-120px;left:25px;top:76px}.loader .box.box6{--x:-260px;--y:120px;left:91px;top:76px}.loader .box.box7{--x:-240px;--y:200px;left:58px;top:87px}.loader .box0{-webkit-animation-name:box-move0;animation-name:box-move0}.loader .box0 div{-webkit-animation-name:box-scale0;animation-name:box-scale0}.loader .box1{-webkit-animation-name:box-move1;animation-name:box-move1}.loader .box1 div{-webkit-animation-name:box-scale1;animation-name:box-scale1}.loader .box2{-webkit-animation-name:box-move2;animation-name:box-move2}.loader .box2 div{-webkit-animation-name:box-scale2;animation-name:box-scale2}.loader .box3{-webkit-animation-name:box-move3;animation-name:box-move3}.loader .box3 div{-webkit-animation-name:box-scale3;animation-name:box-scale3}.loader .box4{-webkit-animation-name:box-move4;animation-name:box-move4}.loader .box4 div{-webkit-animation-name:box-scale4;animation-name:box-scale4}.loader .box5{-webkit-animation-name:box-move5;animation-name:box-move5}.loader .box5 div{-webkit-animation-name:box-scale5;animation-name:box-scale5}.loader .box6{-webkit-animation-name:box-move6;animation-name:box-move6}.loader .box6 div{-webkit-animation-name:box-scale6;animation-name:box-scale6}.loader .box7{-webkit-animation-name:box-move7;animation-name:box-move7}.loader .box7 div{-webkit-animation-name:box-scale7;animation-name:box-scale7}@-webkit-keyframes box-move0{12%{transform:translate(var(--x),var(--y))}25%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move0{12%{transform:translate(var(--x),var(--y))}25%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale0{6%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}14%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale0{6%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}14%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move1{16%{transform:translate(var(--x),var(--y))}29%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move1{16%{transform:translate(var(--x),var(--y))}29%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale1{10%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}18%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale1{10%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}18%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move2{20%{transform:translate(var(--x),var(--y))}33%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move2{20%{transform:translate(var(--x),var(--y))}33%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale2{14%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}22%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale2{14%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}22%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move3{24%{transform:translate(var(--x),var(--y))}37%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move3{24%{transform:translate(var(--x),var(--y))}37%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale3{18%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}26%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale3{18%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}26%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move4{28%{transform:translate(var(--x),var(--y))}41%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move4{28%{transform:translate(var(--x),var(--y))}41%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale4{22%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}30%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale4{22%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}30%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move5{32%{transform:translate(var(--x),var(--y))}45%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move5{32%{transform:translate(var(--x),var(--y))}45%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale5{26%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}34%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale5{26%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}34%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move6{36%{transform:translate(var(--x),var(--y))}49%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move6{36%{transform:translate(var(--x),var(--y))}49%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale6{30%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}38%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale6{30%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}38%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes box-move7{40%{transform:translate(var(--x),var(--y))}53%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@keyframes box-move7{40%{transform:translate(var(--x),var(--y))}53%,52%{transform:translate(0,0)}80%{transform:translate(0,-32px)}90%,100%{transform:translate(0,188px)}}@-webkit-keyframes box-scale7{34%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}42%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@keyframes box-scale7{34%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(0)}42%,100%{transform:rotateY(-47deg) rotateX(-15deg) rotateZ(15deg) scale(1)}}@-webkit-keyframes ground{0%,65%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(0)}75%,90%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(1)}100%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(0)}}@keyframes ground{0%,65%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(0)}75%,90%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(1)}100%{transform:rotateX(90deg) rotateY(0deg) translate(-48px,-120px) translateZ(100px) scale(0)}}@-webkit-keyframes ground-shine{0%,70%{opacity:0}75%,87%{opacity:.2}100%{opacity:0}}@keyframes ground-shine{0%,70%{opacity:0}75%,87%{opacity:.2}100%{opacity:0}}@-webkit-keyframes mask{0%,65%{opacity:0}66%,100%{opacity:1}}@keyframes mask{0%,65%{opacity:0}66%,100%{opacity:1}}
  </style>
</head>

<body>
  <div class="loader-container"><div class="loader"><div class="box box0"><div></div></div><div class="box box1"><div></div></div><div class="box box2"><div></div></div><div class="box box3"><div></div></div><div class="box box4"><div></div></div><div class="box box5"><div></div></div><div class="box box6"><div></div></div><div class="box box7"><div></div></div><div class="ground"><div></div></div></div></div>
  <!-- As a link -->
  <div class=" m-0 p-0 row d-flex flex-column justify-content-start justify-content-lg-center align-items-center"
    style="width:100%;height:100vh;">
    <?php include './userNav.php'; ?>
    <div class="position-absolute overflow-auto col-12 main m-0 p-10  overflow-auto w-100"
      style="width:calc(100% - 100px); height:100%;">
      <div class="p-0 container mt-3 d-flex flex-column flex-wrap justify-content-center align-items-center">
        <!-- section to code not outside  else, if better not to see-->
        <p class="d-none d-lg-flex fw-bold fs-4 text-center">Welcome to Power Friends - Your Ultimate Destination for Batteries!</p>
        <p class="d-flex d-lg-none fw-bold fs-4 text-center">Welcome to<br>Power Friends</p>
        <div class="border border-2 p-1 border-dark rounded-5 input-group mb-3" style="width:90%;">
          <input type="text" id="searchInput" class="rounded-5 border border-0 me-1 form-control"
            placeholder="Search products here ....." aria-label="Search products here ....."
            aria-describedby="button-addon2">
          <button class="text-light rounded-5 btn btn-primary" type="button" id="button-addon2"
            style="width:150px;">Search</button>
        </div>
        <div id="card_container"class="m-0 p-0 overflow-auto container-fluid d-flex flex-row flex-wrap justify-content-center">
          <!-- cards of products -->
          <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $category = $row['category'];
                    $productCode = $row['productCode'];
                    $warranty = $row['warranty'];
                    $quantity = $row['quantity'];
                    ?>
                    
                    <div class="m-2 card border rounded-4 border-1 border-primary bg-secondary"
                        style="min-width: 20rem; height:auto;">
                        <div class="overflow-auto card-body text-light" style="width: 100%; height:100%;">
                          <h6 class="fs-5 card-title"><?php echo htmlspecialchars($category); ?></h6>
                          <p class="card-text" style="font-size:12px; line-height:15px;">
                            Product Code: <?php echo htmlspecialchars($productCode); ?><br>
                            Warranty: <?php echo htmlspecialchars($warranty); ?><br>
                            Quantity: <?php echo htmlspecialchars($quantity); ?> PCS
                          </p>
                          <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-light rounded-5 fw-semibold text-secondary"  data-bs-toggle="modal" data-bs-target="#orderModal" style="width:100%;">Order Now</a>
                            <!-- <a href="javascript:void(0);"
                              class="m-0 p-0 btn btn-light rounded-5 fw-semibold text-secondary d-flex justify-content-center align-items-center"
                              style="height:35px;width:35px;">
                              <i class="fa-solid fa-cart-shopping"></i>
                            </a> -->
                          </div>
                        </div>
                      </div>
                    
                    <?php
                }
            } else {
                echo "No products found.";
            }

            // Close the connection
            $conn->close();
          ?>
        </div>
        
      </div>
      <!-- Order Book modal -->
      <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content shadow">
            <div class="modal-header border-bottom-0">
              <h1 class="modal-title fs-5" id="orderModalLabel">Order Booking</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row d-flex justify-content-between align-items-center flex-column flex-lg-row">
              <div class="col text-center" style="height:400px;">
                <img src="./order.png" class="img-thumbnail border-0" alt="order">
              </div>
              <form action="backend/addOrders.php" method="post"class="col d-flex flex-column justify-content-center align-items-center" style="height:100%;">
                <div class="input-container w-75">
                  <input name="textContent" placeholder="Enter Product Details" class="input-field" type="text" required>
                  <label for="input-field" class="input-label">Enter Product Details</label>
                  <span class="input-highlight"></span>
                </div>
                <br>
                <div class="input-container w-75">
                  <input name="quantity" placeholder="Enter Quantity" class="input-field" type="text"required>
                  <label for="input-field" class="input-label">Enter Quantity</label>
                  <span class="input-highlight"></span>
                </div>
                <button type="submit" class="btn btn-outline-primary w-100">ORDER</button>
              </form>
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
    //loading animtaion
    window.addEventListener('load', function() {
      setTimeout(function() {
          var loaderElement = document.querySelector('.loader-container');
          
          if (loaderElement) {
              loaderElement.style.transition = 'opacity 0.5s ease';
              loaderElement.style.opacity = '0';
              
              loaderElement.addEventListener('transitionend', function() {
                  loaderElement.remove();
              });
          }
      }, 3000);
    });
    //order modal load
    window.addEventListener('load', () => {
      setTimeout(() => {
        var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        orderModal.show();
      }, 5000); // Adjust the delay as needed
    });

    
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
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        if (title.includes(searchTerm)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
    



  </script>
</body>

</html>