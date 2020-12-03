
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
  style="border-bottom: 0.3em solid #28a745;">
  <a class="navbar-brand" href="home">
    <!-- retrevining website name and logo from database -->
    <?php
      $weblogo = "SELECT * FROM websitenamelogo LIMIT 1";
      $result = $database->query($weblogo);
      $result = mysqli_fetch_object($result);
      $webSiteName = $result->websiteName;
      $websiteLogo = $result->websiteLogo;
     ?>
     <!-- the web logo will be uploaded in logo folder -->
    <img src="<?php echo isset($websiteLogo) ? './admin/imgs/logo/'.$websiteLogo : 'images/logo/asan_safar.png';// if the logo is not provided, then it takes the default logo ?>" width="80" height="50" class="d-inline-block"
    alt="Asan Safar Logo" style="margin-right: 1em;">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link smooth-scroll" href="#home">Home<span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link smooth-scroll" href="#book_ticket">Book A Ticket</a>
      </li>

      <li class="nav-item">
        <a class="nav-link smooth-scroll" href="#quick_book_discount_offers">Quick Book - <small> based on discounts and offers </small></a>
      </li>

      <li class="nav-item">
        <a class="nav-link smooth-scroll" href="#about_us">About Us</a>
      </li>

      <li class="nav-item">
        <a class="nav-link smooth-scroll" href="#feedback">Feedback</a>
      </li>

      <li class="nav-item">
        <a class="nav-link smooth-scroll" href="#contact_us">Contact Us</a>
      </li>
    </ul>
    <div class="btn-group" id="user-settings">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false">
      User Settings
    </button>
        <div class="dropdown-menu" aria-labelledby="user-settings">
          <!-- account settings drop down list -->
          <div style="display: <?php echo !isset($_SESSION['login'])? "block" : "none" ?>" >
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#signInModal">
              <i class="fas fa-sign-in-alt"></i> Sign In </a>
              <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createAccountModel">
              <i class="fa fa-user-plus"></i> Register </a>
          </div>
          <div style="display: <?php echo isset($_SESSION['login'])? "block" : "none" ?>" >
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#clientTrip">
              <i class="fas fa-suitcase"></i> My Trips </a>
              <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#clientBookedTicketsModel">
              <i class="fas fa-ticket-alt"></i> View Tickets </a>
              <div class="dropdown-divider"></div>
            <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createAccountModel">
              <i class="fas fa-gift"></i> Offers </a>
              <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editAccountModel">
              <i class="fas fa-user-edit"></i> Edit Account </a>
              <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myAccountModel">
              <i class="fas fa-user"></i> My Account </a>
              <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#resetPasswordModel">
              <i class="fas fa-lock"></i> Reset Password </a>
              <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php">
              <i class="fas fa-sign-out-alt"></i> Sign Out </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="card bg-light">
    <div class="modal-content borderstyle">
      <div class="modal-header bg-success text-white border-0">
        <h5 class="modal-title" id="editAccountModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">

  <article class="card-body mx-auto" style="max-width: 400px;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login-form">
      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="username_err_msg">User Name Error</span>
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-user"></i> </span>
       </div>
          <input name="userName" id="username" required="required" class="form-control" placeholder="Email address" type="email">
      </div> <!-- form-group// -->

      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="loginpass_err_msg">Password Error</span>
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
      </div>
          <input name="loginPass" id="loginpass" required="required"  class="form-control" placeholder="Repeat password" type="password">

      </div> <!-- form-group// -->
      <div class="form-group">

          <button type="submit" name="login" class="btn btn-success btn-block"> Login  </button>
      </div> <!-- form-group// -->
            <p class="text-center"><a href="#" data-toggle="modal" data-target="#forgotPassword" data-dismiss="modal">Forgot Password</a></p>
  </form>
  </article>
  </div> <!-- card.// -->


          </div>
        </div>
      </div>
  </div>


  <div class="modal fade" id="createAccountModel" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="card bg-light">
    <div class="modal-content borderstyle">
      <div class="modal-header bg-success text-white border-0">
        <h5 class="modal-title" id="editAccountModalLabel">Create Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">

  <article class="card-body mx-auto" style="max-width: 400px;">

  	<p class="text-center">Get started with your free account</p>
  	<p>
  		<a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i>   Login via Twitter</a>
  		<a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via facebook</a>
  	</p>
  	<p class="divider-text">
          <span class="bg-light">OR</span>
      </p>
  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="reg-form">
  	<div class="form-group input-group">
      <span class="frm-validation-err-tooltip" id="fullname_err_msg">Full Name Error</span>
      <!-- First name -->
  		<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
  		 </div>
          <input name="fullName" id="full-name" required="required" class="form-control" placeholder="Full name" type="text">
      </div> <!-- form-group// -->
      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="email_err_msg">Email Error</span>
        <!-- First name -->
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
  		 </div>
          <input name="email" id="email" required="required" class="form-control" placeholder="Email address" type="email">
      </div> <!-- form-group// -->
      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="mobile_err_msg">Mobile Error</span>
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
  		</div>
  		<select class="custom-select" style="max-width: 80px;">
  		    <option selected="">+93</option>
  		</select>
      	<input name="mobile" id="mobile" required="required" class="form-control" placeholder="Phone number" type="text">
      </div> <!-- form-group// -->
      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="permenat_address_err_msg">Permenat Address Error</span>

      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
  		</div>
  		<select class="form-control" name="permenatAddress">
  			<option selected="selected"> Selected Permenat Address</option>
  			<option>Kabul</option>
  			<option>Mazar</option>
  			<option>Kunduz</option>
        <option>Parwan</option>
        <option>Ghazni</option>
        <option>Takhar</option>
  		</select>
  	</div> <!-- form-group end.// -->

    <div class="form-group input-group">
      <span class="frm-validation-err-tooltip" id="current_address_err_msg">Current Address Error</span>
      <div class="input-group-prepend">
        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
    </div>
    <select class="form-control" name="currentAddress">
      <option selected="selected"> Selected Current Address</option>
      <option>Kabul</option>
      <option>Mazar</option>
      <option>Kunduz</option>
      <option>Parwan</option>
      <option>Ghazni</option>
      <option>Takhar</option>
    </select>
  </div> <!-- form-group end.// -->

      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="pass_err_msg">Pass Error</span>
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
  		</div>
          <input name="password" id="password" required="required" class="form-control" placeholder="Create password" type="password">
      </div> <!-- form-group// -->
      <div class="form-group input-group">
        <span class="frm-validation-err-tooltip" id="confirmpass_err_msg">Confirm Pass Error</span>
      	<div class="input-group-prepend">
  		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
  		</div>
          <input name="passwordConfirm" id="password-confirm" required="required" class="form-control" placeholder="Repeat password" type="password">
      </div> <!-- form-group// -->
      <div class="form-group">
        <p class="text-center"><small>By clicking
          <em>Sign up</em> you agree to our
          <a href="" target="_blank">terms of service</a></small></p>
          <button type="submit" name="clientRegister" class="btn btn-success btn-block"> Create Account  </button>
      </div> <!-- form-group// -->
  </form>
  </article>
  </div> <!-- card.// -->

          </div>
        </div>
      </div>
    </div>

        <?php
            $result = "";
            if(isset($_SESSION['username'])){
            $sql = "SELECT * FROM client WHERE clientEmail = '{$_SESSION["username"]}' LIMIT 1";
            $result = $database->query($sql);
            $result = mysqli_fetch_array($result);
          }
         ?>

            <div class="modal fade" id="myAccountModel" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="card bg-light">
                  <div class="modal-content borderstyle">
                    <div class="modal-header bg-success text-white border-0">
                      <h5 class="modal-title" id="editAccountModalLabel">My Account Details</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                <article class="card-body mx-auto" style="max-width: 400px;">


                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="reg-form">
                  <div class="form-group input-group">
                    <!-- First name -->
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                     </div>
                        <input name="fullName" id="full-name" disabled = "disabled" required="required" class="form-control" placeholder="Full name" type="text" value = "<?php if(isset($result['clientFullName'])) echo $result['clientFullName']; ?>">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                      <!-- First name -->
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                     </div>
                        <input name="email" id="email" disabled = "disabled" required="required" class="form-control" placeholder="Email address" type="email" value = "<?php if(isset($result['clientEmail'])) echo $result['clientEmail']; ?>">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                    </div>
                    <select class="custom-select" style="max-width: 80px;">
                        <option selected="">+93</option>
                    </select>
                      <input name="mobile" id="mobile" disabled = "disabled" required="required" class="form-control" placeholder="Phone number" type="text" value = "<?php if(isset($result['clientMobile'])) echo $result['clientMobile']; ?>">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                    </div>
                    <select class="form-control" name="permenatAddress">
                      <option selected="selected" disabled = "disabled"><?php if(isset($result['clientPermenantAddress'])) echo $result['clientPermenantAddress']; ?></option>
                    </select>
                  </div> <!-- form-group end.// -->

                  <div class="form-group input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                  </div>
                  <select class="form-control" name="currentAddress">
                    <option selected="selected" disabled = "disabled"><?php if(isset($result['clientCurrentAddress'])) echo $result['clientCurrentAddress']; ?></option>
                  </select>
                </div> <!-- form-group end.// -->

                </form>
                </article>
                </div> <!-- card.// -->
            </div>
          </div>
        </div>
      </div>


        <div class="modal fade" id="editAccountModel" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="card bg-light">
          <div class="modal-content borderstyle">
            <div class="modal-header bg-success text-white border-0">
              <h5 class="modal-title" id="editAccountModalLabel">Account Settings</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body">

        <article class="card-body mx-auto" style="max-width: 400px;">

        	<p class="text-center">Get started with your account settings</p>
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="account-settings-form">
        	<div class="form-group input-group">
            <!-- First name -->
        		<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
        		 </div>
                <input name="fullName" id="full-name" required="required" class="form-control" placeholder="Full name" type="text" value = "<?php if(isset($result['clientFullName'])) echo $result['clientFullName']; ?>">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
              <!-- First name -->
            	<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
        		 </div>
                <input name="email" id="email" required="required" class="form-control" placeholder="Email address" type="email" value = "<?php if(isset($result['clientEmail'])) echo $result['clientEmail']; ?>">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
            	<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
        		</div>
        		<select class="custom-select" style="max-width: 80px;">
        		    <option selected="">+93</option>
        		</select>
            	<input name="mobile" id="mobile" required="required" class="form-control" placeholder="Phone number" type="text" value = "<?php if(isset($result['clientMobile'])) echo $result['clientMobile']; ?>">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
            	<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
        		</div>
        		<select class="form-control" name="permenatAddress">
        			<option selected="selected"><?php if(isset($result['clientPermenantAddress'])) echo $result['clientPermenantAddress']; ?></option>
        			<option>Kabul</option>
        			<option>Mazar</option>
        			<option>Kunduz</option>
              <option>Parwan</option>
              <option>Ghazni</option>
              <option>Takhar</option>
        		</select>
        	</div> <!-- form-group end.// -->

          <div class="form-group input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-building"></i> </span>
          </div>
          <select class="form-control" name="currentAddress">
            <option selected="selected"><?php if(isset($result['clientCurrentAddress'])) echo $result['clientCurrentAddress']; ?></option>
            <option>Kabul</option>
            <option>Mazar</option>
            <option>Kunduz</option>
            <option>Parwan</option>
            <option>Ghazni</option>
            <option>Takhar</option>
          </select>
        </div> <!-- form-group end.// -->
            <div class="form-group">
                <button type="submit" name="updateAccount" id = "updateAccount" class="btn btn-success btn-block"> Update Account  </button>
            </div> <!-- form-group// -->
        </form>
        </article>
        </div> <!-- card.// -->

        </div>
      </div>
    </div>
  </div>


        <div class="modal fade" id="resetPasswordModel" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="card bg-light">
          <div class="modal-content borderstyle">
            <div class="modal-header bg-success text-white border-0">
              <h5 class="modal-title" id="editAccountModalLabel">Reset Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body">

        <article class="card-body mx-auto" style="max-width: 400px;">

        	<p class="text-center">Reset your password</p>
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="account-settings-form">
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
            </div>
                <input name="currentPassword" id="currentPassword" required="required" class="form-control" placeholder="Current password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
            	<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        		</div>
                <input name="newPassword" id="newPassword" required="required" class="form-control" placeholder="Create password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
            	<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        		</div>
                <input name="newPasswordConfirm" id="newPasswordConfirm" required="required" class="form-control" placeholder="Repeat password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group">
                <button type="submit" name="resetPassword" id = "resetPassword" class="btn btn-success btn-block"> Reset Password  </button>
            </div> <!-- form-group// -->
        </form>
        </article>
        </div> <!-- card.// -->

        </div>
      </div>
    </div>
  </div>


          <div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="card bg-light">
            <div class="modal-content borderstyle">
              <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="editAccountModalLabel">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="text-white">&times;</span>
                </button>
              </div>
              <div class="modal-body">

          <article class="card-body mx-auto" style="max-width: 400px;">

          	<p class="text-center">Please enter your registered email to reset your password</p>
          	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="forgot-password-form">
              <div class="form-group input-group">
              	<div class="input-group-prepend">
          		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
          		</div>
                  <input name="recoveryEmail" id="recoveryEmail" required="required" class="form-control" placeholder="Recovery Email" type="email">
              </div> <!-- form-group// -->
              <div class="form-group">
                  <button type="submit" name="forgotPassword" id = "forgotPassword" class="btn btn-success btn-block"> Send me recovery link  </button>
              </div> <!-- form-group// -->
          </form>
          </article>
          </div> <!-- card.// -->

          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="clientBookedTicketsModel" tabindex="-1" role="dialog" aria-labelledby="clientBookedTicketsModel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="card bg-light">
      <div class="modal-content borderstyle">
        <div class="modal-header bg-success text-white border-0">
          <h5 class="modal-title" id="editAccountModalLabel">My Booked Tickets</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">

    <article class="card-body mx-auto">
        <div class="card-body">
          <table id="dataTable" class="table table-bordered table-striped" style="font-size:.8em;">
            <thead>
            <tr>
              <th>#</th>
              <th>Source & <br />Destination Place</th>
               <th>Departure & <br />Arrival Date</th>
               <th>Vehicle</th>
               <th>Set Number</th>
               <th>Price</th>
               <th>Booking Date</th>
            </tr>
            </thead>
            <tbody>
              <?php
              $no=1;
              $userEmail = $_SESSION['username'];
              $cquery = "SELECT * FROM client WHERE clientEmail = '{$userEmail}' LIMIT 1";
              $clientTrip = $database->query($cquery);
              $clientTrip = mysqli_fetch_array($clientTrip);
              $clientId = $clientTrip['clientId'];
              $getClientTickets = $database->query("SELECT * FROM ticket WHERE clientId = '{$clientId}'");
              $ticketCounts = mysqli_num_rows ($getClientTickets);
              if ($ticketCounts > 0) // if the search input value matches to database then,
              {
                while($ticket = $database->fetch_array($getClientTickets)) { ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $ticket['srcPlacce']." <br /> ".$ticket['destPlace']; ?></td>
                    <td><?php echo $ticket['departureDate']." <br /> ".$ticket['arrivalDate']; ?></td>
                    <td><?php echo $ticket['vehicleType']; ?></td>
                    <td><?php echo $ticket['setNo']; ?></td>
                    <td><?php echo $ticket['price']; ?></td>
                    <td><?php echo $ticket['bookingDate']; ?></td>

                  </tr>
                <?php }
              }else{
                echo "No ticket found";
              }
              ?>
            </tbody>
          </table>
        </div><!-- /.card-body -->
    </article>
    </div> <!-- card.// -->

    </div>
  </div>
