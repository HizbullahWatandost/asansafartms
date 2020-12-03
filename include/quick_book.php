<div class="container-quick-ticket-book clearfix">
    <div class="container">
      <div class="page-header menus-container quick-ticket-book" id="quick_book_discount_offers">
        <h3 class="text-default text-uppercase text-success"> Quick Books - offers & discounts </h3>
        <div class="container mt-3">
            <div class="row w-100 mx-auto">
                <div class="owl-carousel owl-theme owl-loaded">
                    <?php
                    $quickBookTicket = "SELECT * FROM  ticket WHERE  distance >= 0 order by discount desc";
                    $quiickBookTicekts = $database->query($quickBookTicket);
                    $ticketCount = mysqli_num_rows ($quiickBookTicekts);

                    if ($ticketCount != 0) // if the search input value matches to database then,
                    {
                      while($quickBookTicket = $database->fetch_array($quiickBookTicekts)){
                        $vehicleId = $quickBookTicket['vehicleId'];
                        $sql = "SELECT vehicleImg FROM vehicle WHERE vehicleId = '{$vehicleId}'";
                        $result = $database->query($sql);
                        $vehicle = $database->fetch_array($result);
                        $vehicleImg = $vehicle['vehicleImg'];



                        $departureTime = $quickBookTicket["departureTime"];
                        $hourSep = stripos($departureTime,":");

                        $departureHour = substr($departureTime,0,$hourSep);
                        $departureMinute = substr($departureTime,$hourSep+1,$hourSep+1);

                        $arrivalTime = $quickBookTicket["arrivalTime"];
                        $hourSep = stripos($arrivalTime,":");
                        $arrivalHour = substr($arrivalTime,0,$hourSep);
                        $arrivalMinute = substr($arrivalTime,$hourSep+1,$hourSep+1);

                        $durationHours = (int) $arrivalHour - (int)$departureHour;
                        $durationMinutes = (int)$arrivalMinute - (int)$departureMinute;
                        $duration = $durationHours . ' H &  '.$durationMinutes.' M';
                        ?>
                    <div class="item">
                      <div class="card">
                        <img class="card-img-top" src="admin/data/vehicleimgs/<?php if(isset($vehicleImg)) echo $vehicleImg; ?>" alt="Card image cap">
                        <div class="card-body">
                          <h6 class="card-title text-center">
                            <span style="float:left;"> <?php if(isset($quickBookTicket['srcPlacce'])) echo $quickBookTicket['srcPlacce']; ?> </span>
                            <i class="fas fa-long-arrow-alt-right text-success" style="align:center;"></i>
                            <span style="float:right;"><?php if(isset($quickBookTicket['destPlace'])) echo $quickBookTicket['destPlace']; ?> </span>
                            <p class="text-center"><small><?php if(isset($quickBookTicket['distance'])) echo $quickBookTicket['distance']; ?></small></p>
                          </h6>
                          <h6 class="card-title text-center">
                            <span style="float:left;"> <?php if(isset($quickBookTicket['departureDate'])) echo $quickBookTicket['departureDate']; ?> </span>
                            <i class="fas fa-long-arrow-alt-right text-success" style="align:center;"></i>
                            <span style="float:right;"><?php if(isset($quickBookTicket['arrivalDate'])) echo $quickBookTicket['arrivalDate']; ?> </span>
                          </h6>
                          <div class="text-center">

                            <span style="float:left;"><small class="font-weight-bold"><?php if(isset($quickBookTicket['departureTime'])) echo $quickBookTicket['departureTime']; ?></small></span>

                            <span style="align:center;"><small><?php if(isset($duration)) echo $duration; ?></small> </span>
                            <span style="float:right;" class="font-weight-bold"><small class="font-weight-bold"><?php if(isset($quickBookTicket['arrivalTime'])) echo $quickBookTicket['arrivalTime']; ?></small></span>
                          </div>
                          <hr />
                          <p class="card-text text-center">
                            <span style="float:left;">
                              <i class="fas fa-star text-warning"></i>
                              <?php if(isset($quickBookTicket['discount'])) echo $quickBookTicket['discount']; ?>% <small>discount</small></span>
                            <span style="float:right;" class="text-primary font-weight-bold"><?php if(isset($quickBookTicket['price'])) echo $quickBookTicket['price']; ?></span>
                          </p>
                          <p class="card-text text-center">
                            <span style="float:left;">Vehicle: <?php if(isset($quickBookTicket['vehicleType'])) echo $quickBookTicket['vehicleType']; ?></span>
                            <span style="float:right;">Set No: <?php if(isset($quickBookTicket['setNo'])) echo $quickBookTicket['setNo']; ?></span>
                          </p>
                        </div>
                        <p class="card-text text-center mb-1">
                          <a href="index.php?ticketId=<?php echo $quickBookTicket['ticketId']; ?>" class="btn btn-success btn-sm" style="margin-top:1.5em;">Book Now</a>
                        </p>
                      </div>
                    </div>

                  <?php }
                } else{ // if the search input doesn't match to any data of product table then,
    							echo '<div class="col-md-3 h8idden-sm-down">No ticket found for your search! Please specify the search criteria.Thank you for being with us!</div>';
                }
                ?>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
