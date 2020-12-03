<?php
    //collect the product search result
    if(isset($_POST['searchVal']))
    {
        $output="";//search result message
        $searchq=$_POST['searchVal'];
        //filtering the input
        $searchq=preg_replace("#[^0-9a-z]#i","",$searchq);
        $q= "SELECT * FROM  stock_details WHERE  product_code LIKE '%$product_search%' OR product_name LIKE '%$product_search%' OR product_desc LIKE '%$product_search%' ORDER BY quantity DESC";
        $r=mysqli_query($db->connection,$q);
        $cnt = mysqli_num_rows($r);
        if($cnt == 0)
            $output=" ";
        else
        {
            while ( $row = mysqli_fetch_array ( $result) )
            {
                $unser_photos = unserialize ( trim($row["photos"]) );
                ?>
        <div class="col-md-3 hidden-sm-down">
                    <img src="<?php echo count($unser_photos)>0 && $unser_photos[0]? "admin/upload/$unser_photos[0]" :  "img/p11.png";?>" class="img-fluid" alt="" title="">
                    <div class="text-xs-center">
                        <p><?php echo $row['product_code']; ?><br/><?php echo $row['product_name']; ?></p>
                        <a href="product_details.php?product=<?php echo $row['product_code'];?>">Know More</a>
                    </div>
                </div>
          <?php }
        }
    }
    echo ($output);

?>
