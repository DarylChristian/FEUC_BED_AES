<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="../../favicon.ico">
		<title>Faculty Evaluation Sys Mk I</title>

	    <!-- Bootstrap core CSS -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <!-- Bootstrap theme -->
	    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

	    <!-- Custom styles for this template -->
	    <link href="css/custom.css" rel="stylesheet">

	    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	    <script src="js/ie-emulation-modes-warning.js"></script>

	    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

	   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		  <link rel="stylesheet" href="/resources/demos/style.css">
		 <script>
		  $(function() {
		    $( "#slider" ).slider({
		      value:3,
		      min: 1,
		      max: 6,
		      step: 1,
		      slide: function( event, ui ) {
		        $( "#amount" ).val(  + ui.value );
		      }
		    });

		    var rate1 = "No comment";
		    var rate2 = "Poor";
		    var rate3 = "Fair";
		    var rate4 = "Good";
		    var rate5 = "Very Good";
		    var rate6 = "Excellent";
		    	
		    		 $( "#amount" ).val(  + $( "#slider" ).slider( "value" ) );
		    	
		   
		  });
		  </script>

		  <?php 
		  	include_once("functions/display_functions.php");
		  	include_once("functions/logic_functions.php");

		  	//check session
		  	checkSessionIndex();

		  	checkStudStatus();
			?>

	  </head>

	  <body role="document">
	  		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		      <div class="container">
		      	<div class=centerthis>
				<div class=feulogo>
		        	<img src=images/feulogo.png />
		        </div>
		       	</div>
		       </div>
		    </div>
		   
		  	
		    <div class="centerthis">
		    	<b>FACULTY EVALUATION SYSTEM MK I</b>
		    	<Br><Br>
		    </div>

			   	<div class="container">
			   		<?php

						if(!isset($_GET['prof']) && !isset($_GET['subj']))
						{
							display_subjects(); 
						}
						else
						{
							$prof = $_GET['prof'];
							$subj = $_GET['subj'];
							$prof_dec = decrypt($prof);
							$subj_dec = decrypt($subj);
							$done = checkIfDone($prof_dec, $subj_dec);
							if($done == true)
							{
								header("location:index.php");
							}
							elseif($done == false)
							{
								redirectEvaluate($prof_dec, $subj_dec);
							}
						}
			   		?>
			   	</div>

		   
			</div><!-- end of container -->


	   
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/docs.min.js"></script>
	    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	    <script src="js/ie10-viewport-bug-workaround.js"></script>	


	    <!-- form validation -->
	<script type="text/javascript">
      function validateForm() {
        var questions = document.getElementsByClassName("question"),
            formValid = true;
        for( var j=0; j<questions.length; j++ ) {
            if( !isOneInputChecked(questions[j], "radio") ) {
                formValid = false;
            }
        }
        alert(formValid ? "Submission Succesful. Click OK to continue." : "Please try to answer all items.");
        return formValid;
    }
    function isOneInputChecked(sel) {
        /* Based on code by Michael Berkowski
         * Ref: http://stackoverflow.com/questions/13060313/checking-if-at-least-one-radio-button-has-been-selected-javascript#answer-13060348
        */        
        // All <input> tags...
        var inputs = sel.getElementsByTagName('input');
        for (var k=0; k<inputs.length; k++) {
            // If you have more than one radio group, also check the name attribute
            // for the one you want as in && chx[i].name == 'choose'
            // Return true from the function on first match of a checked item
            if( inputs[k].checked )
                return true;
        }
        // End of the loop, return false
        return false;
    }

    </script>		
    <!--end of form validation-->
	 </body>
	 </html>