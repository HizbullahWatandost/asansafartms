<?php include ('./inc/client_register.php'); ?>
<?php include ('./inc/client_login.php'); ?>
<!-- slide show -->
<div class="bd-example text-success" id="home">
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <?php
      $array = array();
      $count = 0;
      $webslides = "SELECT * FROM webslide LIMIT 3";
      $result = $database->query($webslides);
      while($slide = $database->fetch_array($result)){
        $array[$count] = array();
        $array[$count]['slideImg'] = $slide['slideImg'];
        $array[$count]['slideTitle'] = $slide['slideTitle'];
        $array[$count]['slideDescription'] = $slide['slideDescription'];
        $count++;
      }
     ?>
    <div class="carousel-inner">
      <!-- retrevining website slide show details from database -->
      <div class="carousel-item active">
        <img src="<?php echo isset($array[0]['slideImg']) ? 'admin/imgs/slideshow/'.$array[0]['slideImg'] : 'assets/images/slideshow/slideshow_1.png'; ?>" alt="..." class="d-block w-100" />
        <div class="carousel-caption d-none d-md-block" style="color: darkgreen;">
          <h5><?php echo isset($array[0]['slideTitle']) ? $array[0]['slideTitle'] : 'AsanSafar Transportation System'; ?></h5>
          <p><?php echo isset($array[0]['slideDescription']) ? $array[0]['slideDescription'] : 'AsanSafar Transportation System'; ?></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?php echo isset($array[1]['slideImg']) ? 'admin/imgs/slideshow/'.$array[1]['slideImg'] : 'assets/images/slideshow/slideshow_2.png'; ?>" alt="..." class="d-block w-100" />
        <div class="carousel-caption d-none d-md-block" style="color: darkgreen;">
          <h5><?php echo isset($array[1]['slideTitle']) ? $array[1]['slideTitle'] : 'AsanSafar Transportation System'; ?></h5>
          <p><?php echo isset($array[1]['slideDescription']) ? $array[1]['slideDescription'] : 'AsanSafar Transportation System'; ?></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?php echo isset($array[2]['slideImg']) ? 'admin/imgs/slideshow/'.$array[2]['slideImg'] : 'assets/images/slideshow/slideshow_3.png'; ?>" alt="..." class="d-block w-100" />
        <div class="carousel-caption d-none d-md-block" style="color: darkgreen;">
          <h5><?php echo isset($array[2]['slideTitle']) ? $array[2]['slideTitle'] : 'AsanSafar Transportation System'; ?></h5>
          <p><?php echo isset($array[2]['slideDescription']) ? $array[2]['slideDescription'] : 'AsanSafar Transportation System'; ?></p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev" style="color: !black;">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only" style="color: !black;">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
