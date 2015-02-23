<!doctype html>
<html>
<head>
	<!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
    <title>FEU Cavite AES</title>
</head>
<body id="no_padding">

<?php

include_once("connection_string_connection_string.php");
include_once("functions/db_functions.php");

function display_print($id)
{
	$con = $GLOBALS['dbh'];
	$pf = getInfo($id);
	$fn = $pf['fn'];
	$ln = $pf['ln'];
	$uname = $pf['uname'];
	$uname = strtoupper($uname);
	$name = "$ln, $fn";
	$name = strtoupper($name);
	$class_count = countClasses($id);
	echo "
		<div class='container'>
			<div class='centerthis'>
				<span class='boldme'>FEU CAVITE</span>
				<br>
				<span class='boldme'>Automated Evaluation System Mk I
				<br>
				Evaluation Report
				</span>
			</div>
			<div class='container'>
			Name:<b>$name</b><br>
			Number of classes teaching:<b>$class_count</b> <br><br>
		";
		getContentTable($id, $uname);

		echo "
			
			</div>
		</div>
		";
}
function getInfo($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof where id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
function getContentTable($id, $uname)
{
	$con = $GLOBALS['dbh'];
	$select_subj = "SELECT * FROM tbl_subjects WHERE Prof = '$uname'";
	foreach($con->query($select_subj) as $row)
	{
		$subj_id = $row['id'];
		$subj = $row['SubjDesc'];
		$section = $row['SecCode'];
		echo "
		<!-- start of subject -->
			<h5>Subject:<span class='boldme'>$subj</span> Year Level and Section:<span class='boldme'>$section</span></h5>
			<table class='table'>
				<thead>
					<tr>
						<th></th>
						<th>Question</th>
						<th>Rate 5</th>
						<th>Rate 4</th>
						<th>Rate 3</th>
						<th>Rate 2</th>
						<th>Rate 1</th>
					</tr>
				</thead>
				<tbody>
					";
					getTableRow($id, $subj_id, $section);
					echo"
				</tbody>
			</table>
			<!-- end of table subjects -->
		";
	}
	
}
function getTableRow($id, $subj, $section)
{
	$form = 0;
	if($section == "G04-PRUDENCE" || $section == "G05-JOY")
	{
		$form = 1;
	}
	else
	{
		$form = 2;
	}
	$i = 1;
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_ques_cat where form = '$form'";
	foreach($con->query($select) as $row)
	{
		$cat_id = $row['id'];
		$content = $row['content'];
		
		$select_ques = "SELECT * FROM tbl_ques_main where category = '$cat_id'";
		foreach($con->query($select_ques) as $row2)
		{
			$ques_id = $row2['id'];
			$ques = $row2['question'];

			$doneStuds = countDoneStudents($id, $subj);

			echo "
				<tr>
					<td>$i</td>
					<td>$ques</td>
					<td>"; getRating($id, $subj, $ques_id, 5);echo "</td>
					<td>";echo getRating($id, $subj, $ques_id, 4);echo  "</td>
					<td>";echo getRating($id, $subj, $ques_id, 3);echo "</td>
					<td>";echo getRating($id, $subj, $ques_id, 2);echo"</td>
					<td>"; echo  getRating($id, $subj, $ques_id, 1); echo"</td>
				</tr>
				";
				$i++;
		}
		
	}
}
function getRating($id, $subj, $ques, $rate)
{
	$doneStuds = countDoneStudents($id, $subj);
	$con = $GLOBALS['dbh'];
	$rating = 5;
	$select = "SELECT count(*) from tbl_rating where prof_id = ? and subject_id = ? and ques_id = ? and rating = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id, $subj, $ques, $rate));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	if($count == 0)
	{
		echo "0 (0%)";
	}
	else
	{
		$percent = ($count/$doneStuds)*100;
		$percent = round($percent, 2);
		echo "$count ($percent%)";
	}
	
}
function countDoneStudents($prof_id, $subj_id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) from tbl_done where prof_id = ? and subj_id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof_id, $subj_id));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	return $count;
}

