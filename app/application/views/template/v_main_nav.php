<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SimDodar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('adminpmi_user_name') ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <?php 
          foreach ($menus as $menu) {
          ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); echo $menu['url'];?>" class="nav-link">
              <i class="nav-icon fa <?php echo $menu['icon_nav'] ?>"></i>
              <p>
              <?php echo $menu['menu'] ?>
              <?php if($menu['isParent'] == 1){?>
                <i class="right fa fa-angle-left"></i>
              <?php
              }
              ?>
              </p>
            </a>
            <?php
            foreach ($submenus as $submenu) {
              if ($submenu['submenu_id']==$menu['menu_id']){
            ?>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); echo $submenu['url'];?>" class="nav-link">
                  <i class="fa <?php echo $submenu['icon_nav'] ?>"></i>
                  <p><?php echo $submenu['menu'] ?></p>
                </a>
              </li>
            </ul>
            <?php
              }
            }
            ?>
          </li>
          <?php
          }
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