</div>
</div>

<div class="modal" id="clientTrip" tabindex="-1" role="dialog" aria-labelledby="clientTrip"
aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="card">
  <div class="modal-content borderstyle">
    <div class="modal-header bg-success text-white border-0">
      <h5 class="modal-title" id="editAccountModalLabel">My Trips</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="text-white">&times;</span>
      </button>
    </div>
    <div class="modal-body">

<article class="card-body mx-auto">
    <div class="card-body">
      <table id="dataTable" class="table table-bordered table-striped" style="font-size:.8em;">
        <thead>
        <tr>
          <th>#</th>
          <th>Source Place</th>
          <th>Destination Place</th>
           <th>Departure  Date</th>
           <th>Arrival Date</th>
        </tr>
        </thead>
        <tbody>
          <?php
            $no=1;
            $userEmail = $_SESSION['username'];
            $cquery = "SELECT * FROM client WHERE clientEmail = '{$userEmail}' LIMIT 1";
            $clientTrip = $database->query($cquery);
            $clientTrip = mysqli_fetch_array($clientTrip);
            $clientId = $clientTrip['clientId'];
            $getClientTrips = $database->query("SELECT * FROM ticket WHERE clientId = '{$clientId}'");
            $tripCount = mysqli_num_rows ($getClientTrips);
            if ($tripCount > 0) // if the search input value matches to database then,
            {
            while($ticket = $database->fetch_array($getClientTrips)) { ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $ticket['srcPlacce'];; ?></td>
                <td><?php echo $ticket['destPlace']; ?></td>
                <td><?php echo $ticket['departureDate'];?></td>
                <td><?php echo $ticket['arrivalDate']; ?></td>
              </tr>
            <?php }
          }else{
            echo "You have no trip in AsanSafar";
          }?>
        </tbody>
      </table>
    </div><!-- /.card-body -->
</article>
</div> <!-- card.// -->

</div>
</div>
</div>
</div>


  </header>
