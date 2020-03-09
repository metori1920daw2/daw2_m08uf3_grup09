<?php
session_start(); 

if (isset($_SESSION['username']))
{

 include 'home.html';
 

}else{
	header('Location: login.php'); 	
}
// Log OUT
if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}
?>
