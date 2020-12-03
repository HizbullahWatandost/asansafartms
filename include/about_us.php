<?php
  $sqlQuery = "SELECT * FROM websiteabout LIMIT 1";
  $result = $database->query($sqlQuery);
  $result = mysqli_fetch_array($result);
  $aboutWebsite = $result['about'];
 ?>
<div class="menus-container container-about">
  <div class="container">
    <div class="page-header menus-container subcontainer-about" id="about_us">
      <h3 class="text-center text-success text-uppercase">Asan Safar</h3>
      <p class="text-justify"><?php echo isset($aboutWebsite) ? $aboutWebsite : "
        Bus Management System is a system that developed to make the
        management of bus driver and bus trip at Transnasional Express Sdn Bhd Kuantan
        Branch become easier. At this time, this company only has online ticketing system
        and still do not has computerized management system for their company operation.
        Therefore, all the data and information that related with driver and bus trip is
        documented and kept in file base system. Manual system in record keeping make an
        important data or information has a potential to lost or damage. Besides, driver
        scheduling is assigned by operation officer manually and the operation officer must
        prepare the schedule everyday before the driver start their trip. Therefore,
        computerized driver scheduling is suggested to make the management of driver
        schedule become easier. RAD model is used as a process model and Microsoft
        Visual Basic 6.0 and Microsoft Access is used as a tool for Bus Management System
        development. Besides, the prototype for bus management system successfully
        developed to make the management work become more effective. ";?>
      </p>
    </div>
  </div>
</div>
