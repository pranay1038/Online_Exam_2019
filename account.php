<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Account</title>
<!-- Downloaded minified css files of bootstrap[offline] -->
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/> 
 <!-- Downloaded minified css files of bootstrap[offline] -->   
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
  <!-- Download JS of Bootstrap[offline] -->
 <script src="js/jquery.js" type="text/javascript"></script>
  <!-- Download JS of Bootstrap[offline] -->
<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
 
  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>


<!-- alert msg -->
<?php
if (@$_GET['w']) {
    echo '<script>alert("'.@$_GET['w'].'");</script>';
}
?>
<!-- alert msg -->
</head>
<?php
include_once('dbcon.php');
?>

<body>
<div class="header">
  <div class="row">
    <div class="col-lg-6">
      <span class="logo">Online Exam</span></div>
        <div class="col-md-4 col-md-offset-2">
                  <?php
                    include('dbcon.php');
                    session_start();

                  if (!(isset($_SESSION['email']))) {
                    header("location:");
                    //index.php
                  }
                  else {
                    $name = $_SESSION['name'];
                    $email = $_SESSION['email'];

                    echo '<span class="pull-right top title1">
                    <span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    >&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span><a href="account.php?q=1" class="log log1">'.$name.'</a>
                    &nbsp;&nbsp;<a href="" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
                   //(logout.php?q=index.php)here the value of q = index.php this value goes to logout.php
                  }
                  ?>
        </div>
      </div>
    </div>
<div class="bg">

<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><b>Dashboard</b></a>
    </div>

    
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==1) echo 'class="active"'; ?> ><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==2) echo 'class="active"'; ?> ><a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
		<li <?php if(@$_GET['q']==3) echo 'class="active"'; ?> ><a href="account.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li>
		<li class="pull-right"> <a href=""><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Signout</a></li>
                        <!-- logout.php?q=index.php -->
		</ul>
            
      </div>
  </div>
</nav>
<div class="container">
<div class="row">
<div class="col-md-12">

<!--home start-->
<?php
if (@$_GET['q']==1) {
  
  $query = "SELECT * FROM quiz ORDER BY date DESC";
  $result = mysqli_query($connection,$query) or die('Error'); //create a connection to database table

  echo '<div class="panel"><div class="table-responsive">
          <table class="table table-striped title1">
          <tr>      
          <td><b>Serial No.</b></td>
          <td><b>Topic</b></td>
          <td><b>Total Question</b></td>
          <td><b>Marks</b></td>
          <td><b>Time Limit</b></td>
          <td></td>
          </tr>'; // table format in html tags

  $sn = 1; //serial no count

  while ($row = mysqli_fetch_array($result)) {
        
    $title = $row['title'];
    $total = $row['total'];
    $right = $row['right'];
    $time = $row['time'];
    $eid = $row['eid'];

    $query1 = "SELECT score FROM history WHERE eid='$eid' and email='$email'";  
    //checks in this history table whether the existing user attempted it or not
    $reslt = mysqli_query($connection,$query1) or die('Fatal Error');

    $rowcount = mysqli_num_rows($reslt);
    if ($rowcount == 0) { //checks if the user previously attempt the quiz or not, if no then execute this
      echo '<tr>
            <td>'.$sn++.'</td>
            <td>'.$title.'</td>
            <td>'.$total.'</td>
            <td>'.$right*$total.'</td>
            <td>'.$time.'&nbsp;min</td>
            
            <td><b><a href="account.php?q=quiz&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" 
            style="margin:1px;background:#2471A3">&nbsp;<span class="title1"><b>START</b></span></a></b></td>
            </tr>';   //this is for QUIZ START button
    }
    else {  //if yes then execute this
      echo '<tr style="color:#27AE60">
            <td>'.$sn++.'</td>
            <td>'.$title.'<span class="glyphicon glyphicon-ok"></span></td>
            <td>'.$total.'</td>
            <td>'.$right*$total.'</td>
            <td>'.$time.'</td>
            
            <td><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-repeat"></span>&nbsp;<span class="title1"><b>RESTART</b></span></a></td>
            </tr>';
    }
  }
  $sn=0;
  echo '</table></div></div>';
}
?>




<!--home closed-->

<!--quiz start-->

<!--quiz end-->




