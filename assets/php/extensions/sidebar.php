<header class="header">
  <div class="menu-icon" onclick="openSidebar()">
    <span class="material-icons-outlined">menu</span>
  </div>
</header>

<aside id="sidebar">
  <div class="sidebar-title">
    <div class="sidebar-brand">
      Cafe Haraya
    </div>
    <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
  </div>

  <ul class="sidebar-list">
    <li class="sidebar-list-item">
      <a href="admin.php">
        <span class="material-icons-outlined">dashboard</span> Dashboard
      </a>
    </li>
    <?php if ($adminLvl == 'superAdmin'): ?>
      <li class="sidebar-list-item">
        <a href="admins.php">
          <span class="material-icons-outlined">admin_panel_settings</span> Administrator
        </a>
      </li>
    <?php endif; ?>
    <li class="sidebar-list-item">
      <a href="product.php">
        <span class="material-icons-outlined">account_box</span> Products
      </a>
    </li>
    <li class="sidebar-list-item dropdown">
      <a href="javascript:void(0);" class="dropbtn">
        <span class="material-icons-outlined">category</span> Category
      </a>
      <div class="dropdown-content">
        <a href="main_category.php">Main Category</a>
        <a href="sub_category.php">Sub Category</a>
      </div>
    </li>
    <li class="sidebar-list-item">
      <a href="customer.php">
        <span class="material-icons-outlined">account_box</span> Customers
      </a>
    </li>
    <li class="sidebar-list-item">
      <a href="order.php">
        <span class="material-icons-outlined">shopping_cart</span>Orders
      </a>
    </li>
    <li class="sidebar-list-item">
      <a onclick="logoutAdmin();">
        <span class="material-icons-outlined">logout</span> Logout
      </a>
    </li>
    <li class="sidebar-list-item">
      <span style="color: #DEDEDE;"><i class="fas fa-user"></i></span>
      <span style="color: #DEDEDE;">Welcome, <?php echo $adminLvl ?>!</span>
    </li>
  </ul>
</aside>

<!-- Add the <style> and <script> blocks inside your <head> or <body> tag -->
