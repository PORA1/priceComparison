<!-- specific view page for each commodity -->
<?php
include('cekcustomer.php');
include "connection.php";           
?>
<!DOCTYPE html>
<html>
<head>

    <title>Commodity Rating Page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin DashBoard</title>
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
            <!-- toggle button for when the screen shrinks -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- link items to pages -->
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
                <!-- search button within the nav -->
                <form action="search.php" method="POST" class="form-inline my-2 my-lg-0" >
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search"  required>
                    <button class="btn btn-success-outline my-2 my-sm-0" type="submit" name="submit-search" > SEARCH</button>
                </form> 
            </div>  
        </div>
    </nav>
    <!-- body content -->
    <div class="container"> 
        <h3 align="center">COMMODITY:</h3>
        <div class="row">
            <?php 
            // on image click fetch object id for unique identification
            if(isset($_GET["id"])){
                $idcommodity = mysqli_real_escape_string ($connection, $_GET['id']);
                $commodity = mysqli_query($connection, "SELECT * FROM commodity_table WHERE idcommodity=$idcommodity");

                // echo mysqli_error($connection);
                $queryresults = mysqli_num_rows($commodity);

                if( $queryresults > 0 ){
                    while( $row = mysqli_fetch_array( $commodity )) { 
                        ?>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <?php 
                            $vendor ="SELECT username FROM vendor WHERE idvendor = ".$row['idvendor'];
                            $vendor = mysqli_query($connection, $vendor);
                            $vendor =  mysqli_fetch_array( $vendor )[0];

                            //average rating query
                            $query1="SELECT AVG(ratings) FROM commodity_ratings WHERE idcommodity = $idcommodity";
                            $rating= mysqli_query($connection, $query1);
                            $rating=mysqli_fetch_array($rating)[0];
                            ?>  
                            <div style="border: 1px solid #333;   background-color: #f1f1f1; border-radius:5px; padding:16px; align="center">
                                <img class=class="img-thumbnail" alt="Cinque Terre" width="100px" height="100px" src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?>"/>
                                <p class="text-info">Commodity Name: <?php echo $row["commodityname"]; ?></p>
                                <p class="text-info"> Uploaded by Vendor: <?php echo $vendor; ?></p>
                                <h4 class="text-danger">Ksh <?php echo $row["commodityprice"]; ?></h4>
                                <div class="commodity-rating">Rating:<?php echo round($rating)?>/5</div>
                                <div class="commodity-rate">
                                    Rate commodity:
                                    <?php foreach(range(1, 5) as $rating): ?>
                                        <a href="rate.php?commodity=<?php echo $idcommodity ?>&rating=<?php echo $rating?>"><?php echo $rating?></a>
                                    <?php endforeach;?>

                                </div>

                            </div>
                        </div> 
                        <?php
                    }
                }else {echo "Invalid Commodity id!" ;}}
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