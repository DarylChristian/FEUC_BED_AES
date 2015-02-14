<?php

include_once("db_functions.php");
include_once("connection_string_connection_string.php");
include_once("enc_functions.php");


function checkCredentials($id, $ln)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_students WHERE ID = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	$last_name = $res['LName'];

	if($ln == $last_name)
	{
		$_SESSION['student'] = $id;
		header("location:../index.php");
	}
	else
	{
		header("location:../login.php?error=1");
	}
	
	
}

function checkSessionIndex()
{
	if(!isset($_SESSION['student']))
	{
		header("location:login.php");
	}
}
function checkSessionLogin()
{
	if(isset($_SESSION['student']))
	{
		header("location:index.php");
	}
}
function logout()
{
	unset($_SESSION['student']);
	header("location:login.php");
}

//evaluation functions
function evaluatePerSubj($id, $prof, $subject)
{
	$prof_id = getProf($prof);
	$prof_id_enc = encrypt($prof_id);
	$prof_id_dec = decrypt($prof_id_enc);
	$subject_enc = encrypt($subject);
	//echo "$prof_id_enc, $prof_id_dec, $subject_enc";
	header("location:../index.php?prof=$prof_id_enc&subj=$subject_enc");
}
function redirectEvaluate($prof, $subject)
{
	$id = $_SESSION['student'];
	$level = getAllInfo($id);
	$lvl = $level['SecCode'];
	$lvl = substr($lvl, 0, 3);
	
	//student id_
	$s_id = getAllInfo($id);
	$stud_id = $s_id['id_'];

	if($lvl == "G04" || $lvl == "G05")
	{
		display_form1($stud_id, $prof, $subject);
	}
	elseif($lvl == "G06" || $lvl == "G07" || $lvl == "G08" || $lvl == "G09" || $lvl == "S4-")
	{
		display_form2($stud_id, $prof, $subject);
	}
}



//buttons pressed
if(isset($_POST['btn_login']))
{
	$id = $_POST['id_number'];
	$ln = $_POST['last_name'];
	$ln = strtoupper($ln);
	checkCredentials($id, $ln);
}
//evaluate per subject
if(isset($_POST['btn_evaluate']))
{
	$id = $_POST['student'];
	$prof = $_POST['prof'];
	$subject = $_POST['subject'];
	evaluatePerSubj($id, $prof, $subject);
}