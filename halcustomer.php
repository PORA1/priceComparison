<!-- main customer screen -->
<?php
include('cekcustomer.php');
include "connection.php";
//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer page</title>

  <!-- CSS -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!--  script -->
  <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
  <!--  Navigation  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="halcustomer.php">PRICE COMPARISON</a>
      <!-- togglebutton -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!--  nav content -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item active">
            <a class="nav-link" href="halcustomer.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">check leader board</a>
          </li>
          <li class="nav-item">
            <a  class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>  
        <form action="search.php" method="POST" class="form-inline my-2 my-lg-0" >
          <input class="form-control mr-sm-2" type="search" name="search" placeholder="Enter commodity/vendor name"  required style="width:300px;">
          <button class="btn btn-primary my-2 my-sm-0" type="submit" name="submit-search" > SEARCH
          </button>
        </form> 
      </div>  
    </div>    
  </nav>

  <div class="container">
    <!--   page features -->
    <div>
      <h3>Customer Account: <?php echo $_SESSION['username']; ?></h3>
      <h3 align="center">Top 3 Recent Uploads:</h3><br /><br /> 
    </div>

    <div class="row">
<?php
$query = "SELECT * FROM commodity_table ORDER BY idcommodity DESC LIMIT 3 ";

$result = mysqli_query($connection, $query);

if(mysqli_num_rows ( $result ) > 0)
{
  while( $row = mysqli_fetch_array( $result )) { 
    ?>
    <div class="col-md-3">
      <form method="post" action="cart1_update.php"><?php

      $vendor ="SELECT username FROM vendor WHERE idvendor = ".$row['idvendor'];
      $vendor = mysqli_query($connection, $vendor);
      $vendor =  mysqli_fetch_array( $vendor )[0];

      //to handle opening of specific pages for each commodity using id
      $idcommodityquery = "SELECT idcommodity FROM commodity_table WHERE idcommodity = ".$row['idcommodity'];
      $idcommodity = mysqli_query($connection, $idcommodityquery);
      $idcommodity =  mysqli_fetch_array( $idcommodity )[0];
      //average rating query
      $query1="SELECT AVG(ratings) FROM commodity_ratings WHERE idcommodity = $idcommodity";
      $rating= mysqli_query($connection, $query1);
      $rating=mysqli_fetch_array($rating)[0];

      ?>
      <div style="border: 1px solid #333;  background-color: #f1f1f1; border-radius:5px; padding:16px; align="center">
        <a href="commodity.php?id=<?php echo $idcommodity?>"> <img  alt="Error loading image" width="100px" height="100px" data-toggle="tooltip" data-placement="top" title="Click image to rate pricing information" src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?>" /></a>
        <ul style="list-style-type:none; padding:0; margin:0;">
          <li class="text-info"><?php echo $row["commodityname"]; ?></li>
           <li class="text-info"><?php echo $row["commoditybrand"]; ?></li>
          <li class="text-info"><?php echo $vendor; ?></li>
          <li class="text-danger"><?php echo $currency ?><?php echo $row["commodityprice"]; ?></li>
        </ul> 
        <div class="article-rating">Price Rating:<?php echo round($rating)?>/5</div>
        <input type="text" size="2" maxlength="2" name="product_qty" value="1" data-toggle="tooltip" data-placement="top" title="Enter quantity of product for shopping cart"/><br /><br />
        <input type="hidden"  name="product_code" value="<?php echo $idcommodity?>" />
        <input type="hidden"  name="type" value="add" />
        <input type="hidden"  name="return_url" value="<?php echo $current_url?>" />
        <div align="center"><button type="submit" class="btn btn-primary my-2 my-sm-0 add_to_cart" data-toggle="tooltip" data-placement="top" title="Click to add to shopping cart">Add</button></div>
      </div><br/>
    </form>
  </div> 
  
  <?php
}
}
?>
<div class="col-md-3">
   <!-- View Cart Box Start -->
<?php
if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
{
  echo '<div class="cart-view-table-front" id="view-cart">';
  echo '<h3>Your Shopping Cart</h3>';
  echo '<form method="post" action="cart1_update.php">';
  echo '<table width="100%"  cellpadding="6" cellspacing="0">';
  echo '<tbody>';

  $total =0;
  $b = 0;
  foreach ($_SESSION["cart_products"] as $cart_itm)
  {
    $product_name = $cart_itm["product_name"];
    $product_qty = $cart_itm["product_qty"];
    $product_price = $cart_itm["product_price"];
    $product_code = $cart_itm["product_code"];
    $bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
    echo '<tr class="'.$bg_color.'">';
    echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" data-toggle="tooltip" data-placement="top" title="Click update on change of quantity"/></td>';
    echo '<td>'.$product_name.'</td>';
    echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
    echo '</tr>';
    $subtotal = ($product_price * $product_qty);
    $total = ($total + $subtotal);
  }
  echo '<td colspan="4">';
  echo '<button type="submit" class="btn btn-primary my-2 my-sm-0">Update</button>
  <a href="view_cart.php" class="btn btn-primary my-2 my-sm-0">Checkout</a>';
  echo '</td>';
  echo '</tbody>';
  echo '</table>';
  
  $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
  echo '</form>';
  echo '</div>';

}
?>
<!-- View Cart Box End --> 
</div>
<?php mysqli_close($connection);?>
</div>
</div>	
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">&copy; 2018-<?php echo date("Y");?></p>
  </div>
</footer>  	
<script>
// function to pop tool tip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>