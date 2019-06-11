<?php
include('signupver.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signup</title>
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
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1>WELCOME TO CONSUMER GOODS' PRICE COMPARISON</h1>      
        </div>
    </div>
    <!-- Top content -->
    <div class="top-content">
        <div class="inner-bg">
            <div class="container">
                <div class="row">
                    <div class=" col-md-3"></div>
                    <div id="main-signup" class="col-md-6">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>SignUp</h3>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <form role="form" action="" method="post" class="signup-form">
                                <!-- Display form errors here -->
                                <?php  if (count($errors) > 0): ?>
                                    <div class="error">
                                        <?php foreach ($errors as $error): ?>
                                            <p><?php echo $error; ?></p>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>

                                <div class="form-group">
                                    <label> <span class="glyphicon glyphicon-user"></span> </span> Sign Up as: </label>
                                    <select  class="form-control form-element" name='category'>
                                        <option class='drop-down'> Customer </option>
                                        <option class='drop-down'> Vendor</option>        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Email</label>
                                    <input type="email" name="email" placeholder="Email" class=" form-control" id="form-email" value="<?php echo $email?>">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" placeholder="Username" class=" form-control" id="form-username"value="<?php echo $username?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password" class=" form-control" id="form-password">
                                </div>
                                <div class="form-group">
                                    <label> Confirm Password</label>
                                    <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control" id="form-password1">
                                </div>
                                <button type="submit" name="register" class="btn">Sign Up</button>
                                <p>
                                    Already a member? <a href="index.php"> Log in </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>