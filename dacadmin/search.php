<?php

require_once("conn.php");
$term = $_REQUEST['term'];
$term = strtoupper($term);
$rs = "SELECT * from tbl_students WHERE LName LIKE '%".$term."%' OR FName LIKE '%".$term."%' OR SecCode LIKE '%".$term."%'";
$data = array();
foreach($dbh->query($rs) as $row)
{
	$id = $row['id_'];
	 $ln= $row['LName'];
	 $fn= $row['FName'];
	 $fullname = "$id. $fn $ln";

	 $data[] = $fullname;
}
echo json_encode($data);