</div></div></div></div>
<!--Footer start-->
<div class="row footer">
<div class="col-md-3 box">
<a href="https://github.com/noobmaster007/Online_Exam_2019" target="_blank">Github Page</a>
</div>
<div class="col-md-3 box">
<a href="#" data-toggle="modal" data-target="#login">Admin Login</a></div>
<div class="col-md-3 box">
<a href="#" data-toggle="modal" data-target="#developers">Developers</a>
</div>
<div class="col-md-3 box">
<!-- Modal For Developers-->
<div class="modal fade title1" id="developers">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="btn-primary" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" style="font-family:'typo' "><span style="color:blue">Developers</span></h4>
      </div>
	  
      <div class="modal-body"> <!--div start-->
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="images/Pratip.jpg" width=100 height=100 alt="Pratip Sarkar" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="https://www.facebook.com/YuoCanCallMeZedi" target="_blank" style="color:#202020; font-family: 'Lato', sans-serif; font-size:18px" title="Find on Facebook">Pratip Sarkar</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 9614333732</h4>
		<h4 style="font-family:'typo' ">gablusarkar91@gmail.com</h4>
		<h4 style="font-family:'typo' ">Siliguri Institute of Technology, Siliguri</h4></div></div>
		</p>
      </div> <!--div end-->

      <div class="modal-body"> <!--div start-->
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="images/Sudipta.jpg" width=100 height=100 alt="Sudipta Gupta" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="https://www.linkedin.com/in/sudipta-gupta-03482a17a" target="_blank" style="color:#202020; font-family: 'Lato', sans-serif; font-size:18px" title="Find on LinkedIn">Sudipta Gupta</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 8145385398</h4>
		<h4 style="font-family:'typo' ">sudiptagupta14@gmail.com</h4>
		<h4 style="font-family:'typo' ">Siliguri Institute of Technology, Siliguri</h4></div></div>
		</p>
      </div> <!--div end-->
    
    <div class="modal-body"> <!--div start-->
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="images/Pranay.jpg" width=100 height=100 alt="Pranay Karmakar" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="https://www.linkedin.com/in/pranay-karmakar-6b1a82155" target="_blank" style="color:#202020; font-family: 'Lato', sans-serif; font-size:18px" title="Find on LinkedIn">Pranay Karmakar</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 7602458272</h4>
		<h4 style="font-family:'typo' ">pranaykarmakar9@gmail.com</h4>
		<h4 style="font-family:'typo' ">Siliguri Institute of Technology(SIT),Naxalbari </h4></div></div>
		</p>
      </div> <!--div end-->

    <div class="modal-body"> <!--div start-->
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="images/Bishal.jpeg" width=100 height=100 alt="Bishal Chanda" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="https://www.linkedin.com/in/bishal-chanda-ba2896194" target="_blank" style="color:#202020; font-family: 'Lato', sans-serif; font-size:18px" title="Find on LinkedIn">Bishal Chanda</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 8637868184</h4>
		<h4 style="font-family:'typo' ">bishalchanda2110@gmail.com</h4>
		<h4 style="font-family:'typo' ">Siliguri Institute of Technology, Siliguri</h4></div></div>
		</p>
      </div> <!--div end-->

    <div class="modal-body"> <!--div start-->
        <p>
		<div class="row">
		<div class="col-md-4">
		 <img src="images/Sakila.jpg" width=100 height=100 alt="Sakila Sultana" class="img-rounded">
		 </div>
		 <div class="col-md-5">
		<a href="#" style="color:#202020; font-family: 'Lato', sans-serif; font-size:18px" title="Find on Facebook">Sakila Sultana</a>
		<h4 style="color:#202020; font-family:'typo' ;font-size:16px" class="title1">+91 7583980837</h4>
		<h4 style="font-family:'typo' ">email id</h4>
		<h4 style="font-family:'typo' ">Siliguri Institute of Technology, Siliguri</h4></div></div>
		</p>
      </div> <!--div end-->  


    </div>
  </div>
</div>
<!--Modal for admin login-->
	 <div class="modal fade" id="login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><span style="color:blue;font-family:'typo' ">LOG IN</span></h4>
      </div>
      <div class="modal-body title1">
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">
<form role="form" method="" action="">
<div class="form-group">
<input type="email" name="uname" maxlength="50"  placeholder="Admin user id" class="form-control" required/> 
</div>
<div class="form-group">
<input type="password" name="password" id="myInput" maxlength="15" placeholder="Password" class="form-control" required/>
<input type="checkbox" onclick="myFunction()">Show Password
</div>
<div class="form-group" align="center">
<input type="submit" name="login" value="Login" class="btn btn-primary" />
</div>
</form>
</div><div class="col-md-3"></div></div>
      </div>
      
    </div>
  </div>
</div>


</body>
<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</html>
