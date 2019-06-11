<!-- view for search page of vendors-->
<?php
include "connection.php";
include "cekvendor.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title> Vendor Search Page</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Vendor search page</title>

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

			function ajaxHandler()
			{
			//function to handle fetchrange and fetchorder
var value = $("#fetchrange").val();
var orderValue = $("#fetchorder").val();
$.ajax(
{
	url:'sortajax3.php',
	type:'POST',
	data:'request='+value+'&request2='+orderValue,
	beforesend:function()
	{
		$("#tablecontainer").html('working on...');
	},
	success:function(data)
	{
		$("#tablecontainer").html(data);
	},
});
}
$("#fetchrange").on('change',ajaxHandler);
$("#fetchorder").on('change',ajaxHandler);
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
						<a class="nav-link" href="halvendor.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item ">
						<a class="nav-link" href="upload.php">Upload Commodity</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link" href="">check leader board</a>
					</li>
					<li class="nav-item">
						<a  class="nav-link" href="logout.php">Logout</a>
					</li>
				</ul>  
				<form action="search1.php" method="POST" class="form-inline my-2 my-lg-0" >
					<input class="form-control mr-sm-2" type="search" name="search" placeholder="Enter commodityname"  required>
					<button class="btn btn-primary my-2 my-sm-0" type="submit" name="submit-search" <?php 
					if(isset($_POST['submit-search'])){
						echo "value=".mysqli_real_escape_string($connection, $_POST['search']) ;
					}
					?>> SEARCH</button>
				</form> 
			</div>  
		</div>    
	</nav><br /><br />
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
			<div class="col-md-2">
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
		</div><br />
		<div class="row">
			<div class="col-md-9">
				<table class="table  table-hover table-sm table-striped border-right-0 border-left-0" id="tablecontainer">
					<thead class="thead-dark" >
						<tr>
							<th>Commodity Image</th>
							<th>Commodity Name</th>
							<th>Uploaded By</th>
							<th>Price in Ksh</th>
						</tr>
					</thead>
					<tbody id="commodityvalues">
						<?php 
						if(isset($_POST['submit-search'])){
							$search= mysqli_real_escape_string($connection, $_POST['search']);
							$_SESSION['search'] = $search;
							// //if statement to deal with specific sorted search queries
							// if($_POST)
							//First search query to fetch vendor id from vendor table
							$sql1=" SELECT idvendor FROM vendor WHERE username LIKE '%$search%'";
							$result1= mysqli_query($connection, $sql1);
							echo mysqli_error($connection);
							$queryresults1 = mysqli_fetch_array($result1)[0];
							// assign idvendor in commodity table to fetched id vendor from $queryresult1
							if($queryresults1){
								$sql = "SELECT * FROM commodity_table WHERE idvendor= $queryresults1 ORDER BY commodityprice ASC";
							} else{
								$sql=" SELECT * FROM commodity_table  WHERE commodityname LIKE '%$search%' OR commodityprice LIKE '%$search%' ORDER BY commodityprice ASC";
							}
							$result = mysqli_query($connection, $sql);
							$queryresults = mysqli_num_rows($result);
							echo "There are ".$queryresults." results for <div id='searchterm'>$search</div>";

							if( $queryresults > 0 )
							{
								while( $row = mysqli_fetch_array( $result )) { 
									?>
									<div>

										<form <?php echo $row['idcommodity'];
										$vendor ="SELECT username FROM vendor WHERE idvendor = ".$row['idvendor'];
										$vendor = mysqli_query($connection, $vendor);
										$vendor =  mysqli_fetch_array( $vendor )[0];
										?>>
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
								}else{ echo 'There are no result matching your search';}}
								mysqli_close($connection);
								?> 
							</div>
						</div><br /> 
						<footer class="py-5 bg-dark">
							<div class="container">
								<p class="m-0 text-center text-white">Copyright &copy; Powell Ragot 2018</p>
							</div>
						</footer> 	  	
					</body>
					</html>