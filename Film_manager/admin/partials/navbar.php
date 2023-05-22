<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="color:#ccc;background:url('assets/css/body-bg.gif');">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="color:#ccc;background:url('assets/css/body-bg.gif');">
    <h4><i class="fa  fa-user">&nbsp;&nbsp;&nbsp;</i><?php echo $_SESSION['uemail'];?></h4>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-sign-out">
        <a class="dropdown-item" href="logout.php">
          <i class="mdi mdi-logout me-2 text-primary"></i>Signout
        </a>
      </li>
    </ul>
  </div>
</nav>
