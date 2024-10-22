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
    .table tbody tr td:nth-child(3) {width: 50%;}
    .form-control:focus,select:focus,input[type="radio"]:focus {border: none;}
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
                    placeholder="Enter details to search ....." aria-label="Enter details to search ....."
                    aria-describedby="button-addon2">
                <button class="text-light rounded-5 btn btn-primary" type="button" id="create"
                    style="width:150px;">Search</button>
            </div>
            <div id="addedPaymentsContainer" class="overflow-auto container-fluid d-flex flex-column flex-wrap justify-content-center m-0 p-0" style="width:100%;height:auto;">
                <table class="table">
                    <thead class="table-dark position-static top-0">
                        <tr>
                            <th scope="col" style="border-top-left-radius: 10px;">Sl No.</th>
                            <th scope="col">Date</th>
                            <th colspan="3" scope="col">Products Details</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="border-top-right-radius: 10px;text-align:center;">Unpaid/Due/Clear</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">1</th>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">2024-08-10</td>
                            <td colspan="3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Battery Model X100, 12V, 100Ah</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Clear ₹5000</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <div class="m-0 p-0 d-flex justify-content-around">
                                    <input class="form-check-input fs-5 bg-danger" type="radio" name="radioNoLabel1" id="radioNoLabel1" value="" aria-label="Unpaid">
                                    <input class="form-check-input fs-5 bg-dark" type="radio" name="radioNoLabel1" id="radioNoLabel3" value="" aria-label="Due">
                                    <input data-bs-toggle="modal" data-bs-target="#paymentsEntry" class="form-check-input fs-5 bg-success" type="radio" name="radioNoLabel1" id="radioNoLabel2" value="" aria-label="Paid">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">2</th>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">2024-08-11</td>
                            <td colspan="3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Battery Model Y200, 24V, 150Ah</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Due ₹25000</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <div class="m-0 p-0 d-flex justify-content-around">
                                  <input class="form-check-input fs-5 bg-danger" type="radio" name="radioNoLabel1" id="radioNoLabel1" value="" aria-label="Unpaid">
                                  <input class="form-check-input fs-5 bg-dark" type="radio" name="radioNoLabel1" id="radioNoLabel3" value="" aria-label="Due">
                                  <input data-bs-toggle="modal" data-bs-target="#paymentsEntry" class="form-check-input fs-5 bg-success" type="radio" name="radioNoLabel1" id="radioNoLabel2" value="" aria-label="Paid">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">3</th>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">2024-08-12</td>
                            <td colspan="3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Battery Model Z300, 48V, 200Ah</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Unpaid ₹15000</td>
                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <div class="m-0 p-0 d-flex justify-content-around">
                                  <input class="form-check-input fs-5 bg-danger" type="radio" name="radioNoLabel1" id="radioNoLabel1" value="" aria-label="Unpaid">
                                  <input class="form-check-input fs-5 bg-dark" type="radio" name="radioNoLabel1" id="radioNoLabel3" value="" aria-label="Due">
                                  <input data-bs-toggle="modal" data-bs-target="#paymentsEntry" class="form-check-input fs-5 bg-success" type="radio" name="radioNoLabel1" id="radioNoLabel2" value="" aria-label="Paid">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="paymentsEntry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light rounded-4">
              <div class="modal-header d-flex justify-content-between">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Customer Name</h1>
                <button type="button" class="btn text-light rounded-5" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
              </div>
              <div class="modal-body">
                <p class="text-start">Total Amount ₹amount</p>
                <div class="input-group">
                  <input type="number" class="form-control rounded-start-5" id="takenAmount" placeholder="₹amount">
                  <button class="btn btn-outline-primary rounded-end-5" type="button">Button</button>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <p class="text-end">Total Due Amount ₹amount</p>
                <p class="text-end">Total Clear Amount ₹amount</p>
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
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
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
    
    
  </script>
  
</body>

</html>