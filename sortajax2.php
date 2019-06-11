<?php 
include "connection.php";
include "cekcustomer.php";
//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$search = $_SESSION['search'];
$orderRange=$_POST['pricerange'];
$orderBy = $_POST['pricesort'];
$brandValue = $_POST['brandValue'];
// echo $orderRange;
// $brandvalue='Elianto';
switch($orderRange)
{
	case 'all':
	$lower=0;
	$upper=1000000000;
	break;
	case '1st':
	$lower=0;
	$upper=250;
	break;
	case '2nd':
	$lower=251;
	$upper=500;
	break;
	case '3rd':
	$lower=501;
	$upper=750;
	break;
	case '4th':
	$lower=751;
	$upper=1000;
	break;
	default:
	$lower=1001;
	$upper=1000000;
}

//First search query to fetch vendor id from vendor table
$sql1=" SELECT idvendor FROM vendor WHERE username LIKE '%$search%'";
$result1= mysqli_query($connection, $sql1);
$queryresults1 = mysqli_fetch_array($result1)[0];
// echo $rt;
// assign idvendor in commodity table to fetched id vendor from $queryresult1
if($queryresults1){
	$sql = "SELECT * FROM commodity_table WHERE idvendor= $queryresults1 AND commodityprice BETWEEN $lower AND $upper ORDER BY commodityprice $orderBy";
	
}else if($brandValue){	
	$sql=" SELECT * FROM commodity_table  WHERE commodityprice BETWEEN $lower AND $upper and commoditybrand like '%$brandValue%' and commodityname LIKE '%$search%' OR commodityprice LIKE '%$search%' ORDER BY commodityprice $orderBy";
	
	}else {
		$sql=" SELECT * FROM commodity_table  WHERE commodityprice BETWEEN $lower AND $upper and commodityname LIKE '%$search%' OR commodityprice LIKE '%$search%' ORDER BY commodityprice $orderBy";
		
	}	

$result = mysqli_query($connection, $sql);
echo mysqli_error($connection);
$queryresults = mysqli_num_rows($result);
echo "<div class= 'row'>";
if( $queryresults > 0 )
{
	echo '<div class="col-md-9">';
	echo '<table class="table  table-hover table-sm table-striped border-right-0 border-left-0" id="tablecontainer" class="col-md-9">';
	echo '<thead class="thead-dark" >';
	echo '<tr>';
	echo '<th>Commodity Image</th>';
	echo '<th>Commodity Name</th>';
	echo'<th>Uploaded By</th>';
	echo '<th>Price in Ksh</th>';
	echo '<th>Enter Quantity</th>';
	echo  '<th>Buy Product</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody id="commodityvalues">';

	while( $row = mysqli_fetch_array( $result )) { 
		?>
		<div>
			<form method="post" action="cart1_update.php"> 
			<?php
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
				<td><?php echo $row["commodityname"]; ?></td>
				<td><?php echo $vendor; ?></td>
				<td><?php echo $row["commodityprice"]; ?></td>
				<td><input type="text" size="2" maxlength="2" name="product_qty" value="1" /></td>
				<input type="hidden" name="product_code" value="<?php echo $idcommodity?>" />
				<input type="hidden"name="type" value="add" />
				<input type="hidden" name="return_url" value="<?php echo $current_url?>" />
				<td><button type="submit" class="btn btn-primary my-2 my-sm-0"id="cartbtn">Add To Cart</button>
											</td>
			</tr>
		</form>
		<?php
		}
		echo '</tbody>';
		echo '</table></div>';
	}else{ echo 'There are no result matching your search range';}
	echo '</div>';

	?>