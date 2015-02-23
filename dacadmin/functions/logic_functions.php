<?php

include_once("connection_string_connection_string.php");
include_once("db_functions.php");


function checkCredentials($email, $password)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM admin_users WHERE email = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($email));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	$pw = $res['password'];
	$admin_id = $res['id'];
	if($password == $pw)
	{
		$_SESSION['admin'] = $admin_id;
		header("location:../index.php");
	}
	else
	{
		header("location:../login.php?error=1");
	}

}
function checkIfLogin()
{
	if(!isset($_SESSION['admin']))
	{
		header("location:login.php");
	}
}
function checkIfLoginIndex()
{
	if(isset($_SESSION['admin']))
	{
		header("location:index.php");
	}
}
function logout()
{
	unset($_SESSION['admin']);
	header("location:../login.php");
}



//buttons pressed
if(isset($_POST['admin_login']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	checkCredentials($email, $password);		
}
//logout
if(isset($_GET['logout']))
{
	logout();
}
//search
if(isset($_POST['btn_search']))
{
	$stud = $_POST['student'];
	$id = strstr($stud, ".", true);
	header("location:../index.php?page=students&id=$id");
}