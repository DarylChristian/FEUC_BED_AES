<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>FEU Cavite AES Control Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
    <link href="jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    

    
   <!-- <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script> -->
    
     
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <?php
  		include_once("functions/logic_functions.php");
      include_once("functions/display_functions.php");
  		checkIfLogin();

      if(isset($_GET['page']))
      {
        $p = $_GET['page'];
      }
      else
      {
        header("location:index.php?page=home");
      }

  ?>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">FEU Cavite AES Control Panel MK I</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if($p == "home"){echo "class='active'";}  ?> ><a href="index.php?page=home">Home</a></li>
            <li class="dropdown">
              
            
            <li <?php if($p == "reports"){echo "class='active'";}  ?>><a href="index.php?page=reports">Reports</a></li>
            <li <?php if($p == "students"){echo "class='active'";}  ?>><a href="index.php?page=students">Students</a></li>
            <!--
            <li <?php if($p == "users"){echo "class='active'";}  ?>><a href="index.php?page=users">Users</a></li>
            <li <?php if($p == "gc"){echo "class='active'";}  ?>><a href="index.php?page=gc">General Configuration</a></li>
          -->
            <li><a href="functions/logic_functions.php?logout=1">Logout</a></li>


          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    	<?php 
            $page = $_GET['page'];
            if($page == "reports")
            {
              display_reports();
            }
            elseif($page == "students")
            {
              display_students();

              if(isset($_GET['id']))
              {
                $id = $_GET['id'];
                display_sdetails($id);
              }
              elseif(isset($_GET['success']))
              {
                  $id = $_GET['success'];
                echo "
                  <div class='container'>
                    <div class='alert alert-success alert-dismissible' role='alert'>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Success!</span>
                      Successfully added Student number $id
                    </div>
                  </div>
                    ";
              }
              elseif(isset($_GET['error']))
              {
                  $id = $_GET['error'];
                echo "
                  <div class='container'>
                    <div class='alert alert-danger alert-dismissible' role='alert'>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>
                      There's already a student with a student number of $id
                    </div>
                  </div>
                    ";
              }
            }

       ?>
    
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
      $( "#search_student" ).autocomplete({
        source:'search.php'

      });
      
      $('#search_btn').click(function(){
        $('#results').html(getContent());
      });

      function getContent()
      {
        var content = $('#search_student').val();
        return content;
      }
      function showUser(str)
      {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
      }
    </script>


  </body>
</html>
