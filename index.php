<!-- This page contains the login page  -->
<?php
session_start();
if($_SESSION){
    if($_SESSION['admin'])
    {
        header("Location: haladmin.php");
    }
    if($_SESSION['vendor'])
    {
        header("Location: halvendor.php");
    }
    if($_SESSION['customer'])
    {
        header("Location: halcustomer.php");
    }
}

include('loginver.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- css style sheets -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- scripts  -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.backstretch.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/placeholder.js"></script>
</head>

<body style="padding-top:0px;">
    <!-- jumbotron for page -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1>WELCOME TO CONSUMER GOODS' PRICE COMPARISON</h1>      
        </div>
    </div>

    <!-- Top content -->
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class=" col-md-3"></div>
                <div class=" col-md-6">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3> Login </h3>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                    <div class="form-bottom" class="login-form">
                        <form role="form"  method="post" class="login-form">
                            <!-- Display form errors here -->
                            <?php include('errors.php'); ?>

                            <div class="form-group category">
                                <label> <span class="glyphicon glyphicon-user"></span> Login as </label>
                                <select  class="form-control form-element" name='category'>
                                    <option class='drop-down'> Customer </option>   
                                    <option class='drop-down'> Vendor</option>       
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="form-email">Email</label>
                                <input type="text" name="email" placeholder="Email" class=" form-control" id="form-email"value="<?php echo $username?>">
                            </div>

                            <div class="form-group">
                                <label  for="form-username">Username</label>
                                <input type="text" name="username" placeholder="Username" class=" form-control" id="form-username"value="<?php echo $username?>">
                            </div>
                            <div class="form-group">
                                <label for="form-password">Password</label>
                                <input type="password" name="password" placeholder="Password" class=" form-control" id="form-password">
                            </div>
                            <button type="submit" name="login" class="btn">Login</button>
                            <p>
                                Not yet a member? <a href="signup.php"> Sign Up</a>
                            </p>
                        </form>
                    </div>
                </div>
                <div class=" col-md-3"></div>
            </div>
        </div>
    </div>       
</body>

</html>