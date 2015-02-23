<?php

include_once("connection_string_connection_string.php");
session_start();

function getProfs()
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof ORDER BY ln";
	$i = 1;
	foreach($con->query($select) as $row)
	{
		$id = $row['id'];
		$fn = $row['fn'];
		$ln = $row['ln'];
		$name = "$ln, $fn";
		$uname = $row['uname'];
		$name = strtoupper($name);

		echo "
			<tr>
				<td>$i</td>
				<td>$name</td>
				<td>"; countEvaluators($id); echo"</td>
				<td>
					<button class='btn btn-primary btn-sm' name='view_subjs' data-toggle=\"modal\" data-target=\"#profModal_$id\" >
						View Subjects
					</button>
					<a href='print_report.php?id=$id' class='btn btn-primary btn-sm' >View All</a>
				</td>
			</tr>
			";
			$i++;

		echo "
			<div class='modal fade' id='profModal_$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
			  <div class='modal-dialog'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			        <h4 class='modal-title' id='exampleModalLabel'>SUBJECTS</h4>
			      </div>
			      <div class='modal-body'>
			     ";
			     	getSubjects($id, $uname);
			     echo"
			      </div>
			      <div class='modal-footer'>
			        <br>
			      </div>
			    </div>
			  </div>
			</div>
			";
	}
}
function getSubjects($id, $uname)
{
	$con = $GLOBALS['dbh'];
	$prof = strtoupper($uname);
	$select = "SELECT * FROM tbl_subjects where Prof = '$prof'";
	foreach($con->query($select) as $row)
	{
		$subj_id = $row['id'];
		$subjDesc = $row['SubjDesc'];
		$section = $row['SecCode'];
			echo "<a href='print_report.php?prof=$id&subj=$subj_id' >$subjDesc ($section)</a><br>";
	}
}

function countEvaluators($prof)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(DISTINCT student_id) FROM tbl_rating WHERE prof_id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$num = $res[0];

	$total = totalScore($prof);
	calculate($prof, $num, $total);
	
}
function totalScore($prof)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_rating WHERE prof_id = '$prof'";
	$total = 0;
	foreach($con->query($select) as $row)
	{
		$rating = $row['rating'];

		$total +=$rating;
	
	}	
	return $total;
}
function countDivisor($prof)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) FROM tbl_rating WHERE prof_id = '$prof'";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	return $count;
}
function calculate($prof, $evaluators, $total)
{
	//$con = $GLOBALS['dbh'];
	if($total == 0)
	{
		echo "<span id='red'>No evaluators yet</span>";
	}
	else
	{
		$divisor = countDivisor($prof);
		$ave = $total / $divisor;
		$ave = round($ave, 2);
		echo "<span id=green >$ave(out of 5)</span>";
	}
}

function countClasses($id)
{
	$con = $GLOBALS['dbh'];
	$prof = "SELECT * FROM tbl_prof where id = ?";
	$s = $con->prepare($prof);
	$s->execute(array($id));
	$ss = $s->fetch(PDO::FETCH_ASSOC);
	$prof_uname = $ss['uname'];
	$prof_uname = strtoupper($prof_uname);
	$select = "SELECT count(*) from tbl_subjects where Prof = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof_uname));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	return $count;
}
function getStudentStatus($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_students WHERE id_ = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
function countStudentSubj($section)
{
	$con = $GLOBALS['dbh'];
	$section1 = substr($section, 0, 7);
	$select = "SELECT count(*) FROM tbl_subjects WHERE SecCode LIKE '$section1%'";
	$stmt = $con->prepare($select);
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	return $count;
}
function checkStudStatus($id, $subjs, $section)
{
	$con = $GLOBALS['dbh'];
	

	$i = 0;
	$select_prof = "SELECT * FROM tbl_subjects where SecCode LIKE '$section%'";
	foreach($con->query($select_prof) as $row)
	{
		$subject_id = $row['id'];
		$prof_un = $row['Prof'];
		$prof_ = strtolower($prof_un);

		$find_prof = "SELECT * FROM tbl_prof WHERE uname = ?";
		$stmt2 = $con->prepare($find_prof);
		$stmt2->execute(array($prof_));
		$prof_id_ = $stmt2->fetch(PDO::FETCH_ASSOC);	
			$prof_id = $prof_id_['id'];
	
	$select_done = "SELECT count(*) FROM tbl_done WHERE stud_id = ? AND prof_id = ? AND subj_id = ?";
	$stmt3 = $con->prepare($select_done);
	$stmt3->execute(array($id, $prof_id, $subject_id));
	$res = $stmt3->fetch(PDO::FETCH_NUM);
	$rows = $res[0];
		if($rows == 1)
		{
			$i++;
		}	
	}

	if($i == 0)
	{
		return "<span id='red'>DID NOT LOG IN YET!</span>";
	}
	elseif($subjs <= $i)
	{
		return "<span id='green'>DONE EVALUATING</span>";
	}
	else
	{
		return "<span id='red'>NOT YET DONE</span>";
	}
	
}
function getSections()
{
	$con=$GLOBALS['dbh'];
	$select = "SELECT DISTINCT(SecCode) FROM tbl_students";
	foreach($con->query($select) as $row)
	{
		$section = $row['SecCode'];
		echo "<option value='$section'>
					$section
			</option>
			";
	}
}
function addStudent($id, $fn, $mn, $ln, $section, $gender)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) FROM tbl_students where ID = ?";
	$s = $con->prepare($select);
	$s->execute(array($id));
	$res = $s->fetch(PDO::FETCH_NUM);
	$count = $res[0];
	if($count == 0)
	{
	$insert = "INSERT INTO tbl_students (ID, LName, FName, MName, SecCode, Gender)
					VALUES (?,?,?,?,?,?)";
	$stmt = $con->prepare($insert);
	$stmt->execute(array($id, $ln, $fn, $mn, $section, $gender));
	header("location:../index.php?page=students&success=$id");
	}
	elseif($count > 0)
	{
		header("location:../index.php?page=students&error=$id");
	}
}

//buttons
if(isset($_POST['btn_search']))
{
	$stud = $_POST['student'];
	$id = strstr($stud, ".", true);
	getStudentStatus($id);
}
if(isset($_POST['btn_new_stud']))
{
	$id = $_POST['id_num'];
	$fn = $_POST['fn'];
	$mn = $_POST['mn'];
	$ln = $_POST['ln'];
	$section = $_POST['section'];
	$gender = $_POST['gender'];
	//strtoupper
	$fn = strtoupper($fn);
	$mn = strtoupper($mn);
	$ln = strtoupper($ln);
	addStudent($id, $fn, $mn, $ln, $section, $gender);
}