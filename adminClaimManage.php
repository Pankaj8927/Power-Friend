<?php
    session_start();
    // include 'backend/db_connection.php';// Database connection
    $conn = mysqli_connect('localhost', 'root', '', 'powerfriend');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] !== 'YES') {
        // Redirect to the login page if not logged in as admin
        header("Location: ./adminLogin.php");
        exit();
    }
    // Fetch today's date in 'Y-m-d' format
    $todayDate = date("Y-m-d");

    // Include 'sessionClose.php'
    
    // Count claims where decision_status = 'Despatch' or stock_status is 'Complete' or 'Already Despatch'
    $claimClearQuery = "SELECT COUNT(*) AS claimClearCount FROM claim_details WHERE decision_status = 'Despatch' OR stock_status = 'Complete' OR stock_status = 'Already Despatch'";
    $claimClearResult = mysqli_query($conn, $claimClearQuery);
    $claimClearCount = mysqli_fetch_assoc($claimClearResult)['claimClearCount'];

    // Count claims where decision_status = 'Pending' or stock_status = 'No Stock' or 'Ready To Stock'
    $claimPendingQuery = "SELECT COUNT(*) AS claimPendingCount FROM claim_details WHERE decision_status = 'Pending' OR stock_status = 'No Stock' OR stock_status = 'Ready To Stock'";
    $claimPendingResult = mysqli_query($conn, $claimPendingQuery);
    $claimPendingCount = mysqli_fetch_assoc($claimPendingResult)['claimPendingCount'];

    // Sum total claim stock
    $claimClearQuery = "SELECT SUM(totalClaimStock) AS totalClaimClearSum FROM claim_details";
    $claimClearResult = mysqli_query($conn, $claimClearQuery);
    $claimStockCount = mysqli_fetch_assoc($claimClearResult)['totalClaimClearSum'];

    // Sum claims where decision_status = 'Despatch'
    $claimDespatchQuery = "SELECT SUM(totalExideClearStock) AS claimDespatchCount FROM claim_details";
    $claimDespatchResult = mysqli_query($conn, $claimDespatchQuery);
    $claimDespatchCount = mysqli_fetch_assoc($claimDespatchResult)['claimDespatchCount'];

    // Current date claim clear
    $currentclaimClearQuery = "SELECT COUNT(*) AS claimClearCount FROM claim_details WHERE (decision_status = 'Despatch' OR stock_status = 'Already Despatch' OR stock_status = 'Complete') AND DATE(ddopf) = CURDATE()";
    $currentclaimClearResult = mysqli_query($conn, $currentclaimClearQuery);
    $currentclaimClearCount = mysqli_fetch_assoc($currentclaimClearResult)['claimClearCount'];

    // Current date claim pending
    $currentclaimPendingQuery = "SELECT COUNT(*) AS claimPendingCount FROM claim_details WHERE (decision_status = 'Pending' OR stock_status = 'No Stock' OR stock_status = 'Ready To Stock') AND DATE(ddopf) = CURDATE()";
    $currentclaimPendingResult = mysqli_query($conn, $currentclaimPendingQuery);
    $currentclaimPendingCount = mysqli_fetch_assoc($currentclaimPendingResult)['claimPendingCount'];
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
        /* *{border:1px solid red;} */
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

        #yearSelect3::placeholder {
            color: white;
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
            <div class="container mt-3 d-flex flex-column flex-wrap justify-content-center align-items-center">
                <!-- section to code not outside  else, if better not to see-->
                <p class="d-none d-lg-flex fw-bold fs-4 text-center">Welcome to Power Friends - Your Ultimate
                    Destination for Batteries!</p>
                <p class="d-flex d-lg-none fw-bold fs-4 text-center">Welcome to<br>Power Friends</p>
                <div class="border border-2 p-1 border-dark rounded-5 input-group mb-3" style="width:90%;">
                    <input type="text" id="searchInput" class="rounded-5 border border-0 me-1 form-control"
                        placeholder="Search here ....." aria-label="Search here ....." aria-describedby="button-addon2">
                    <button class="text-light rounded-5 btn btn-primary" type="button" id="button-addon2"
                        style="width:150px;">Search</button>
                </div>
                <!-- Show today's date, Cleared Claims, and Pending Claims -->
                <div class="m-0 p-0 d-flex flex-wrap justify-content-center align-items-center">
                   <a href="./Stockbill.php"> <button class="m-2 btn btn-primary rounded-5 text-light fw-bold" type="button">Claims Report</button></a>
                    
                    <!-- Claim Diagnostic Modal Trigger -->
                    <a type="button" class="btn btn-primary rounded-5 text-light fw-semibold" data-bs-toggle="modal" data-bs-target="#claimDetails">
                        Claims Diagnostic
                    </a>

                    <!-- Today's Date -->
                    <div class="m-2 text-primary-emphasis fw-bold" style="font-size:16px;">
                        <i class="fa-solid fa-calendar-day me-2"></i>Today's Date: <?php echo $todayDate; ?>
                    </div>

                    <!-- Today's Cleared Claims -->
                    <span class="m-2 badge d-flex align-items-center mx-2 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-pill" style="font-size:14px;">
                        <i class="fa-solid fa-circle-check fs-5 me-2"></i>Today's Cleared Claims
                        <span class="vr mx-2"></span>
                        <p class="m-0"><?php echo $currentclaimClearCount; ?></p>
                    </span>

                    <!-- Today's Pending Claims -->
                    <span class="m-2 badge d-flex align-items-center mx-2 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-pill" style="font-size:14px;">
                        <i class="fa-solid fa-clock fs-5 me-2"></i>Today's Pending Claims
                        <span class="vr mx-2"></span>
                        <p class="m-0"><?php echo $currentclaimPendingCount; ?></p>
                    </span>
                </div>

                <div class="row gx-3 gy-2 align-items-center" id="claimForm">
                    <div id="addedProductsContainer"
                        class="col container-fluid d-flex flex-column flex-wrap justify-content-center align-items-center mt-4 m-0 p-0"
                        style="width:100%;height:auto;">
                        <!-- Default Product Item Form -->
                        <div id="scrollProductsContainer"
                            class="container overflow-x-auto d-flex flex-column  align-items-center align-items-lg-start"
                            style="height:calc(100vh - 300px);">
                            <?php
                        // Example: Fetch all data from the database
                        $sql = "SELECT * FROM `claim_details` ORDER BY id DESC";

                        $result = mysqli_query($conn, $sql);
                        $slNo = 1;

                        if (mysqli_num_rows($result) > 0) {
                            // Loop through all rows in the result
                            while ($claim = mysqli_fetch_assoc($result)) {
                                // Output the form for each row
                                ?>
                            <div class="productItem">
                                <form class="row g-2 mb-2 border-bottom border-primary productForm" style="width:100%"
                                    data-id="<?php echo $claim['id']; ?>">
                                    <div
                                        class="col-12 d-flex flex-column flex-lg-row justify-content-center align-items-center">
                                        <a href="adminUserDetails.php?user=<?php echo $claim['dealerName']?>&uniqueId=<?php echo $claim['uniqueId']?>"
                                            class="m-2 d-flex align-items-center form-control shadow slNo"
                                            style="background-color:<?php echo htmlspecialchars($claim['color']); ?>; height: 30px; width: <?php echo (strlen($slNo) + 2.5) . 'ch'; ?>; display: inline-block; text-align: center; line-height: 30px; text-decoration: none; color: black;"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="<?php echo htmlspecialchars($claim['decision_status'] . ' ' . $claim['stock_status']); ?>">
                                            <?php echo htmlspecialchars($slNo); ?>
                                        </a>
                                        <input type="text" class="m-2 form-control shadow dispatchDatePF"
                                            onfocus="this.type='date'" onblur="this.type='text'"
                                            placeholder="Dispatch Date of PF" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['ddopf']; ?>">
                                        <input type="text" class="m-2 form-control shadow dateofSale"
                                            onfocus="this.type='date'" onblur="this.type='text'"
                                            placeholder="Date of Sale" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['dos']; ?>">
                                        <input type="text" class="m-2 form-control shadow invoiceNumber"
                                            placeholder="Invoice Number" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['invno']; ?>">
                                        <input type="text" class="m-2 form-control shadow date"
                                            onfocus="this.type='date'" onblur="this.type='text'"
                                            placeholder="Invoice Date" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['invd']; ?>">
                                        <input type="text" class="m-2 form-control shadow replacement"
                                            placeholder="Replacement" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['replacement']; ?>">
                                        <input type="text" class="m-2 form-control shadow replacementSlno"
                                            placeholder="Replacement Sl No" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['slno']; ?>">

                                        <!-- Decision Select -->
                                        <select class="decisionSelect py-0  m-2 fw-semibold form-select"
                                            aria-label="Default select example" style="height: 30px; width:auto;">
                                            <option>Decision</option>
                                            <option value="Pending" <?php echo $claim['decision_status']=='Pending'
                                                ? 'selected' : '' ; ?>>Pending</option>
                                            <option value="Despatch" <?php echo $claim['decision_status']=='Despatch'
                                                ? 'selected' : '' ; ?>>Despatch</option>
                                        </select>

                                        <!-- Stock Select -->
                                        <select class="stockSelect py-0 m-2 fw-semibold form-select"
                                            aria-label="Default select example" style="height: 30px; width:auto;">
                                            <option>Stock</option>
                                            <option value="No Stock" <?php echo $claim['stock_status']=='No Stock'
                                                ? 'selected' : '' ; ?>>No Stock</option>
                                            <option value="Ready To Stock" <?php echo
                                                $claim['stock_status']=='Ready To Stock' ? 'selected' : '' ; ?>>Ready To
                                                Stock</option>
                                            <option value="Stock Done" <?php echo $claim['stock_status']=='Stock Done'
                                                ? 'selected' : '' ; ?>>Stock Done</option>
                                            <option value="Complete" <?php echo $claim['stock_status']=='Complete'
                                                ? 'selected' : '' ; ?>>Complete</option>
                                            <option value="Already Despatch" <?php echo
                                                $claim['stock_status']=='Already Despatch' ? 'selected' : '' ; ?>
                                                >Already Despatch</option>
                                        </select>

                                        <input type="text" class="m-2 form-control shadow dealerName"
                                            placeholder="Dealer Name" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['dealerName']; ?>" required>
                                        <input type="text" class="m-2 form-control shadow customerName"
                                            placeholder="Customer Name" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['customerName']; ?>" required>
                                        <input type="text" class="m-2 form-control shadow contactNo"
                                            placeholder="Contact No." style="height: 30px; width:auto;"
                                            value="<?php echo $claim['cContactNumber']; ?>" required>
                                        <input type="text" class="m-2 form-control shadow batteryType"
                                            placeholder="Battery Type" style="height: 30px; width:auto;"
                                            value="<?php echo $claim['batteryType']; ?>" required>
                                        <input type="text" class="m-2 form-control shadow serialNo"
                                            placeholder="Serial No." style="height: 30px; width:auto;"
                                            value="<?php echo $claim['serialNo']; ?>" required>
                                        <input type="text" class="m-2 form-control shadow ticketsNo"
                                            placeholder="Tickets No." style="height: 30px; width:auto;"
                                            value="<?php echo $claim['ticketsNumber']; ?>">

                                        <!-- <button type="button" class="m-2 btn btn-sm btn-outline-primary d-flex flex-row justify-content-center align-items-center fw-bold" onclick="AddProductItems()">ADD&nbsp;<i class="fa-solid fa-plus"></i></button> -->
                                    </div>
                                </form>
                            </div>
                            <?php
                                $slNo ++;
                            }
                        } else {
                            echo "No claims found.";
                        }
                    ?>

                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center mb-4" style="width:100%;">
                        <button type="button"
                            class="mt-4 col-12 col-lg-5 rounded-5 text-light fw-bold btn btn-primary submitProduct">Update</button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="claimDetails" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-light d-flex justify-content-between">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Claim Diagnostic</h1>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <button type="button" class="btn text-light" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center text-dark fw-semibold">
                            <div class="container row gap-2 d-flex justify-content-center align-items-center">
                                <!-- Claim Clear Chart -->
                                <div class="col-12 col-lg-5  d-flex justify-content-center align-items-center flex-column"
                                    style="height:auto;width:auto;">
                                    <p class="p-0 m-0 fw-semibold">Claim Clear -
                                        <?php echo $claimClearCount; ?>
                                    </p>
                                    <input type="number" id="yearSelect"
                                        class="form-control form-control-sm bg-transparent border border-2 border-primary rounded-2 p-0 m-0 text-center"
                                        min="2024" step="1" value="2024">
                                    <div id="chart_div" class="m-0 p-0 overflow-x-auto overflow-y-hidden"
                                        style="width:100%;"></div>
                                    <div id="total_value" class="m-0 p-0 text-center"></div>
                                </div>
                                <!-- Claim Pending Chart -->
                                <div class="col-12 col-lg-5  d-flex justify-content-center align-items-center flex-column"
                                    style="height:auto;width:auto;">
                                    <p class="p-0 m-0 fw-semibold">Claim Pending -
                                        <?php echo $claimPendingCount; ?>
                                    </p>
                                    <input type="number" id="yearSelect1"
                                        class="form-control form-control-sm bg-transparent border border-2 border-primary rounded-2 p-0 m-0  text-center"
                                        min="2024" step="1" value="2024">
                                    <div id="chart_div1" class="m-0 p-0 overflow-x-auto overflow-y-hidden"
                                        style="width:100%;"></div>
                                    <div id="total_value1" class="m-0 p-0 text-center"></div>
                                </div>
                                <div class="p-0 row gap-2 d-flex justify-content-center " style="height:40vh;">
                                    <div class="col-12 col-lg-5 " style="height:100%;">
                                        <p class="p-0 m-0 fw-semibold text-center">Dealer Claim Details</p>
                                        <!-- Date Range claim details -->
                                        <div class="d-flex justify-content-center flex-wrap m-1 p-0">
                                            <input type="date" class="form-control form-control-sm bg-transparent border border-2 border-primary rounded-2 p-1 m-2 w-auto" id="startingDate">
                                            <input type="date" class="form-control form-control-sm bg-transparent border border-2 border-primary rounded-2 p-1 m-2 w-auto" id="endingDate">
                                        </div>
                                        <select id="dealerSelect"
                                            class="form-select form-select-sm bg-transparent border border-2 border-primary rounded-2"
                                            aria-label="Default select example">
                                            <option disabled selected>Dealer Name / Code</option>
                                            <?php
                                                // Query to fetch user details
                                                $sql = "SELECT * FROM users";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="'.htmlspecialchars($row['uniqueId']).'">'.htmlspecialchars($row['name']).' / '.htmlspecialchars($row['dealer_code']).'</option>';
                                                    }
                                                } else {
                                                    echo '<option>No users found.</option>';
                                                }
                                            ?>
                                        </select>
                                        <!-- Placeholder for the result -->
                                        <div class="m-0 mt-2 d-flex justify-content-around  align-items-start flex-row overflow-auto"
                                            style="height:calc(100% - 125px)">
                                            <div class="d-flex justify-content-start flex-wrap">
                                                <a
                                                    class="d-flex align-items-center mb-3 mb-md-auto me-md-auto text-decoration-none">
                                                    <i class="fa-solid fa-cube me-2"></i>
                                                    <span id="totalClaimClear" class="fs-6 text-dark">Total claim Clear:
                                                        0</span>
                                                </a>
                                                <a
                                                    class="d-flex align-items-center mb-3 mb-md-auto me-md-auto text-decoration-none">
                                                    <i class="fa-solid fa-cube me-2"></i>
                                                    <span id="totalClaimPending" class="fs-6 text-dark">Total claim
                                                        Pending: 0</span>
                                                </a>
                                                <div class="w-100">
                                                    <a
                                                        class="d-flex align-items-center mb-3 mb-md-auto me-md-auto text-decoration-none">
                                                        <i class="fa-solid fa-cube me-2"></i>
                                                        <span id="batteryQty" class="fs-6 text-dark">Battery Type :
                                                            Qty</span>
                                                    </a>
                                                    <!-- Battery quantities will be dynamically inserted here -->
                                                    <a>
                                                        <ol id="batteryQtyList"></ol>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-5 ">
                                        <div class="row  border-bottom border-3 border-light d-flex flex-row justify-content-start align-items-center"
                                            style="height:auto;">
                                            <div class="d-flex justify-content-center align-items-center text-center fs-5 rounded-circle"
                                                style="height:120px;width:120px;border:10px solid #FF204E !important;">
                                                <?php echo $claimStockCount;?> pcs
                                            </div>
                                            <div style="width:calc(100% - 120px);">
                                                <span
                                                    class="m-2 badge d-flex align-items-center p-1 pe-2 fs-6 text-light text-center bg-primary border border-primary-subtle rounded-pill"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Current Stock - <?php echo $claimStockCount - $claimDespatchCount;?> pcs">
                                                    Current Stock
                                                    <span class="vr mx-2"></span>
                                                    <p class="m-0 p-1">
                                                        <?php echo $claimStockCount - $claimDespatchCount;?> pcs
                                                    </p>
                                                </span>
                                                <span
                                                    class="m-2 badge d-flex align-items-center p-1 pe-2 fs-6 text-light text-center bg-primary border border-primary-subtle rounded-pill">
                                                    <input type="number" id="yearSelect3"
                                                        class="form-control bg-transparent border-0 rounded-2 p-0 m-0 fw-semibold text-light text-start w-50"
                                                        min="2024" step="1" placeholder="Enter Year">
                                                    <span class="vr mx-2"></span>
                                                    <p id="stockValue" class="m-0 p-1"></p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row  border-top border-3 border-light d-flex flex-row justify-content-start align-items-center"
                                            style="height:auto;">
                                            <p class="text-truncate p-2 text-start badge fs-6 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-pill"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Total Stock clear from EXIDE - <?php echo $claimDespatchCount;?>">
                                                <i class="fa-solid fa-circle-check m-0 p-0 me-2"></i> <span>Total Stock
                                                    clear from EXIDE</span>
                                                <span class="vr mx-2"></span>
                                                <?php echo $claimDespatchCount;?>
                                            </p>
                                            <br><br><br>
                                            <p class="text-truncate p-2 text-start badge fs-6 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-pill"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-custom-class="custom-tooltip"
                                                data-bs-title="Total Stock Due from EXIDE - <?php echo $claimStockCount - $claimDespatchCount;?>">
                                                <i class="fa-solid fa-clock m-0 p-0 me-2"></i> <span>Total Stock Due
                                                    from EXIDE</span>
                                                <span class="vr mx-2"></span>
                                                <?php echo $claimStockCount - $claimDespatchCount;?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Developer Details -->
            <div class="modal fade" id="developerDetails" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="./claimManage.js"></script>
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
        
        document.querySelector('.submitProduct').addEventListener('click', () => {
            const forms = document.querySelectorAll('.productForm');
            const data = [];

            forms.forEach(form => {
                const id = form.getAttribute('data-id');
                // const dispatchDatePF = form.querySelector('.dispatchDatePF').value;
                // const dateofSale = form.querySelector('.dateofSale').value;
                // const invoiceNumber = form.querySelector('.invoiceNumber').value;
                // const date = form.querySelector('.date').value;

                if (id) {
                    data.push({
                        id: parseInt(id, 10),
                        dispatchDatePF: form.querySelector('.dispatchDatePF').value,
                        dateofSale: form.querySelector('.dateofSale').value,
                        invoiceNumber: form.querySelector('.invoiceNumber').value,
                        date: form.querySelector('.date').value,
                        replacement: form.querySelector('.replacement').value,
                        replacementSlno: form.querySelector('.replacementSlno').value,
                        decision: form.querySelector('.decisionSelect').value,
                        stock: form.querySelector('.stockSelect').value,
                        dealerName: form.querySelector('.dealerName').value,
                        customerName: form.querySelector('.customerName').value,
                        contactNo: form.querySelector('.contactNo').value,
                        batteryType: form.querySelector('.batteryType').value,
                        serialNo: form.querySelector('.serialNo').value,
                        ticketsNo: form.querySelector('.ticketsNo').value
                    });
                }
            });

            // Send the data using AJAX
            fetch('backend/manageClaim.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
        document.getElementById('searchInput').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const productItems = document.querySelectorAll('.productItem');

            productItems.forEach(item => {
                const inputs = item.querySelectorAll('input');
                const selects = item.querySelectorAll('select');
                let found = false;

                // Check all input fields
                inputs.forEach(input => {
                    const value = input.value.toLowerCase();
                    if (value.includes(searchTerm)) {
                        found = true;
                    }
                });

                // Check all select fields
                selects.forEach(select => {
                    const value = select.options[select.selectedIndex].text.toLowerCase();
                    if (value.includes(searchTerm)) {
                        found = true;
                    }
                });

                // Show or hide the item based on whether any field matched
                item.style.display = found ? '' : 'none';
            });
        });

    </script>
    
</body>

</html>