//INDIVIDUAL SUBJ***********************************************************************88
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
function indi_display_print($id, $subj)
{
	$con = $GLOBALS['dbh'];
	$pf = indi_getInfo($id);
	$fn = $pf['fn'];
	$ln = $pf['ln'];
	$uname = $pf['uname'];
	$uname = strtoupper($uname);
	$name = "$ln, $fn";
	$name = strtoupper($name);
	$class_count = countClasses($id);
	echo "
		<div class='container'>
			<div class='centerthis'>
				<span class='boldme'>FEU CAVITE</span>
				<br>
				<span class='boldme'>Automated Evaluation System Mk I
				<br>
				Evaluation Report
				</span>
			</div>
			<div class='container'>
			Name:<b>$name</b><br>
			Number of classes teaching:<b>$class_count</b> <br><br>
		";
		indi_getContentTable($id, $uname, $subj);

		echo "
			
			</div>
		</div>
		";
}
function indi_getInfo($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof where id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
function indi_getContentTable($id, $uname, $subj)
{
	$con = $GLOBALS['dbh'];
	$select_subj = "SELECT * FROM tbl_subjects WHERE Prof = '$uname' AND id = '$subj'";
	foreach($con->query($select_subj) as $row)
	{
		$subj_id = $row['id'];
		$subj = $row['SubjDesc'];
		$section = $row['SecCode'];
		echo "
		<!-- start of subject -->
			<h5>Subject:<span class='boldme'>$subj</span> Year Level and Section:<span class='boldme'>$section</span></h5>
			<table class='table'>
				<thead>
					<tr>
						<th></th>
						<th>Question</th>
						<th>Rate 5</th>
						<th>Rate 4</th>
						<th>Rate 3</th>
						<th>Rate 2</th>
						<th>Rate 1</th>
					</tr>
				</thead>
				<tbody>
					";
					indi_getTableRow($id, $subj_id, $section);
					echo"
				</tbody>
			</table>
			<!-- end of table subjects -->
		";
	}
	
}
function indi_getTableRow($id, $subj, $section)
{
	$form = 0;
	if($section == "G04-PRUDENCE" || $section == "G05-JOY")
	{
		$form = 1;
	}
	else
	{
		$form = 2;
	}
	$i = 1;
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_ques_cat where form = '$form'";
	foreach($con->query($select) as $row)
	{
		$cat_id = $row['id'];
		$content = $row['content'];
		
		$select_ques = "SELECT * FROM tbl_ques_main where category = '$cat_id'";
		foreach($con->query($select_ques) as $row2)
		{
			$ques_id = $row2['id'];
			$ques = $row2['question'];

			$doneStuds = indi_countDoneStudents($id, $subj);

			echo "
				<tr>
					<td>$i</td>
					<td>$ques</td>
					<td>"; getRating($id, $subj, $ques_id, 5);echo "</td>
					<td>";echo getRating($id, $subj, $ques_id, 4);echo  "</td>
					<td>";echo getRating($id, $subj, $ques_id, 3);echo "</td>
					<td>";echo getRating($id, $subj, $ques_id, 2);echo"</td>
					<td>"; echo  getRating($id, $subj, $ques_id, 1); echo"</td>
				</tr>
				";
				$i++;
		}
		
	}
}
function indi_getRating($id, $subj, $ques, $rate)
{
	$doneStuds = indi_countDoneStudents($id, $subj);
	$con = $GLOBALS['dbh'];
	$rating = 5;
	$select = "SELECT count(*) from tbl_rating where prof_id = ? and subject_id = ? and ques_id = ? and rating = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id, $subj, $ques, $rate));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	if($count == 0)
	{
		echo "0 (0%)";
	}
	else
	{
		$percent = ($count/$doneStuds)*100;
		$percent = round($percent, 2);
		echo "$count ($percent%)";
	}
	
}
function indi_countDoneStudents($prof_id, $subj_id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) from tbl_done where prof_id = ? and subj_id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof_id, $subj_id));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	return $count;
}

if(isset($_GET['id']))
{
	$id = $_GET['id'];
	display_print($id);
}
if(isset($_GET['prof']) && isset($_GET['subj']))
{
	$prof = $_GET['prof'];
	$subj = $_GET['subj'];
	indi_display_print($prof, $subj);


}


?>
</body>
</html>