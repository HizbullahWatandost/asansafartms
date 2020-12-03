<!-- foooter -->
<!-- fetching contact us details-->
<?php
  $sqlQuery = "SELECT * FROM contactus LIMIT 1";
  $result = $database->query($sqlQuery);
  $result = mysqli_fetch_array($result);
  $address = $result['address'];
  $email = $result['email'];
  $contactNo1 = $result['contactNoOne'];
  $contactNo2 = $result['contactNoTwo'];
  $websiteShortDesc = $result['webShortDesc'];
  $domainName = $result['domainName'];
 ?>
<footer class="page-footer font-small footer-bg" style="border-right:3em solid #28a745;" id="contact_us">
  <div class="bg-success">
    <div class="container">

      <!-- Grid row-->
      <div class="row py-4 d-flex align-items-center text-white">

        <!-- Grid column -->
        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
          <h6 class="mb-0">Get connected with us on social networks!</h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-6 col-lg-7 text-center text-md-right">

          <!-- Facebook -->
          <a class="fb-ic">
            <i class="fab fa-facebook-f white-text mr-4"> </i>
          </a>
          <!-- Twitter -->
          <a class="tw-ic">
            <i class="fab fa-twitter white-text mr-4"> </i>
          </a>
          <!-- Google +-->
          <a class="gplus-ic">
            <i class="fab fa-google-plus-g white-text mr-4"> </i>
          </a>
          <!--Linkedin -->
          <a class="li-ic">
            <i class="fab fa-linkedin-in white-text mr-4"> </i>
          </a>
          <!--Instagram-->
          <a class="ins-ic">
            <i class="fab fa-instagram white-text"> </i>
          </a>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->

    </div>
  </div>

  <!-- Footer Links -->
  <div class="container text-center mt-5 text-white text-center">

    <!-- Grid row -->
    <div class="row mt-3">

      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

        <!-- Content -->
        <h6 class="text-uppercase font-weight-bold">Asan Safar</h6>
        <hr class="stylish-hr" style="width: 160px;">
        <p class="text-justify" style="padding-left: 1.5em;"><?php echo isset($websiteShortDesc) ? $websiteShortDesc : "Asan Safar helps you to easily reserve a set for your trip from any place to any destination within Afghanistan. With Asan Safar you will have a conveient trip."; ?></p>

      </div>

      <!-- Grid column -->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4 text-center">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Useful links</h6>
        <hr class="stylish-hr" style="width: 160px;">
        <div class="text-md-left" style="padding-left: 1.5em;">
          <p>
            <i class="fas fa-hand-point-right"></i>
            <a href="#!" class="text-white"> About Us </a>
          </p>
          <p>
            <i class="fas fa-hand-point-right"></i>
            <a href="#!"class="text-white"> Contact Us </a>
          </p>
          <p>
            <i class="fas fa-hand-point-right"></i>
            <a href="#!"class="text-white">Feedback</a>
          </p>
          <p>
            <i class="fas fa-hand-point-right"></i>
            <a href="#!"class="text-white"> Any Complain? </a>
          </p>
        </div>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4 text-center">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Contact</h6>
        <hr class="stylish-hr" style="width: 160px;">

        <div class="text-md-left" style="padding-left: 2.5em;">
          <p>
            <i class="fas fa-home mr-1"></i><?php echo isset($address) ? $address : "Kabul, Timany, AF"; ?> </p>
            <p>
              <i class="fas fa-envelope mr-1"></i> <?php echo isset($email) ? $email : "info@asansafar.af"; ?> </p>
              <p>
                <i class="fas fa-phone mr-1"></i> <?php echo isset($contactNo1) ? $contactNo1 : "+ 93 (0) 20 300 40 500"; ?></p>
                <p>
                  <i class="fas fa-print mr-1"></i><?php echo isset($contactNo2) ? $contactNo2 : "+ 93 (0) 79 889 89 899"; ?></p>
                </div>
              </div>
              <!-- Grid column -->
            </div>
            <!-- Grid row -->
          </div>
          <!-- Footer Links -->
          <!-- Copyright -->
          <div class="footer-copyright text-center py-3 bg-dark text-white" style="border-right: 10em solid #28a745;">Copyright © <?php echo date('Y'); ?>
            <span><?php echo isset($domainName) ? $domainName : " asansafar.af"; ?></span>
          </div>
          <!-- Copyright -->
          <button id="backToTop" title="Go to top"><i class="fas fa-angle-up" aria-hidden="true" style="font-size: 1.5em;"></i></button>
</footer>
