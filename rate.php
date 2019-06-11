<!-- background handler on rate click page -->
<?php
include "connection.php";  

if(isset($_GET['commodity'],$_GET['rating']))
{
	$commodity = mysqli_real_escape_string ($connection, $_GET['commodity']);
// echo $commodity;
	$rating = mysqli_real_escape_string ($connection, $_GET['rating']);
// echo $rating;

	if(in_array($rating, [1,2,3,4,5]))
	{
		$exist= mysqli_query($connection, "SELECT idcommodity FROM commodity_table WHERE idcommodity=$commodity ");

		$queryresults = mysqli_num_rows($exist);

		if($queryresults)
		{

			mysqli_query($connection, "INSERT INTO commodity_ratings (idcommodity,ratings) VALUES('$commodity','$rating')");

			echo "successfully rated !";
		}
	}
	header("Location: commodity.php?id=$commodity");

}

?>
