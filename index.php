<?php include ('inc/db_connection_session.php'); ?>
<?php include ('inc/client_register.php'); ?>
<?php include ('inc/client_login.php'); ?>
<?php include ('inc/account_settings.php'); ?>
<?php include ('inc/userresetpass.php'); ?>
<?php include ('inc/forgotpassword.php'); ?>
<?php include ('inc/ticket_process.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- style -->
  <?php include ('include/pagecomn_head.php'); ?>
  <!-- jquery scipt for auto search index -- product search -->
  <script>
      function searchq(){
          var searchTxt = $("input[name='product_code_name_desc']").val();
          $.post("ticket_search.php",{searchVal:searchTxt}, function(output){
              $("#output").html(output);
          });
      }
  </script>

  <title>Transportation Management System (TMS)</title>
</head>

<body>
  <?php include 'include/header.php'; ?>
    <main>
      <?php include 'include/slideshow.php'; ?>

      <div class="menus-container container-book-ticket">
        <div class="container subcontainer-book-ticket">
          <div class="page-header menus-container" id="book_ticket">
            <h3 class="text-center text-white text-uppercase">Book A Ticket</h3>
            <hr class="stylish-hr-2" />
            <form name="product_search" method="get" action="index.php">
              <div class="form-row">
                <div class="form-group input-group col-md-6 mb-3">
                   <div class="input-group-prepend">
                     <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
                   </div>
                    <select class=" form-control select2bs4" name="srcPlace">
                      <option selected="selected" disabled = "disabled">Select the source place</option>
                      <option>Kabul</option>
                      <option>Mazar</option>
                      <option>Laghman</option>
                       <option>Parwan</option>
                       <option>Takhar</option>
                       <option>Qandhar</option>
                    </select>
                </div>
                <div class="form-group input-group col-md-6 mb-3">
                   <div class="input-group-prepend">
                     <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
                   </div>
                    <select class=" form-control select2bs4" name="destPlace">
                      <option selected="selected" disabled = "disabled">Select the destination place</option>
                      <option>Kabul</option>
                      <option>Mazar</option>
                      <option>Laghman</option>
                       <option>Parwan</option>
                       <option>Takhar</option>
                       <option>Qandhar</option>
                    </select>
                </div>
              </div>
                <div class="form-row">
                  <div class="col-md-6 mb-3" style="text-align: left;">
                    <label for="dateLabel" class="text-white">Select Date</label>
                    <div class="input-group" id="dateLabel">
                      <input type="date" class="form-control" placeholder="Departure date" aria-label="Departure date" aria-describedby="basic-addon2" name="departureDate" required="required">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3" style="text-align: left;">
                    <label for="vehicleTypeLable" class="text-white">Select Vehicle Type</label>
                    <select class="form-control" id="vehicleTypeLable" name="vehicleType">
                      <option selected="selected" disabled = "disabled">Select the vehicle type</option>
                      <option>Corola</option>
                      <option>Saraycha</option>
                      <option>Tunnes</option>
                       <option>Bus 480</option>
                       <option>Bus 404</option>
                       <option>Bus 303</option>
                    </select>
                  </div>
                </div>
                <div class="container text-center">
                  <button class="btn ticket-search-btn text-center" type="submit">Search Vehicle</button>
                </div>
              </form>
              <hr class="stylish-hr-2" />
            </div>
          </div>
        </div>


					<!--search query-->
					<?php
          echo '<!-- start of home page main container -->
                  <div class="ticket-container">
                      <div class ="tickets bg-light">';

					if (isset($_REQUEST['srcPlace']) &&  isset($_REQUEST['destPlace']) && isset($_REQUEST['departureDate']) && isset($_REQUEST['vehicleType'])) {
            $srcPlace = $database -> escape_value(trim(stripslashes($_REQUEST['srcPlace'])));
            $destPlace = $database -> escape_value(trim(stripslashes($_REQUEST['destPlace'])));
            $departureDate = $database -> escape_value(trim(stripslashes($_REQUEST['departureDate'])));
            $vehicleType = $database -> escape_value(trim(stripslashes($_REQUEST['vehicleType'])));

						/*
						 * < filtering the input and protecting form mysql injection >
						 * if the user enters special characters, we replace it with blank to prevent mysql injection
						 * Note: special characters are invalid for product code and name
						 */
						/*
						 * NOTE: the preg_replace() function is used for single key word search
						 * Here,we the name of product might contain many words, so we will ignore this function
						 * here
						 */
						// $product_search=preg_replace("#[^0-9a-z]#i","",$product_search);

						$sql = "SELECT * FROM  ticket WHERE  srcPlacce LIKE '%$srcPlace%' OR destPlace LIKE '%$destPlace%' OR departureDate LIKE '%$departureDate%' OR vehicleType = '$vehicleType' ORDER BY departureDate DESC";
            $tickets = $database->query($sql);
            $cnt = mysqli_num_rows ($tickets);

						if ($cnt != 0) // if the search input value matches to database then,
            {
							while($ticket = $database->fetch_array($tickets)){
                $vehicleId = $ticket['vehicleId'];
                $sql = "SELECT vehicleImg FROM vehicle WHERE vehicleId = '{$vehicleId}'";
                $result = $database->query($sql);
                $vehicle = $database->fetch_array($result);
                $vehicleImg = $vehicle['vehicleImg'];

                $departureTime = $ticket["departureTime"];
                $hourSep = stripos($departureTime,":");

                $departureHour = substr($departureTime,0,$hourSep);
                $departureMinute = substr($departureTime,$hourSep+1,$hourSep+1);

                $arrivalTime = $ticket["arrivalTime"];
                $hourSep = stripos($arrivalTime,":");
                $arrivalHour = substr($arrivalTime,0,$hourSep);
                $arrivalMinute = substr($arrivalTime,$hourSep+1,$hourSep+1);

                $durationHours = (int) $arrivalHour - (int)$departureHour;
                $durationMinutes = (int)$arrivalMinute - (int)$departureMinute;
                $duration = $durationHours . ' H &  '.$durationMinutes.' M';
                ?>

                  <div class="ticket card" >
                          <div class="vehicle-img">
                              <a href="#">
                                  <img class = "card-img-top" src="admin/data/vehicleimgs/<?php echo $vehicleImg; ?>" alt="Men Shoes" style="width:100%">
                                  <div class="card-body">
                                    <h6 class="card-title text-center">
                                      <span style="float:left;"><?php echo $ticket['srcPlacce']; ?></span>
                                      <i class="fas fa-long-arrow-alt-right text-success" style="align:center;"></i>
                                      <span style="float:right;"><?php echo $ticket['destPlace']; ?></span>
                                      <p class="text-center"><small><?php echo $ticket['distance']; ?></small></p>
                                    </h6>
                                    <h6 class="card-title text-center">
                                      <span style="float:left;"><?php echo $ticket['departureDate']; ?></span>
                                      <i class="fas fa-long-arrow-alt-right text-success" style="align:center;"></i>
                                      <span style="float:right;"><?php echo $ticket['arrivalDate']; ?></span>
                                    </h6>
                                    <div class="text-center">
                                      <span style="float:left;"><small class="font-weight-bold"><?php echo $ticket['departureTime']; ?></small></span>
                                      <span style="align:center;"><small><?php echo $duration; ?></small> </span>
                                      <span style="float:right;" class="font-weight-bold"><small class="font-weight-bold"><?php echo $ticket['arrivalTime']; ?></small></span>
                                    </div>
                                    <hr />
                                    <p class="card-text text-center">
                                      <span style="float:left;">Vehicle Type: <?php echo $ticket['vehicleType']; ?></span>
                                      <span style="float:right;">Set No: <?php echo $ticket['setNo']; ?></span>
                                    </p><br />
                                    <p class="card-text text-center">
                                      <span style="text-align: center;" class="text-primary font-weight-bold">Price: <?php echo $ticket['price']; ?></span>
                                    </p>
                                </div>
                              </a>
                          </div>
                          <p class="card-text mb-2" style="text-align: center;">
                            <a href="index.php?ticketId=<?php echo $ticket['ticketId']; ?>" type="button" class="btn btn-success btn-sm" style="margin-top:.5em;">Book Now</a>
                          </p>
                      </div>
                      <?php
							        }
						} else // if the search input doesn't match to any data of product table then,
							echo '<div class="col-md-3 h8idden-sm-down">No ticket found for your search! Please specify the search criteria.Thank you for being with us!</div>';
					}
          echo '</div></div>';
					?>
      <?php include 'include/quick_book.php'; ?>
      <?php include 'include/about_us.php'; ?>
      <?php include 'include/feedback.php'; ?>
    </main>
      <?php include 'include/footer.php'; ?>
      <!-- scripts -->
      <?php include 'include/pagecomn_scripts.php'; ?>
      <!-- ticket search -->
      <script src="plugins/select2dropdown/js/select2.min.js"></script>
      <script src="plugins/select2dropdown/js/select2-custom.js"></script>
      <!-- quick ticket book slider -->
      <script src="plugins/owlcarousel/js/owl.carousel.js"></script>
      <script src="assets/js/quick-book-slider.js"></script>
      <script src="assets/js/script.js"></script>

    <!-- alert the client for successful or failure registeration/login -->
    <?php
				if (isset($_SESSION['type'] )) {
					echo $_SESSION['msg'];
          unset($_SESSION['msg']);
          unset($_SESSION['type']);
					/*
					 * After first time log in the message session($_SESSION['msg']) should be unset.
					 * If it is not unset, the client will get log in message at very time he/she refreshes the page.
					 */
				}
        if (isset($_SESSION['loginMsg'] )) {
					echo $_SESSION['loginMsg'];
          unset($_SESSION['loginMsg']);
          unset($_SESSION['loginStatus']);

				}

        if (isset($_SESSION['feedbackMsg'])){
            echo $_SESSION['feedbackMsg'];
            unset($_SESSION['feedbackMsg']);

          }

          if(isset($_SESSION['updateMsg'])){
            echo $_SESSION['updateMsg'];
            unset($_SESSION['updateMsg']);
            unset($_SESSION['updateStatus']);
          }

          if(isset($_SESSION['resetPassMsg'])){
            echo $_SESSION['resetPassMsg'];
            unset($_SESSION['resetPassMsg']);
            unset($_SESSION['resetPassStatus']);
          }

          if(isset($_SESSION['emailCheckMsg'])){
            echo $_SESSION['emailCheckMsg'];
            unset($_SESSION['emailCheckMsg']);
            unset($_SESSION['type']);
          }

          if(isset($_SESSION['clientResetPasswordStatus'])){
            echo $_SESSION['clientResetPasswordMsg'];
            unset($_SESSION['clientResetPasswordMsg']);
            unset($_SESSION['clientResetPasswordStatus']);
          }

          if(isset($_SESSION['bookTicketMsg'])){
            echo $_SESSION['bookTicketMsg'];
            unset($_SESSION['bookTicketMsg']);
            unset($_SESSION['bookTicketStatus']);
          }
				?>
</body>
</html>
