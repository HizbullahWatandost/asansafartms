<!-- Sidebar -->
<?php
  if(isset($_SESSION['userType']) && $_SESSION['userType'] === "Admin"){
    $disableForAdmins = "color: gray;pointer-events: none;";
  }else if(isset($_SESSION['userType']) && $_SESSION['userType'] === "Operator"){
    $disableForOperators = "color: gray;pointer-events: none;";
  }
?>
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="imgs/default/user_login_icon.png" class="img-circle elevation-2" alt="User Image" width="50" height="50">
    </div>
    <div class="info">
      <a href="adminaccountsettings.php" class="d-block"><?php if(isset($_SESSION['adminFullName'])) echo $_SESSION['adminFullName']; ?></a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
     <li class="nav-item has-treeview">
       <a href="#" class="nav-link">
         <i class="nav-icon fas fa-user"></i>
         <p>
           My Account
           <i class="fas fa-angle-left right"></i>
         </p>
       </a>
       <ul class="nav nav-treeview">
         <li class="nav-item">
           <a href="adminaccountsettings.php" class="nav-link">
             <i class="far fa-circle nav-icon text-info"></i>
             <p>Account Settings</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="adminpassreset.php" class="nav-link">
             <i class="nav-icon far fa-circle text-danger"></i>
             <p>Reset Password</p>
           </a>
         </li>
         <li class="nav-item">
           <a href="logout.php" class="nav-link">
             <i class="far fa-circle nav-icon text-warning"></i>
             <p>Logout</p>
           </a>
         </li>
       </ul>
       <hr />
     </li>
      <li class="nav-item">
        <a href="./index.php" class="nav-link">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Home
            <span class="right badge badge-danger">Main Page</span>
          </p>
        </a>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Client Interface
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">5</span>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="webnamelogo.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>Name & Logo</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="webslideshow.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>Slideshow</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="webabout.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>About Us</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="webfeedback.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>Feedback</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="webcontact.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>Contact Us</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Clients
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="clientregister.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add a Client</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientsmanagement.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Manage Clients</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientsreport.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Client Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientsactivityloggings.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Client Logs</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-question"></i>
          <p>
            Clients' Feedback
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="clientsfeedback.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Feedback Reports</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-building"></i>
          <p>
            Travel Agency (TA)
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="agencyregister.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add TA</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tamanagement.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>TA Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tareport.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>TA Report</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-bus-alt"></i>
          <p>
            Vehicles
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="addvehicle.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Vehicle</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="vehiclemanagement.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Vehicles Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="vehiclereports.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Vehicles Report</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-ticket-alt"></i>
          <p>
            Tickets Management
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="addticket.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Ticket</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ticketmanagement.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Managet Tickets</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ticketreport.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Tickets Report</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-handshake"></i>
          <p>
            Membership
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="addmembership.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Issue Membership</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="membershipmanagement.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Membership Managemen</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="membershipreports.php" class="nav-link" style="<?php if(isset($disableForAdmins)) echo $disableForAdmins; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Membership Report</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-eye"></i>
          <p>
            Loggins
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="adminactivityloggings.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin Logs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="operatorsactivityloggings.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Operator Logs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clientsactivityloggings.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Client Logs</p>
            </a>
          </li>
        </ul>
      </li>
      <!-- <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-dollar-sign"></i>
          <p>
            Income & Accntings
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="pages/UI/icons.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Daily Income</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/buttons.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Monthly Income</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/buttons.html" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Yearly Income</p>
            </a>
          </li>
        </ul>
        <hr />
      </li> -->
      <li class="nav-header text-bold">ADMIN & ROLE MANAGEMENT</li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-circle"></i>
          <p>
            Role Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>
                Privilege
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Create Privilege</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Manage Privileges</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="nav nav-treeview">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>
                Roles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Create Role</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Manage Roles</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Admins
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="adminregister.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add an Admin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adminmanagement.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Manage Admins</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adminsreport.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adminactivityloggings.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin Logs</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Operator
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="operatorregister.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Add an Operator</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="operatorsmanagement.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Manage Operators</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="operatorsreport.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Operator Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="operatorsactivityloggings.php" class="nav-link" style="<?php if(isset($disableForOperators)) echo $disableForOperators; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Operator Logs</p>
            </a>
          </li>
        </ul>
        <hr />
      </li>
      <li class="nav-item">
        <a href="calender.php" class="nav-link">
          <i class="nav-icon far fa-calendar-alt"></i>
          <p>
            Calendar
            <span class="badge badge-info right"><?php echo (date("d/m/Y")); ?></span>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="googlemap.php" class="nav-link">
          <i class="fas fa-map-marker-alt nav-icon"></i>
          <p>Map</p>
        </a>
      </li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-envelope"></i>
          <p>
            Mailbox
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inbox</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Compose</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Read</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fas fa-comment nav-icon"></i>
          <p>Chat Room</p>
        </a>
        <hr />
      </li>
      <!-- <li class="nav-header">LABELS</li> -->
      <li class="nav-item">
        <a class="nav-link">
          <i class="nav-icon far fa-circle text-danger"></i>
          <p class="text">Important</p>
        </a>
      </li>
      <li class="nav-item">
        <a  class="nav-link">
          <i class="nav-icon far fa-circle text-warning"></i>
          <p>Warning</p>
        </a>
      </li>
      <li class="nav-item">
        <a  class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Informational</p>
        </a>
      </li>
      <li class="nav-item">
        <a  class="nav-link">
          <i class="nav-icon far fa-circle text-success"></i>
          <p>successful</p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
