<?php
  // Include database connection
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
  // Fetch all details from the products table
  // $sql = "SELECT id, title, description FROM products ORDER BY id DESC";
  $sql = "SELECT id, category, productCode, warranty, quantity FROM products ORDER BY id DESC";
  $result = $conn->query($sql);
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
                <input type="text" id="itemInput" class="d-block rounded-5 border border-0 me-1 form-control"
                    placeholder="Enter number of Products to add ...." aria-label="Enter number of Products to add ....."
                    aria-describedby="button-addon2" disabled>
                <button class="d-block text-light rounded-5 btn btn-primary" type="button" id="create"
                    style="width:150px;" disabled>Create</button>

                <input type="text" id="searchInput" class="d-none rounded-5 border border-0 me-1 form-control"
                    placeholder="Search Items here ...." aria-label="Search Items here ....."
                    aria-describedby="button-addon2" disabled>
                <button class="d-none text-light rounded-5 btn btn-primary" type="button" id="search"
                    style="width:150px;" disabled>Search</button>
            </div>
            <br>
            <div id="hiddenElement"class="row g-4 justify-content-center align-items-center mb-4" style="width: 100%;">
              <div class="col-lg-6">
                <div class="h-100 p-5 text-bg-dark rounded-3">
                  <h2>Add Stock Items</h2>
                  <p>Admins can add stock items via the admin site, which will then be visible to users on the user site, ensuring real-time updates and availability of new products.</p>
                  <button class="btn btn-outline-primary fw-semibold" onclick="toggleDiv('addedProductsContainer')"type="button">ADD STOCK</button>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="h-100 p-5 text-bg-dark rounded-3">
                  <h2>Show Stock Items Details</h2>
                  <p>Display added stock items on the admin site for easy tracking and management. This feature helps admins review inventory changes, correct mistakes, and ensure accurate stock levels.</p>
                  <button class="btn btn-outline-primary fw-semibold" onclick="toggleDiv('showProducts')" type="button">SHOW STOCK</button>
                </div>
              </div>
            </div>
            <div id="addedProductsContainer" class="container-fluid d-none flex-column flex-wrap justify-content-center align-items-center m-0 p-0" style="width:100%;height:auto;">
                <div class="productItem p-4 d-flex flex-column justify-content-center align-items-center">
                    <form class="row g-2 mb-2 border-bottom border-primary">
                        <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
                          <select class="form-select shadow w-50" aria-label="Default select example">
                            <option selected>Product Category</option>
                            <option>CAR/SUV</option>
                            <option>3W/LCV</option>
                            <option>DM WATER</option>
                            <option>CV</option>
                            <option>TRACTOR</option>
                            <option>CAR/SUV/3W/TRACTOR/CV</option>
                            <option>E-RICKSHAW</option>
                            <option>2-WHEELER</option>
                          </select>
                            <input type="text" class="m-2 form-control shadow itemName" placeholder="Product Code"><br>
                            <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Warranty"><br>
                            <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Quantity"><br>
                            <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>
                    <div id="ADDBUTTON" style="width:40%;">
                      <button type="button" class="mt-4 w-100 rounded-5 text-light fw-bold btn btn-primary submitProduct">Upload</button>
                    </div>
                </div>
            </div>
            <div id="showProducts" class="overflow-auto container-fluid d-none flex-column flex-wrap justify-content-center m-0 p-0" style="width:100%;height:auto;">
              <table class="table">
                <thead class="table-dark position-static top-0">
                    <tr>
                        <th scope="col" style="border-top-left-radius: 10px;">Sl No.</th>
                        <th scope="col">Category</th>
                        <th scope="col">Product Code</th>
                        <th scope="col">Warranty</th>
                        <th scope="col">Quantity</th>
                        <th scope="col" style="border-top-right-radius: 10px; text-align:center;">Edit / Delete</th>
                    </tr>
                </thead>
                <tbody>
                  <?php

                  if ($result->num_rows > 0) {
                      $sl_no = 1; // Initialize serial number
                      while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<th scope='row' style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$sl_no}</th>";
                          echo "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$row['category']}</td>";
                          echo "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$row['productCode']}</td>";
                          echo "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$row['warranty']}</td>";
                          echo "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>{$row['quantity']} Units</td>";
                          echo "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align:center;'>";
                          echo "<a id='editButton' type='button' data-bs-toggle='modal' data-bs-target='#productsDetailsEdit' data-id='{$row['id']}' data-category='{$row['category']}' data-productCode='{$row['productCode']}' data-warranty='{$row['warranty']}' data-quantity='{$row['quantity']}'><i class='fa-solid fa-pen-to-square' style='color: #FF204E;'></i></a>&nbsp;&nbsp;";
                          echo "<a href='backend/delete.php?table=products&id={$row['id']}'><i class='fa-solid fa-trash' style='color: #00224d;'></i></a>";
                          echo "</td>";
                          echo "</tr>";

                          $sl_no++; // Increment serial number
                      }
                  } else {
                      echo "<tr><td colspan='6' style='text-align:center;'>No products found</td></tr>";
                  }

                  ?>
              </tbody>
              </table> 
                         
            </div>
        </div>
        <!-- Edit details -->
        <div class="modal fade" id="productsDetailsEdit" tabindex="-1" aria-labelledby="productsDetailsEdit" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light rounded-4">
              <div class="modal-header d-flex justify-content-between">
                <h1 class="modal-title fs-5" id="productsCode">Product Code</h1>
                <button type="button" class="btn text-light rounded-5" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
              </div>
              <div class="modal-body">
                <form action="backend/updateProducts.php" method="post">
                <input id="id" type="hidden" name="id">
                  <select id="modalCategory" class="form-select rounded-2 mb-2" name="category" aria-label="Default select example">
                    <option selected>Product Category</option>
                    <option>CAR/SUV</option>
                    <option>3W/LCV</option>
                    <option>DM WATER</option>
                    <option>CV</option>
                    <option>TRACTOR</option>
                    <option>CAR/SUV/3W/TRACTOR/CV</option>
                    <option>E-RICKSHAW</option>
                    <option>2-WHEELER</option>
                  </select>
                  <input id="modalProductCode" type="text" class="form-control rounded-2 mb-2" name="productCode" placeholder="Product Code">
                  <input id="modalWarranty" type="text" class="form-control rounded-2 mb-2" name="warranty" placeholder="Warranty">
                  <input id="modalQuantity" type="text" class="form-control rounded-2 mb-2" name="quantity" placeholder="Quantity"><br>
                  <button class="btn btn-outline-primary mb-3 fw-semibold w-100" type="submit" >Update</button>
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
                <h1 class="modal-title fs-5">Developer Contact Details</h1>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
    document.getElementById('create').addEventListener('click', function() {
        createProductItems();
    });

    function toggleDiv(sectionId) {
        var hiddenElement = document.getElementById('hiddenElement');
        var section = document.getElementById(sectionId);
        var input = document.getElementById('itemInput');
        var input1 = document.getElementById('searchInput');
        var button = document.getElementById('create');
        var button1 = document.getElementById('search');
    
        hiddenElement.style.display = "none";
        section.classList.remove('d-none');
        section.classList.add('d-flex');

        if (sectionId === 'addedProductsContainer') {
          input.removeAttribute('disabled');
          button.removeAttribute('disabled');
        }
        else if(sectionId === 'showProducts'){
          input1.removeAttribute('disabled');
          button1.removeAttribute('disabled');
          input.classList.remove('d-block');
          input.classList.add('d-none');
          input1.classList.remove('d-none');
          input1.classList.add('d-block');

          button.classList.remove('d-block');
          button.classList.add('d-none');
          button1.classList.remove('d-none');
          button1.classList.add('d-block');
        }
        else{
          alert('Invalid Section Id!');
        }
    }
     
    function createProductItems() {
      var itemQty = document.getElementById('itemInput').value;
      var addedProductsContainer = document.getElementById('addedProductsContainer');
      var buttonContainer = document.getElementById('ADDBUTTON');
  
      // Clear the container but keep the button intact
      addedProductsContainer.innerHTML = '';
      buttonContainer.innerHTML = '';
  
      for (let i = 1; i <= itemQty; i++) {
          var addedProducts = document.createElement('div');
          addedProducts.className = "productItem p-4 d-flex flex-column justify-content-center align-items-center";
          addedProducts.innerHTML = `
              <form class="row g-2 mb-2 border-bottom border-primary">
                  <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
                    <select class="form-select shadow w-50" aria-label="Default select example">
                      <option selected>Product Category</option>
                      <option>CAR/SUV</option>
                      <option>3W/LCV</option>
                      <option>DM WATER</option>
                      <option>CV</option>
                      <option>TRACTOR</option>
                      <option>CAR/SUV/3W/TRACTOR/CV</option>
                      <option>E-RICKSHAW</option>
                      <option>2-WHEELER</option>
                    </select>
                      <input type="text" class="m-2 form-control shadow itemName" placeholder="Product Code"><br>
                      <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Warranty"><br>
                      <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Quantity"><br>
                      <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button>
                  </div>
              </form>
          `;
          addedProductsContainer.appendChild(addedProducts);
      }
  
      // Ensure the main "ADD" button stays at the end
      buttonContainer.innerHTML = `<button type="button" class="mt-4 w-100 rounded-5 text-light fw-bold btn btn-primary submitProduct">Upload</button>`;
      addedProducts.appendChild(buttonContainer);
  }
  
  function AddProductItems() {
    var addedProductsContainer = document.getElementById('addedProductsContainer');
    var buttonContainer = document.getElementById('ADDBUTTON');

    // Create a new product item element
    var addedProducts = document.createElement('div');
    addedProducts.className = "productItem p-4 d-flex flex-column justify-content-center align-items-center";
    addedProducts.innerHTML = `
        <form class="row g-2 mb-2 border-bottom border-primary">
            <div class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
              <select class="form-select shadow w-50" aria-label="Default select example">
                <option selected>Product Category</option>
                <option>CAR/SUV</option>
                <option>3W/LCV</option>
                <option>DM WATER</option>
                <option>CV</option>
                <option>TRACTOR</option>
                <option>CAR/SUV/3W/TRACTOR/CV</option>
                <option>E-RICKSHAW</option>
                <option>2-WHEELER</option>
              </select>
                <input type="text" class="m-2 form-control shadow itemName" placeholder="Product Code"><br>
                <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Warranty"><br>
                <input type="text" class="m-2 form-control shadow itemPrice" placeholder="Product Quantity"><br>
                <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button>
            </div>
        </form>
    `;

    // Append the new product item to the container without removing existing ones
    addedProductsContainer.appendChild(addedProducts);
    // Ensure the main "ADD" button stays at the end
    buttonContainer.innerHTML = `<button type="button" class="mt-4 w-100 rounded-5 text-light fw-bold btn btn-primary submitProduct">Upload</button>`;
    addedProducts.appendChild(buttonContainer);
}

  
  
  // Event listener to handle the click on the "ADD" button with class 'submitProduct'
  document.getElementById('addedProductsContainer').addEventListener('click', function(event) {
    if (event.target.classList.contains('submitProduct')) {
        handleAddButtonClick();
    }
  });

  function handleAddButtonClick() {
    var addedProductsContainer = document.getElementById('addedProductsContainer');
    var productItems = addedProductsContainer.getElementsByClassName('productItem');
    var allFormsData = [];

    // Iterate through each productItem to collect form data
    for (var i = 0; i < productItems.length; i++) {
        var form = productItems[i].querySelector('form');
        var formObject = {};

        // Get the select element and add its value to the formObject
        var select = form.querySelector('select');
        formObject["category"] = select.value; // Update key to match your database column

        // Get the input elements within the form and convert them into an object
        var inputs = form.querySelectorAll('input');
        inputs.forEach(function(input) {
            // Update keys to match your database columns
            if (input.placeholder === "Product Code") {
                formObject["productCode"] = input.value;
            } else if (input.placeholder === "Product Warranty") {
                formObject["warranty"] = input.value;
            } else if (input.placeholder === "Product Quantity") {
                formObject["quantity"] = input.value;
            }
        });

        // Add the form object to the array
        allFormsData.push(formObject);
    }

    // Send the JSON data to the PHP script using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/additems.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          alert('Stock added successfully!');
          location.reload();
        }
    };
    xhr.send(JSON.stringify(allFormsData));
  }


  //search input
  document.getElementById('search').addEventListener('click', function() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.table tbody tr');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;

        cells.forEach(cell => {
            const text = cell.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                found = true;
            }
        });

        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
  });

  const editButtons = document.querySelectorAll('#editButton');

  editButtons.forEach(function(button) {
      button.addEventListener('click', function() {
          const id = button.getAttribute('data-id');
          const category = button.getAttribute('data-category');
          const productCode = button.getAttribute('data-productCode');
          const warranty = button.getAttribute('data-warranty');
          const quantity = button.getAttribute('data-quantity');

          // Set modal input values
          document.getElementById('id').value = id;
          document.getElementById('modalCategory').value = category;
          document.getElementById('modalProductCode').value = productCode;
          document.getElementById('modalWarranty').value = warranty;
          document.getElementById('modalQuantity').value = quantity;

          // Set the modal title
          document.getElementById('productsCode').textContent = "Product Code - "+productCode;
      });
  });





  </script>
  
</body>

</html>