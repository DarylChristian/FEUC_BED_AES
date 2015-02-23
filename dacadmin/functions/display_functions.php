<?php

include_once("functions/logic_functions.php");
include_once("functions/db_functions.php");

function display_reports()
{
	echo "
		<div class='container'>
		<h3>List of Teachers</h3>
			<!--<input type=text class='form-control' placeholder='Search...' />-->
			<table class='table table-striped'>
				<thead>
					<th>Rank</th>
					<th>Name</th>
					<th>Overall Rating</th>
					<th>View</th>
				</thead>
				<tbody>
		";
		getProfs();
		echo"
				</tbody>
			</table>
		</div>
		";
}
function display_students()
{

	echo "
		<div class='container'>
			<form action='functions/logic_functions.php' method='POST'>
			<div class='col-lg-6'>
				<div class='input-group'>
			      <input type='text' class='form-control' id='search_student' name='student' placeholder='Search Student Here...'>
			      <span class='input-group-btn'>
			        <button class='btn btn-default' type='submit' id='search_btn' name='btn_search'>Go!</button>
			      </span>
			    </div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
				</form>
				<div id='right_align'>
				<button class='btn btn-primary btn-md' name='add_student'  data-toggle=\"modal\" data-target=\"#myModal\" >
					Add Student
				</button>
				</div>

				<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
				  <div class='modal-dialog'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				        <h4 class='modal-title' id='exampleModalLabel'>Add Student</h4>
				      </div>
				      <div class='modal-body'>
				        <form action='functions/db_functions.php' method='POST'>
				          <div class='form-group'>
				            <label for='recipient-name' class='control-label'>ID NUMBER:</label>
				            <input type='text' class='form-control' id='recipient-name' name='id_num'>
				          </div>
				          <div class='form-group'>
				            <label for='message-text' class='control-label'>First Name:</label>
				            <input type='text' class='form-control' name='fn' />
				          </div>
				          <div class='form-group'>
				            <label for='message-text' class='control-label'>Middle Name:</label>
				            <input type='text' class='form-control' name='mn' />
				          </div>
				          <div class='form-group'>
				            <label for='message-text' class='control-label'>Last Name:</label>
				            <input type='text' class='form-control' name='ln' />
				          </div>
				          <div class='form-group'>
				            <label for='message-text' class='control-label'>Section:</label>
				           	<select class='form-control' name='section'>
				           	";
				           	getSections();
				           echo"
				           </select>
				           <div class='form-group'>
				            <label for='message-text' class='control-label'>Gender:</label>
				            	<select class='form-control' name='gender'>
				            		<option value='Male'>Male</option>
				            		<option value='Female'>Female</option>
				            	</select>
				          </div>
				          </div>
				      </div>
				      <div class='modal-footer'>
				        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				        <button type='submit' name='btn_new_stud' class='btn btn-primary'>Send message</button>
				        </form>
				      </div>
				    </div>
				  </div>
				</div>

			</div>
		</div>
		";
}
function display_sdetails($id)
{
	$res = getStudentStatus($id);
	$stud_id = $res['ID'];
	$fn = $res['FName'];
	$ln = $res['LName'];
	$section = $res['SecCode'];
	$gender = $res['Gender'];
	$name = "$fn $ln";
	$subjs = countStudentSubj($section);
	$status = checkStudStatus($id, $subjs, $section);
	echo "
		<div class='container'>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Student ID</th>
					<th>Name</th>
					<th>Section</th>
					<th>Gender</th>
					<th>Evaluation Status (number of subjects: $subjs)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>$stud_id</td>
					<td>$name</td>
					<td>$section</td>
					<td>$gender</td>
					<td>$status</td>
			</tbody>
			</table>
			</div><!--end of container-->
		";
}