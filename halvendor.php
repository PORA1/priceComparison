<!-- main vendor screen page -->
<?php
include "connection.php";
include('eduploadver.php');
?>
<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vendor Page</title>

  <!-- CSS -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- script -->
  <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
  <!--  Top Navigation  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="halvendor.php">PRICE COMPARISON</a>
      <!-- togglebutton -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
          <input class="form-control mr-sm-2" type="search" name="search" placeholder="Enter commodity/vendor name"  required style="width:300px;">
          <button class="btn btn-primary my-2 my-sm-0" type="submit" name="submit-search" > SEARCH
          </button>
        </form> 
      </div>  
    </div>    
  </nav>
  <!--  body content -->
  <div class="container">	
    <div>
      <h3>Vendor Account: <?php echo $_SESSION['username']; ?></h3>
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
            <form> <?php 

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
              <img  alt="Cinque Terre" width="100px" height="100px" src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?> "/>

              <ul style="list-style-type:none; padding:0; margin:0;">
                <li class="text-info"><?php echo $row["commodityname"]; ?></li>
                <li class="text-info"><?php echo $row["commoditybrand"]; ?></li>
                <li class="text-info"><?php echo $vendor; ?></li>
                <li class="text-danger"><?php echo $currency ?><?php echo $row["commodityprice"]; ?></li>
                <div class="article-rating">Price Rating:<?php echo round($rating)?>/5 </div>
              </ul> 
                <!--  modal button to pop up dialog box -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit & Upload</button>
            </div><br/>
          </form>
            <!-- The form that pop ups on button click -->
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit and upload</h4>
                </div>
                <div class="modal-body">
                  <form role="form" action="eduploadver.php" method="post" enctype="multipart/form-data">
                    <!-- Display form errors here -->
                    <?php include('errors.php'); ?>
                    <div>
                      <img name="commodityimage2" width="100px" height="100px" src = "/multilevel/assets/img/commodityimages/<?php echo $row['commodityimage']; ?>"> </img>
                    </div> 
                    <div class="form-group">
                      <input type="text" name="commodityname" class=" form-control" id="commodity-name" value="<?php echo $row["commodityname"]; ?>" readonly>
                    </div>

                    <div class="form-group">
                      <label> Commodity Price</label>
                      <input type="text" name="commodityprice"  class=" form-control" id="commodity-price">
                    </div>
                    <button type="submit" name="upload1commodity" class="btn btn-primary">Upload</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <?php
      }
    }
    ?>
  </div>
</div>

<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">&copy; 2018-<?php echo date("Y");?></p>
  </div>
</footer> 
<script>
// modal pop up function
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script> 
</body>
</html>