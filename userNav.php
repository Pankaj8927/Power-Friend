<!-- navbar.php -->
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
    <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Home">
      <a href="./index.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-house"></i>
      </a>
    </li>
    <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Registration">
      <a href="./register.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-address-card"></i>
      </a>
    </li>
    <!-- <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Cart">
      <a href="./addToCart.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'addToCart.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'addToCart.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-cart-shopping"></i>
      </a>
    </li> -->
    <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Order Status">
      <a href="./orderStatus.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'orderStatus.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'orderStatus.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-truck"></i>
      </a>
    </li>
    <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Order Claim">
      <a href="./claim.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'claim.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'claim.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-hand-holding-hand"></i>
      </a>
    </li>
  </ul>
  <ul id="adminMenu"
    class="d-none d-lg-flex overflow-hidden nav nav-pills nav-flush flex-column justify-content-center align-items-center text-center"
    style="width:100%">
    <li data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Admin">
      <a href="./adminParties.php" style="height:40px;width:40px"
        class="mb-2 d-flex justify-content-center align-items-center nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'adminParties.php' ? 'active' : ''; ?> border-bottom rounded-5"
        <?php echo basename($_SERVER['PHP_SELF']) == 'adminParties.php' ? '' : 'onmouseover="this.style.backgroundColor=\'white\'; this.style.color=\'#FF204E\';" onmouseout="this.style.backgroundColor=\'\'; this.style.color=\'#FF204E\';"'; ?>>
        <i class="fa-solid fa-user-tie"></i>
      </a>
    </li>
  </ul>
</div>
