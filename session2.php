<?php
session_start();
   
if(!isset($_SESSION['user'])){
	header("location:index2.php");
	}
?>