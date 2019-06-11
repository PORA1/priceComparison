<!-- view for search page of elements -->
<?php
include "connection.php";
include "cekcustomer.php";
//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>customer search page</title>

	<!-- CSS -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- scripts -->
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	<!-- script to handle sort by price -->
	<script>
		$(document).ready(function()
		{
			function ajaxHandler2(){
				alert(5);
			}

			function ajaxHandler()
			{
//function to handle fetchrange and fetchorder and brandvalue
var pricerange = $("#fetchrange").val();
var pricesort = $("#fetchorder").val();
var brandValue = $("#fetchbrand").val();
$.ajax(
{
	url:'sortajax2.php',
	type:'POST',
	data:'pricerange='+pricerange+'&pricesort='+pricesort+'&brandValue='+brandValue,
	beforesend:function()
	{
		$("#tablecontainer").html('working on...');
	},
	success:function(data)
	{
		console.log(pricerange)
		$("#tablecontainer").html(data);
	},
});
}
$("#fetchrange").on('change',ajaxHandler);
$("#fetchorder").on('change',ajaxHandler);
$("#fetchbrand").on('change',ajaxHandler);
$("#cartbtn").on('click',ajaxHandler);
// $("#cartbtn2").on('click',ajaxHandler2);
});
</script>
</head>
<body>
	<!--  Navigation  -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<a class="navbar-brand" href="halcustomer.php">PRICE COMPARISON</a>
			<!-- togglebutton -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="				#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="		Toggle navigation">
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
						<a a class="nav-link" href="logout.php">Logout</a>
					</li>
				</ul>  

				<form action="search.php" method="POST" class="form-inline my-2 my-lg-0" >
					<input class="form-control mr-sm-2" type="search" name="search" placeholder="Enter commodityname"  required>
					<button class="btn btn-primary my-2 my-sm-0" type="submit" name="submit-search" <?php 
					if(isset($_POST['submit-search'])){
						echo "value=".mysqli_real_escape_string($connection, $_POST['search']) ;
					}
					?>> SEARCH</button>
				</form> 
			</div>  
		</div>    
	</nav><br />
	<div class="container">
		<!-- page features -->
		<div class="row">
			<!-- sorting search results using options -->
			<div class="col-md-3">
				<label> Sort By Pricing Order:</label>
				<select name="filter" id="fetchorder" name="fetchby">
					<option value="ASC">Cheapest to Expensive</option>
					<option value="DESC">Expensive to Cheapest</option>
				</select>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-3">
				<label> Sort By Pricing Range:</label>
				<select name="filter" id="fetchrange" name="fetchby1">
					<option value="all">All</option>
					<option value="1st">0-250</option>
					<option value="2nd">250-500</option>
					<option value="3rd">500-750</option>
					<option value="4th">750-1000</option>
					<option value="5th">1000 and above</option>
				</select>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-3">
				<label> Enter Brand:</label>
				<input type="text" name="sortbrand" id="fetchbrand" data-toggle="tooltip" data-placement="top" title="Enter brand of searched commodity">
			</div>

		</div><br />
		<div class="row">
			<div class="col-md-9">
				<table class="table  table-hover table-sm table-striped border-right-0 border-left-0" id="tablecontainer">
					<thead class="thead-dark" >
						<tr>
							<th> Image</th>
							<th>Commodity</th>
							<th>Price Ksh</th>
							<th>Enter Quantity</th>
							<th>Buy Product</th>
						</tr>
					</thead>
					<tbody id="commodityvalues">
						<?php 
						if(isset($_POST['submit-search'])){
							$search= mysqli_real_escape_string($connection, $_POST['search']);
							$_SESSION['search'] = $search;
							// //if statement to deal with specific sorted search queries
							//First search query to fetch vendor id from vendor table
							$sql1=" SELECT idvendor FROM vendor WHERE username LIKE '%$search%'";
							$result1= mysqli_query($connection, $sql1);
							echo mysqli_error($connection);
							$queryresults1 = mysqli_fetch_array($result1)[0];
							// assign idvendor in commodity table to fetched id vendor from $queryresult1
							if($queryresults1){
								$sql = "SELECT * FROM commodity_table WHERE idvendor= $queryresults1 ORDER BY commodityprice ASC";
							} else{
								$sql=" SELECT * FROM commodity_table  WHERE commodityname LIKE '%$search%' OR commodityprice LIKE '%$search%'OR commoditybrand LIKE '%$search%' ORDER BY commodityprice ASC";
							}
							$result = mysqli_query($connection, $sql);
							$queryresults = mysqli_num_rows($result);
							echo "There are ".$queryresults." results for <div id='searchterm'>$search</div>";

							if( $queryresults > 0 )
							{
								while( $row = mysqli_fetch_array( $result )) { 
									?>
									<div>

										<form method="post" action="cart1_update.php"> <?php 
										$vendor ="SELECT username FROM vendor WHERE idvendor = ".$row['idvendor'];
										$vendor = mysqli_query($connection, $vendor);
										$vendor =  mysqli_fetch_array( $vendor )[0];
										//pick id vendor
										$idcommodityquery = "SELECT idcommodity FROM commodity_table WHERE idcommodity = ".$row['idcommodity'];
										$idcommodity = mysqli_query($connection, $idcommodityquery);
										$idcommodity =  mysqli_fetch_array( $idcommodity )[0];
										?>
										<tr>
											<td> <img src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?>" class=class="img-thumbnail"  width="50px" height="50px" /></td>
											<td><?php echo $row["commodityname"]; ?><br /><?php echo $row["commoditybrand"]; ?><br /><?php echo $vendor; ?></td>
											
											<td><?php echo $row["commodityprice"]; ?></td>
											<!-- shopping cart fetch values -->
											<td><input type="text" size="2" maxlength="2" name="product_qty" value="1" /></td>
											<input type="hidden" name="product_code" value="<?php echo $idcommodity?>" />
											<input type="hidden" name="type" value="add" />
											<input type="hidden" name="return_url" value="<?php echo $current_url?>" />
											<td><button type="submit" class="btn btn-primary my-2 my-sm-0"id="cartbtn">Add To Cart</button>
											</td>
										</tr>
									</form>
									<?php
									}echo "</tbody>
									</table></div>";
								}else{ echo 'There are no result matching your search';}}
								mysqli_close($connection);
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
											echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
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
</div>

</div><br /> 
<footer class="py-5 bg-dark">
	<div class="container">
		<p class="m-0 text-center text-white">Copyright &copy; Powell Ragot 2018</p>
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