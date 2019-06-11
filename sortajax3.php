<?php 
include "connection.php";
include "cekvendor.php";

$search = $_SESSION['search'];
$orderRange=$_POST['request'];
$orderBy = $_POST['request2'];
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
// assign idvendor in commodity table to fetched id vendor from $queryresult1
if($queryresults1){
	$sql = "SELECT * FROM commodity_table WHERE idvendor= $queryresults1 AND commodityprice BETWEEN $lower AND $upper ORDER BY commodityprice $orderBy";
}else{
	$sql=" SELECT * FROM commodity_table  WHERE commodityname LIKE '%$search%' OR commodityprice LIKE '%$search%' AND commodityprice BETWEEN $lower AND $upper ORDER BY commodityprice $orderBy";
}
$result = mysqli_query($connection, $sql);
$queryresults = mysqli_num_rows($result);
if( $queryresults > 0 )
{
	echo '<table class="table  table-hover table-sm table-striped border-right-0 border-left-0" id="tablecontainer">
	<thead class="thead-dark" >
	<tr>
	<th>Commodity Image</th>
	<th>Commodity Name</th>
	<th>Uploaded By</th>
	<th>Price in Ksh</th>
	</tr>
	</thead>
	<tbody id="commodityvalues">';
	while( $row = mysqli_fetch_array( $result )) { 
		?>
		<div>

			<form> <?php
			$vendor ="SELECT username FROM vendor WHERE idvendor = ".$row['idvendor'];
			$vendor = mysqli_query($connection, $vendor);
			$vendor =  mysqli_fetch_array( $vendor )[0];
			?>

			<tr>
				<td> <img src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?>" class=class="img-thumbnail"  width="50px" height="50px" /></td>
				<td><?php echo $row["commodityname"]; ?></td>
				<td><?php echo $vendor; ?></td>
				<td><?php echo $row["commodityprice"]; ?></td>
			</tr>
		</form>
		<?php
		}echo "</tbody>
		</table></div>";
	}else{ echo 'There are no result matching your search range';}
	?>