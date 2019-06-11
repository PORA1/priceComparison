<?php
//include connection to data base	
include "connection.php";

$username='';
$email='';   
$table='';
$errors = array();


//Get data from sign up form
if(isset($_POST['register']))
{

	$category = mysqli_real_escape_string ($connection, $_POST['category']);
	$email	= mysqli_real_escape_string ($connection, $_POST['email']);	
	$username = mysqli_real_escape_string ($connection, $_POST['username']);
	$password = mysqli_real_escape_string ($connection, $_POST['password']);
	$confirmpassword = mysqli_real_escape_string ($connection, $_POST['confirmpassword']);
	$code=substr(md5(mt_rand()),0,15);

// echo "category=`$category`, email=`$email`, username=`$username`, password=`$password`, confirmpassword=`$confirmpassword`";

//ensure all fields are correct 
	if(empty($username)){
		array_push($errors, "Username is required");
	}
	if(empty($email)){
		array_push($errors, "Email is required");
	}
	if(empty($password)){
		array_push($errors, "Password is required");
	}
	if(empty($confirmpassword)){
		array_push($errors, "confirmpassword is required");
	}
	if($password != $confirmpassword){
		array_push($errors, "Two passwords do not match");
	}


// if there are no errors insert users into data base verify_user

	if(count($errors) == 0){

$password=md5($confirmpassword);// encrypt password before storing into data base
$insert=mysqli_query($connection,"INSERT INTO verify_user (id,category,email,username,password,code) VALUES ('','$category','$email','$username','$password','$code')");

$db_id=mysqli_insert_id($connection);

// $message = "Your Activation Code is ".$code."";

//email function initialized and called 
$to=$email;
$subject="Activation Code For Pricecomparison.com";
$from = 'pricecomparison14@gmail.com';
global $body;
$body='Your Activation Code is '.$code.' Please Click On This <a href="signupver.php?id='.$db_id.'&code='.$code.'">Link </a>to activate your account.';
$headers = "From:".$from;
echo "$body";
// mail($to,$subject,$body,$headers);

// echo " An Activation Code has been sent to You, Check You email";	

}	

}



if (isset($_GET['id']) && isset($_GET['code']))
{
	$id=$_GET['id'];
	$code=$_GET['code'];
	$select=mysqli_query($connection,"SELECT  category, email,username,password FROM
		verify_user WHERE code ='$code' AND id='$id' ");

	if(mysqli_num_rows($select) == 1)

	{

		while ($row=mysqli_fetch_row($select))
		{
			$category=$row[0];
			$email=$row[1];
			$username=$row[2];
			$password=$row[3];
		}
// echo "category=`$category`, email=`$email`, username=`$username`, password=`$password`";

		if($category=='admin')
			{$table='admin';}

		else if($category=='customer')
			{$table='customer';}

		else{$table='vendor';}

		$insert_user=mysqli_query($connection,"insert into ".$table. " (id".$table.", category, email, username, password) VALUES ('','$category', '$email','$username','$password')");
// echo mysqli_error($connection);

		$delete=mysqli_query($connection,"delete from verify_user where id='$id' and code='$code'");

		if($insert_user == 1)
		{
			header("Location: index.php");

		}
	}

} 


?>