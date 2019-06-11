<?php
session_start();

//checking if user already login
if(!isset($_SESSION['username'])){
	header('Location: index.php');
}
// if(!isset($_SESSION['search']))

//checking user's level
if($_SESSION['vendor']!="vendor"){
	header('Location: index.php');

}
?>