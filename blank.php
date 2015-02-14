<?php

include_once("connection_string_connection_string.php");

function blank()
{
	echo "<table border=1>
			<tr>
				<td>Subject</td>
				<td>Subject Description</td>
				<td>Section</td>
				<td>TEACHER</td>
			</tr>
		";
	$con = $GLOBALS['dbh'];
	$select = "SELECT * FROM tbl_subjects where Prof = '-'";
	foreach($con->query($select) as $row)
	{
		$subject = $row['Subject'];
		$desc = $row['SubjDesc'];
		$section = $row['SecCode'];

		echo "
			<tr>
				<td>$subject</td>
				<td>$desc</td>
				<td>$section</td>
				<td><br></td>
			";
	}
	echo "</table>";
}
blank();