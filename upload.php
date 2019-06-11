<!-- upload page for commoditities -->
<?php
// include('cekvendor.php');
include('uploadver.php');

// // extracts id vendor from vendor table and stores it in a variable
// $store_usr = $_SESSION['username'];
//     $pick_from = mysqli_query($connection, "SELECT idvendor FROM vendor WHERE username = '$store_usr';");
//      while ($row = $pick_from -> fetch_assoc())
//        {
//         $store = $row['idvendor'];
//        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>vendor upload page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>vendor</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

</head>
<body>
    <!--  Navigation  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed top">
        <div class="container">
            <a class="navbar-brand" href="halcustomer.php">PRICE COMPARISON</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

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
                        <a a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>  

                <form action="search.php" method="POST" class="form-inline my-2 my-lg-0" >
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search"  required>
                    <button class="btn btn-success-outline my-2 my-sm-0" type="submit" name="submit-search" > SEARCH</button>
                </form> 
            </div>  
        </div>

    </nav>
    <div class="container" style="margin-top:60px">	

        <h2>Upload Commodity to <?php echo $_SESSION['username']; ?> Account</h2>
        <div class="row">

            <form role="form" action="uploadver.php" method="post" class="col-md-6" enctype="multipart/form-data">
                <!-- Display form errors here -->
                <?php include('errors.php'); ?>
                <div class="form-group">
                    <label>Commodity Name</label>
                    <input type="text" name="commodityname" placeholder="Example: Lotion" class=" form-control" id="commodity-name" required="">
                </div>
                <div class="form-group">
                    <label>Commodity Brand</label>
                    <input type="text" name="commoditybrand" placeholder="Commodity(OMO):" class=" form-control" id="commodity-brand" required="">
                </div>
                <div class="form-group">
                    <label>Commodity Price</label>
                    <input type="text" name="commodityprice" placeholder="Commodity Price in kshs:" class=" form-control" id="commodity-price" required="">
                </div>
                <div class="form-group">
                    <label>Commodity Image</label>
                    <input type="file" name="commodityimage"  class="form-control-file" id="commodity-image" required="">
                </div>
                <button type="submit" name="uploadcommodity" class="btn btn-primary">Upload Commodity</button>
            </form>  
        </div>


    </div>
</body>
</html>