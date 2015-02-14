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

		  	//check session
		  	checkSessionIndex();
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
		   
		  	
		    <div class=centerthis>
		    	<b>INSTRUCTOR EVALUATION FORM</b>
		    	<Br><Br>
		    </div>

		   	<div class=container>
			 
		   	<!--
			 <div class=left_container>
			 	<div class=headings>
			 		<div class=left_align>Student: <b>Daryl Christian M. Cabacungan </b></div>
			 		<div class=right_align>Student Number:<b>20141925</b></div>
			 	</div>
			 </div>
			-->
			<div class="col-sm-7">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
              	
              		Student: <b>Daryl Christian M. Cabacungan</b>
       
              		<div id="right_align">
              			Student Number: <b>20141925</b>
              		</div>
              </h3>
            		</div>
            <div class="panel-body">
            	
            		Rate the teacher on each item following the given rating scale.
            		<br>

            	 <h4>
			        <span class="label label-success">6 = Excellent</span>
			        <span class="label label-success">5 = Very Good</span>
			        <span class="label label-success">4 = Good</span>
			        <span class="label label-success">3 = Fair</span>
			        <span class="label label-success">2 = Poor</span>
			        <span class="label label-success">1 = No Comment</span>
			        
			      </h4>


              <p>
				  <label for="amount">Rate:</label>
				  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
				</p>
				 <div class=slidercontainer>
					<div id="slider"></div>
				</div>
				<div class=designer>
					<ul>
						<li id="first">No Comment</li>
						<li id="second">Poor</li>
						<li id="third">Fair</li>
						<li id="fourth">Good</li>
						<li id="fifth">Very Good</li>
						<li id="sixth">Excellent</li>
					</ul>
				</div>
             

            </div>
          </div>
         </div><!-- /.col-sm-4 -->

         	<div class="col-sm-5">
			 <div class="panel panel-success fixed">
	            <div class="panel-heading">
	              <h3 class="panel-title">Instructor: <b>Cruz, Jillibelle P.</b></h3>
	            </div>
	            <div class="panel-body">
	             	
	             	<div class=subjcontainer>
	             		<img src=images/subjects/1.jpg />
	             		<br>

	             		Subject Teaching:
	             			<b>Website Development</b>
	             	</div>



	            </div>
	          </div>
	         </div>
			</div><!-- end of container -->

		


	   
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/docs.min.js"></script>
	    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	    <script src="js/ie10-viewport-bug-workaround.js"></script>	

	 </body>
	 </html>