<!-- view page after the shopping cart is checked out -->
<?php
session_start();
include_once("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View shopping cart</title>

	<!-- CSS -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
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
							<a a class="nav-link" href="logout.php">Logout</a>
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
		<h1 align="center">View Cart</h1>
		<div class="cart-view-table-back">
			<form method="post" action="cart1_update.php">
				<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
					<tbody>
						<?php
if(isset($_SESSION["cart_products"])) //check session var
{
$total = 0; //set initial total value
$b = 0; //var for zebra stripe table 
foreach ($_SESSION["cart_products"] as $cart_itm)
{
//set variables to use in content below
	$product_name = $cart_itm["product_name"];
	$product_qty = $cart_itm["product_qty"];
	$product_price = $cart_itm["product_price"];
	$product_code = $cart_itm["product_code"];
$subtotal = ($product_price * $product_qty); //calculate Price x Qty

$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe 
echo '<tr class="'.$bg_color.'">';
echo '<td><input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
echo '<td>'.$product_name.'</td>';
echo '<td>'.$currency.$product_price.'</td>';
echo '<td>'.$currency.$subtotal.'</td>';
echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></td>';
echo '</tr>';
$total = ($total + $subtotal); //add subtotal to total var
}

$grand_total = $total + $shipping_cost; //grand total including shipping cost
foreach($taxes as $key => $value){ //list and calculate all taxes in array
	$tax_amount     = round($total * ($value / 100));
	$tax_item[$key] = $tax_amount;
$grand_total    = $grand_total + $tax_amount;  //add tax val to grand total
}

$list_tax       = '';
foreach($tax_item as $key => $value){ //List all taxes
	$list_tax .= $key. ' : '. $currency. sprintf("%01.2f", $value).'<br />';
}
$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
}
?>
<tr>
	<td colspan="5"><span style="float:right;text-align: right;"><?php echo $shipping_cost. $list_tax; ?>Amount Payable : <?php echo sprintf("%01.2f", $grand_total);?></span>
	</td>
</tr>
<tr>
	<td colspan="5"><a href="index.php" class="btn btn-primary my-2 my-sm-0">Add More Items</a>
		<button type="submit" class="btn btn-primary my-2 my-sm-0">Update</button></td>
	</tr>
</tbody>
</table>
<input type="hidden" name="return_url" value="<?php 
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
echo $current_url; ?>" />
</form>
</div><br />
<footer class="py-5 bg-dark">
	<div class="container">
		<p class="m-0 text-center text-white">&copy; 2018-<?php echo date("Y");?></p>
	</div>
</footer> 
</body>
</html>
