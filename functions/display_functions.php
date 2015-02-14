<?php

include_once("functions/logic_functions.php");
include_once("functions/db_functions.php");


function display_subjects()
{
	$id = $_SESSION['student'];
	$section = getSection($id);
	


	echo "
		<div class='subject_header'>
			<h1>CHOOSE A SUBJECT</h1>
		  </div>
				";
				getSubjects($section);
				
}
function display_form1($id, $prof, $subject)
{
	$stud_ = $_SESSION['student'];
	$stud = getAllInfo($stud_);
	$fn = $stud['FName'];
	$ln = $stud['LName'];
	$name = "$fn $ln";
	//prof
	$pro = getProfInfo($prof);
	$pfn = $pro['fn'];
	$pfn = strtoupper($pfn);
	$pln = $pro['ln'];
	$pln = strtoupper($pln);
	$p_img  = $pro['image'];
	$prof_name = "$pfn $pln";

	//subject
	$sub = getSubjInfo($subject);
	$subject = $sub['SubjDesc'];
	$subj_id = $sub['id'];
	echo "
		<div class='col-sm-7'>
          <div class='panel panel-default'>
            <div class='panel-heading'>
              <h3 class='panel-title'>
              Student: <b>$name</b>
             <div id='right_align'>
              			Student Number: <b>$stud_</b>
              		</div>
              </h3>
              </div>
              <div class='panel-body'>

              
              	<h3 class='centerthis boldme'>PERFORMANCE INDICATORS</H3>
              	Directions: Rate your teacher's performance on the following
              	items by encircling the number that best indicates your answer
              	as truthful as possible. There is no right or wrong answer,
              	please do not leave any items unanswered.
              	<br>
              	The number rating stands for the following:<br>
              	 <h4>
			        <span class='label label-success'>5 = Always</span>
			        <span class='label label-success'>4 = Most of the time</span>
			        <span class='label label-success'>3 = Sometimes</span>
			        <span class='label label-success'>2 = Once in a while</span>
			        <span class='label label-success'>1 = Never</span>
			        
			      </h4>
              	<div class='well'>
              	<form onsubmit='return validateForm();' action='functions/db_functions.php' method='post'>
				";
				getQuestions(1, $prof, $subj_id);
				echo"
				<button type='submit' class='btn btn-success form-control' name='btn_evaluate' >Submit</button>
				</form>
				</div><!--end of well -->
			</div><!--end of panel-body -->
			</div>
		</div>
		
		<!--prof div -->
		<div class='col-sm-5'>
			 <div class='panel panel-success fixed'>
	            <div class='panel-heading'>
	              <h3 class='panel-title'>Instructor: <b>$prof_name</b></h3>
	            </div>
	            <div class='panel-body'>
	             	
	             	<div class=subjcontainer>
	             		<img src=$p_img />
	             		<br>

	             		Subject Teaching:
	             			<b>$subject</b>
	             	</div>



	            </div>
	          </div>
	         </div>
		";
}
function display_form2($id, $prof, $subject)
{
	$stud_ = $_SESSION['student'];
	$stud = getAllInfo($stud_);
	$fn = $stud['FName'];
	$ln = $stud['LName'];
	$name = "$fn $ln";
	//prof
	$pro = getProfInfo($prof);
	$pfn = $pro['fn'];
	$pfn = strtoupper($pfn);
	$pln = $pro['ln'];
	$pln = strtoupper($pln);
	$p_img  = $pro['image'];
	$prof_name = "$pfn $pln";

	//subject
	$sub = getSubjInfo($subject);
	$subject = $sub['SubjDesc'];
	$subj_id = $sub['id'];
	echo "
		<div class='col-sm-7'>
          <div class='panel panel-default'>
            <div class='panel-heading'>
              <h3 class='panel-title'>
              Student: <b>$name</b>
             <div id='right_align'>
              			Student Number: <b>$stud_</b>
              		</div>
              </h3>
              </div>
              <div class='panel-body'>

              
              	<h3 class='centerthis boldme'>PERFORMANCE INDICATORS</H3>
              	Directions: Rate your teacher's performance on the following
              	items by encircling the number that best indicates your answer
              	as truthful as possible. There is no right or wrong answer,
              	please do not leave any items unanswered.
              	<br>
              	The number rating stands for the following:<br>
              	 <h4>
			        <span class='label label-success'>5 = Always</span>
			        <span class='label label-success'>4 = Most of the time</span>
			        <span class='label label-success'>3 = Sometimes</span>
			        <span class='label label-success'>2 = Once in a while</span>
			        <span class='label label-success'>1 = Never</span>
			        
			      </h4>
              	<div class='well'>
              	<form  onsubmit='return validateForm();' action='functions/db_functions.php' method='post'>
				";
				getQuestions(2, $prof, $subj_id);
				echo"
				<button type='submit' class='btn btn-success form-control' name='btn_evaluate' >Submit</button>
				</form>
				</div><!--end of well -->
			</div><!--end of panel-body -->
			</div>
		</div>
		
		<!--prof div -->
		<div class='col-sm-5'>
			 <div class='panel panel-success fixed'>
	            <div class='panel-heading'>
	              <h3 class='panel-title'>Instructor: <b>$prof_name</b></h3>
	            </div>
	            <div class='panel-body'>
	             	
	             	<div class=subjcontainer>
	             		<img src=$p_img />
	             		<br>

	             		Subject Teaching:
	             			<b>$subject</b>
	             	</div>



	            </div>
	          </div>
	         </div>
		";
}
