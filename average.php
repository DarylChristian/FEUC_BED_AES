<?php

include_once("connection_string_connection_string.php");

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
	
}	return $total;
}
function calculate($prof, $evaluators, $total)
{
	//$con = $GLOBALS['dbh'];
	$ave = ($total / $evaluators);
	echo $ave;
}

function showProf()
{
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_prof";
	foreach($con->query($select) as $row)
	{
		$id = $row['id'];
		$uname = $row['uname'];

		echo "
			<option value=$id >$uname</option>
			";
	}
}
echo "<form method=POST>
		<select name='list_prof'>
		";
	showProf();
	echo "
		</select>
		<button type='submit' name='btn_submit' >GO</button>
		</form>";
//countEvaluators();

if(isset($_POST['btn_submit']))
{
	$prof = $_POST['list_prof'];
	countEvaluators($prof);
}