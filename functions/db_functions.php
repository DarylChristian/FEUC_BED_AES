<?php

session_start();
include_once("connection_string_connection_string.php");
include_once("logic_functions.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getAllInfo($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_students WHERE ID = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}

function getSection($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_students WHERE ID = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	$section = $res['SecCode'];
	return $section;
}
function getSubjects($section)
{
	$con = $GLOBALS['dbh'];
	$sec = substr($section, 0, 9);
	$student = $_SESSION['student'];
	$stud = getAllInfo($student);
	$stud_id = $stud['id_'];
	$select = "SELECT * FROM tbl_subjects WHERE SecCode LIKE '$sec%'";
	$i = 0;
	
		
	echo "<div class='width_small'>";
	foreach($con->query($select) as $row)
	{
		$sub_id = $row['id'];
		$desc = $row['SubjDesc'];
		$prof = $row['Prof'];
		$prof_un = getProfByUname($prof);
		$prof_id = $prof_un['id'];
		
		echo "<div class='btn-group btn-group-justified' role='group' aria-label='...'>
			<div class='btn-group' role='group'>
				<form action='functions/logic_functions.php' method='POST'>
			    	<button type='submit' class='btn btn-success' name='btn_evaluateProf'"; 
			    		checkEvaluateStatus($stud_id, $prof_id, $sub_id); 
			    		echo ">$desc</button>
			    	<input type='hidden' name='student' value='$student' />
			    	<input type='hidden' name='prof' value='$prof' />
			    	<input type='hidden' name='subject' value='$sub_id' />
			    </form>
			</div>
			</div>
			";
			
		$i++;
	}

	echo "</div>";
}
function getSubjInfo($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_subjects WHERE id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
function getProf($prof)
{
	$con = $GLOBALS['dbh'];
	$prof = strtolower($prof);
	$select = "SELECT * FROM tbl_prof WHERE uname = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($prof));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	$id = $res['id'];
	return $id;
}
//get the questions from the database
function getQuestions($form, $prof, $sub)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_ques_cat WHERE form = '$form'";
	foreach($con->query($select) as $row)
	{
		$cat_id = $row['id'];
		$content = $row['content'];

		echo "<tr>
				<td colspan = 2>
					<div class='italic_bold bg_white'>$content</div>
				</td>
			</tr>";
		getMainQues($cat_id, $prof, $sub);

	}
}
function getMainQues($cat_id, $prof, $sub)
{
	$s = $_SESSION['student'];
	$ss = getAllInfo($s);
	$s_id = $ss['id_'];
	$con = $GLOBALS['dbh'];
	$i = 1;
	$select = "SELECT * FROM tbl_ques_main WHERE category = '$cat_id'";
	
	foreach($con->query($select) as $row)
	{
		$id = $row['id'];
		$ques = $row['question'];

		echo "
				<tr>
				<td>$i. $ques</td>
				
				<input type='hidden' name='hidden_student_id' value=$s_id />
				<input type='hidden' name='hidden_prof_id' value=$prof />
				<input type='hidden' name='hidden_subj_id' value=$sub />
				<td>
			";
				getChoices($id);
			echo "
				</td>
					</tr>
				";
		$i++;
	}
}
function getChoices($id)
{
	echo "	<div class='question'>
				<input type='radio' name='$id' title='5 = Always' value=5  />
				<input type='radio' name='$id' title='4 = Most of the time' value=4 />
				<input type='radio' name='$id' title='3 = Sometimes' value=3 />
				<input type='radio' name='$id' title='2 = Once in a while' value=2 />
				<input type='radio' name='$id' title='1 = Never' value=1 />
			</div>
		";
}
function getProfInfo($id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof WHERE id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($id));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
function getProfByUname($uname)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof WHERE uname = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($uname));
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	return $res;
}
//evaluate



//buttons pressed
if(isset($_POST['btn_evaluate']))
{
	$con = $GLOBALS['dbh'];
	$i = 0;
	$stud_id = $_SESSION['student'];
	$s_id = getAllInfo($stud_id);
	$id = $s_id['id_'];
	$prof = $_POST['hidden_prof_id'];
	$subj = $_POST['hidden_subj_id'];
	foreach($_POST as $key => $value)
	{
		
		$insert = "INSERT INTO tbl_rating (student_id, prof_id, subject_id, ques_id, rating) VALUES (?, ?, ?, ?, ?)";
		$stmt = $con->prepare($insert);
		$stmt->execute(array($id, $prof, $subj, $key, $value));
		$delete = "DELETE FROM tbl_rating WHERE ques_id = ?";
		$del = $con->prepare($delete);
		$del->execute(array($i));

		
		echo "STUD: $id PROF: $prof SUBJECT: $subj - $key - $value<br>";
	}
	//set done
		$done = "INSERT INTO tbl_done (stud_id, prof_id, subj_id) VALUES (?, ?, ?)";
		$d = $con->prepare($done);
		$d->execute(array($id, $prof, $subj));
		header("location:../index.php");
	
}
function checkEvaluateStatus($stud_id, $prof_id, $subj_id)
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) FROM tbl_done WHERE stud_id = ? AND prof_id = ? AND subj_id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($stud_id, $prof_id, $subj_id));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$rows = $res[0];
	if($rows == 1)
	{
		echo "disabled";
	}
}

function checkIfDone($prof, $subj)
{
	$stud = $_SESSION['student'];
	$s = getAllInfo($stud);
	$stud_id = $s['id_'];
	$con = $GLOBALS['dbh'];
	$select = "SELECT count(*) FROM tbl_done WHERE stud_id = ? AND prof_id = ? AND subj_id = ?";
	$stmt = $con->prepare($select);
	$stmt->execute(array($stud_id, $prof, $subj));
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$rows = $res[0];
	if($rows == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//
function checkStudStatus()
{
	$con = $GLOBALS['dbh'];
	$student = $_SESSION['student'];
	$stud = getAllInfo($student);
	$stud_id = $stud['id_'];
	$section = getSection($student);
	$sec = substr($section, 0, 9);
	$select = "SELECT count(*) FROM tbl_subjects WHERE SecCode LIKE '$sec%'";
	$stmt = $con->prepare($select);
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_NUM);
	$subjects = $res[0];

	$i = 0;
	$select_prof = "SELECT * FROM tbl_subjects where SecCode LIKE '$sec%'";
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
	$stmt3->execute(array($stud_id, $prof_id, $subject_id));
	$res = $stmt3->fetch(PDO::FETCH_NUM);
	$rows = $res[0];
		if($rows == 1)
		{
			$i++;
		}	
	}
	echo "total subjects:$subjects<br>total done:$i";
	if($subjects <= $i)
	{
		logout();
	}
	else
	{

	}

	
	
}