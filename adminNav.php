<!-- admin navbar.php -->
<div
  class="z-1 position-absolute position-lg-relative start-0 m-2 p-2 rounded-5 d-flex flex-column justify-content-between align-items-center bg-dark"
  style="width:60px; height:80vh; height: auto !important;">
  <a href="#" id="menuButton"
    class="d-flex justify-content-center align-items-center link-body-emphasis text-decoration-none bg-light rounded-5"
    style="width:45px;height:45px;">
    <i class="fa-solid fa-chart-simple"></i>
  </a>
  
  <ul id="menusItems"
    class="d-none d-lg-flex overflow-hidden nav nav-pills nav-flush flex-column justify-content-center align-items-center text-center"
    style="width:100%; height:calc(80vh - (40px + 45px));">

    <!-- User Site -->
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="User Site">
      <a href="./index.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-users"></i>
      </a>
    </li>

    <!-- Dealer Details -->
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Dealer Details">
    <a href="./adminParties.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link 
        <?php echo (basename($_SERVER['PHP_SELF']) == 'adminParties.php' || basename($_SERVER['PHP_SELF']) == 'adminUserDetails.php') ? 'active' : ''; ?> 
        border-bottom rounded-5"
        <?php echo (basename($_SERVER['PHP_SELF']) == 'adminParties.php' || basename($_SERVER['PHP_SELF']) == 'adminUserDetails.php') ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-calendar-days"></i>
    </a>
    </li>


    <!-- Add Products -->
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Add Products">
      <a href="./adminAdditems.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminAdditems.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'adminAdditems.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-boxes-stacked"></i>
      </a>
    </li>

    <!-- Claim Manage -->
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Claim Manage">
      <a href="./adminClaimManage.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminClaimManage.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'adminClaimManage.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-handshake-simple"></i>
      </a>
    </li>

    <!-- Payments -->
    <!-- <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Payments">
      <a href="./adminPayments.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminPayments.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'adminPayments.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-hand-holding-dollar"></i>
      </a>
    </li> -->

    <!-- Login -->
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Login">
      <a href="./adminLogin.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5"
        onmouseover="this.style.backgroundColor='white'; this.style.color='#FF204E';"
        onmouseout="this.style.backgroundColor=''; this.style.color='#FF204E';">
        <i class="fa-solid fa-user-tie"></i>
      </a>
    </li>
    
  </ul>

  <ul id="adminMenu"
    class="d-none d-lg-flex overflow-hidden nav nav-pills nav-flush flex-column justify-content-center align-items-center text-center"
    style="width:100%">
    <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Developer">
      <img src="./logo.png" style="cursor:pointer;height:40px;width:40px" alt="Developer" data-bs-toggle="modal" data-bs-target="#developerDetails" class="object-fit-contain mb-2 p-0 d-flex justify-content-center align-items-center nav-link border-bottom rounded-5">
    </li>
  </ul>
</div>
