<?php
$email='';
$username='';
$errors = array();

//include connection to data base
include "connection.php";

// check if user has clicked the login up button
if(isset($_POST['login']))
{	

//Get data from data base
	$category = mysqli_real_escape_string($connection, $_POST['category']);	
	$email	= mysqli_real_escape_string($connection, $_POST['email']);	
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password	= mysqli_real_escape_string($connection, md5($_POST['password']));

	if(empty($username)){
		array_push($errors, "Username is required");
	}
	if(empty($email)){
		array_push($errors, "Email is required");
	}
	if(empty($password)){
		array_push($errors, "Password is required");
	}


//admin
	$query1 = mysqli_query($connection, "SELECT * FROM admin WHERE category='$category' AND email='$email' AND username='$username'  AND  password='$password'");
	if(mysqli_num_rows($query1) == 0)
	{
		if(empty($errors)){
			array_push($errors, "Username or Password Incorrect");
		}
	}
	else
	{
		$row1 = mysqli_fetch_assoc($query1);
		$_SESSION['username']=$row1['username'];
		$_SESSION['admin'] = $row1['category'];


		if($_SESSION['admin'] == $row1['category'])
		{
			header("Location: haladmin.php");
		}
		else
		{
			if(empty($errors)){
				array_push($errors, "Page doesnt Exist");
			}
		}
	}

//vendor
	$query2 = mysqli_query($connection, "SELECT * FROM vendor WHERE category='$category'  AND email='$email' AND username='$username' AND password='$password'");
	if(mysqli_num_rows($query2) == 0)
	{
		if(empty($errors)){
			array_push($errors, "Username or Password Incorrect");
		}
	}
	else
	{
		$row2 = mysqli_fetch_assoc($query2);
		$_SESSION['username']=$row2['username'];
		$_SESSION['vendor'] = $row2['category'];

		if($_SESSION['vendor'] == $row2['category'])
		{
			header("Location: halvendor.php");
		}
		else
		{
			if(empty($errors)){
				array_push($errors, "Page doesnt exist");
			}
		}
	}

//customer
	$query3 = mysqli_query($connection, "SELECT * FROM customer WHERE category='$category' AND email='$email' AND username='$username' AND password='$password'");
	if(mysqli_num_rows($query3) == 0)
	{
		if(empty($errors)){
			array_push($errors, "Username or Password Incorrect");
		}
	}
	else
	{
		$row3 = mysqli_fetch_assoc($query3);
		$_SESSION['username']=$row3['username'];
		$_SESSION['customer'] = $row3['category'];

		if($_SESSION['customer'] == $row3['category'])
		{
			header("Location: halcustomer.php");
		}
		else
		{
			if(empty($errors)){
				array_push($errors, "Page doesnt exist");
			}
		}
	}
}			
?>
